<?php

namespace App\Http\Controllers;

use App\Models\DataTarget;
use App\Models\Kecamatan;
use App\Models\PilihanTarget;
use App\Models\Provinsi;
use App\Models\Soal;
use App\Models\SoalHasKecamatan;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function riwayat(Request $request){
        $data = DataTarget::withCount('pilihanTarget')->where("user_survey_id", auth()->user()->id)->orderBy('id', 'desc')->get();
        $countSoal = Soal::count();
        return Inertia::render("ListQuiz", [
            'data_target' => $data,
            'count_soal' => $countSoal
        ]);
    }
    public function index(Request $request){
        $data = Soal::with('pilihan')->get();

        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();

        $k = $request->k;

        return Inertia::render("Survey", [
            'data_soal' => $data,
            'provinsi' => $provinsi,
            'k' => $k
        ]);
    }

    public function inputDataTarget(Request $request){
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required',
            'provinsi' => 'required|exists:provinsis,id_provinsi',
            'kota' => 'required|exists:kotas,id_kota',
            'kecamatan' => 'required|exists:kecamatans,id_kecamatan',
            'desa' => 'required|exists:desas,id',
        ]);

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'user_survey_id' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ];

        $data['provinsi_id'] = $request->provinsi;
        $data['kota_id'] = $request->kota;
        $data['kecamatan_id'] = $request->kecamatan;
        $data['desa_id'] = $request->desa;


        $insertData = DB::table('data_targets')->insertGetId($data);

        return redirect()->route('quiz', $insertData)->with('success', "Berhasil simpan data");
    }

    public function quiz(Request $request, $id){

        $target = DataTarget::findOrFail($id);

        $lastPilihan = DB::table('pilihan_targets')->where('data_target_id', $id)->orderBy('id', 'desc')->first();

        $lastSoalGeneral = Soal::doesntHave("hasKecamatan")->orderBy("id", 'desc')->first();

        $is_last_soal = false;
        $is_first_soal = true;
        $soalHasKecamatan = SoalHasKecamatan::where("kecamatan_id", $target->kecamatan_id)->get()->pluck("soal_id");

        if($lastPilihan){

            $is_first_soal = false;
            $isSoalGeneral = Soal::doesntHave("hasKecamatan")->where('id', $lastPilihan->soal_id)->first();
            $nextSoalGeneral = null;

            if($isSoalGeneral){
                $nextSoalGeneral = Soal::doesntHave("hasKecamatan")->where('id', ">", $lastPilihan->soal_id)->first();
            }

            // jika last soal general next soal kecamatan
            if($lastSoalGeneral->id === $lastPilihan->soal_id){

                $soal = Soal::with('pilihan')->whereIn("id", $soalHasKecamatan)->first();
                $cekLastSoal = Soal::orderBy('id', 'desc')->whereIn("id", $soalHasKecamatan)->first();

                if($soal->id >= $cekLastSoal->id){
                    $is_last_soal = true;
                }

            }elseif($nextSoalGeneral){
                // lanjut soal general
                $soal = $nextSoalGeneral;
            }else{

                $soal = Soal::with('pilihan')->whereIn("id", $soalHasKecamatan)->where('id', ">", $lastPilihan->soal_id)->first();

                // jika tidak soal kecamatan
                if(!$soal){
                    $is_last_soal = true;

                    return redirect()->back();
                }

                $cekLastSoal = Soal::orderBy('id', 'desc')->whereIn("id", $soalHasKecamatan)->first();

                if((int)$lastPilihan->soal_id >= $cekLastSoal->id){
                    $is_last_soal = true;

                    return redirect()->back();
                }
                if($soal->id >= $cekLastSoal->id){
                    $is_last_soal = true;
                }
            }

        }else{
            // $soal = Soal::with('pilihan')->whereIn("id", $soalHasKecamatan)->first();
            $soal = Soal::doesntHave("hasKecamatan")->first();

            if(!$soal){
                $soal = Soal::with('pilihan')->whereIn("id", $soalHasKecamatan)->first();
                $cekLastSoal = Soal::orderBy('id', 'desc')->whereIn("id", $soalHasKecamatan)->first();

                if($soal->id >= $cekLastSoal->id){
                    $is_last_soal = true;
                }
            }
        }



        $kecamatan = Kecamatan::where("id_kecamatan", $target->kecamatan_id)->first();

        return Inertia::render("Quiz", [
            'target' => $target,
            'soal' => $soal,
            'is_last_soal' => $is_last_soal,
            'is_first_soal' => $is_first_soal,
            'kecamatan' => $kecamatan
        ]);
    }

    public function nextSoal(Request $request){
        $request->validate([
            'target_id' => 'required|exists:data_targets,id',
            'pilihan_id' => 'required',
            'soal_id' => 'required|exists:soals,id',
        ]);

        DB::beginTransaction();

        try {

            $dataTarget = DataTarget::find($request->target_id);
            $soal = Soal::find($request->soal_id);

            $fotoBersama = null;
            if($request->image){
                $fotoBersama = $request->image->store("foto-bersama", "public");
                $dataTargetUpdate = DataTarget::where("id", $request->target_id)
                                ->update([
                                    'foto_bersama' => $fotoBersama
                                ]);
            }

            $cekPilihan = DB::table('pilihan_targets')
                    ->where('soal_id', $request->soal_id)
                    ->where('data_target_id', $request->target_id)
                    ->first();

            if($cekPilihan){
                $formUpdate = [
                        'updated_at' => now(),
                ];

                if($soal->yes_no){
                    $formUpdate["yes_no"] = $request->pilihan_id;
                }else{
                    $formUpdate["pilihan_ganda_id"] = $request->pilihan_id;
                }

                $updatePilihan = DB::table('pilihan_targets')
                    ->where('soal_id', $request->soal_id)
                    ->where('data_target_id', $request->target_id)
                    ->update($formUpdate);
            }else{
                $formInsert = [
                    'data_target_id' => $request->target_id,
                    'pilihan_ganda_id' => $request->pilihan_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    "soal_id" => $request->soal_id,
                    "kecamatan_id" => $dataTarget->kecamatan_id
                ];

                if($soal->yes_no){
                    $formInsert["yes_no"] = $request->pilihan_id;
                }else{
                    $formInsert["pilihan_ganda_id"] = $request->pilihan_id;
                }

                $insertData = DB::table('pilihan_targets')->insertGetId($formInsert);
            }


            $is_last_soal = false;

            // cek last General soal
            $lastSoalGeneral = Soal::doesntHave("hasKecamatan")->orderBy('id', 'desc')->first();
            $isGeneral = Soal::doesntHave("hasKecamatan")->with("pilihan")->where("id", $request->soal_id)->first();
            $nextSoalGeneral = null;

            if($isGeneral){
                $nextSoalGeneral = Soal::doesntHave("hasKecamatan")->with("pilihan")->where("id", ">", $request->soal_id)->first();
            }

            $soalHasKecamatan = SoalHasKecamatan::where("kecamatan_id", $dataTarget->kecamatan_id)->get()->pluck("soal_id");

            if($request->soal_id === $lastSoalGeneral->id){
                // next soal kecamatan
                $nextSoal = Soal::whereIn("id", $soalHasKecamatan)->with('pilihan')->first();

            }elseif($nextSoalGeneral){
                $nextSoal = $nextSoalGeneral;

                // jika tidak ada soal based on kecamatan is last soal
                $soalKecamatan = Soal::whereIn("id", $soalHasKecamatan)->with('pilihan')->first();
                if(!$soalKecamatan){
                    // cek last soal general
                    if($nextSoal->id === $lastSoalGeneral->id){
                        $is_last_soal = true;
                    }
                }

            }else{
                $nextSoal = Soal::whereIn("id", $soalHasKecamatan)->where("id", ">", $request->soal_id)->with('pilihan')->first();
                if(!$nextSoal){
                    DB::commit();
                    return response()->json([
                        'next_soal' => false,
                        'is_last_soal' => $is_last_soal
                    ]);
                }

                $cekLastSoal = Soal::orderBy('id', 'desc')->whereIn("id", $soalHasKecamatan)->first();
                if($cekLastSoal->id === (int)$request->soal_id){
                    DB::commit();
                    return response()->json([
                        'next_soal' => false,
                        'is_last_soal' => $is_last_soal
                    ]);
                }
                if($nextSoal->id === $cekLastSoal->id){
                    $is_last_soal = true;
                }
            }

            $riwayatPilihan = DB::table('pilihan_targets')
                        ->where('soal_id', $nextSoal->id)
                        ->where('data_target_id', $request->target_id)
                        ->first();

            DB::commit();

            return response()->json([
                'next_soal' => $nextSoal,
                'is_last_soal' => $is_last_soal,
                'riwayatPilihan' => $riwayatPilihan
            ]);

        } catch (Exception $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'terjadi kesalahan server'
            ], 422);
        }
    }

    public function backSoal(Request $request){
        $Soal = Soal::where("id", '<', $request->soal_id)->orderBy('id', 'desc')->with('pilihan')->first();
        $pilihanUser = PilihanTarget::where('soal_id', $Soal->id)->where('data_target_id', $request->target_id)->first();

        $firstSoal = false;
        $cekFirstSoal = Soal::first();
        if($cekFirstSoal->id === $Soal->id){
            $firstSoal = true;
        }

        return response()->json([
            'soal' => $Soal,
            'pilihanUser' => $pilihanUser,
            'first_soal' => $firstSoal
        ]);
    }

    public function selesaiQuiz(Request $request)
    {

    }

    public function logoutData(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
