<?php

namespace App\Http\Controllers;

use App\Models\DataTarget;
use App\Models\PilihanTarget;
use App\Models\Soal;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function riwayat(Request $request){
        $data = DataTarget::withCount('pilihanTarget')->orderBy('updated_at', 'desc')->get();
        $countSoal = Soal::count();
        return Inertia::render("ListQuiz", [
            'data_target' => $data,
            'count_soal' => $countSoal
        ]);
    }
    public function index(){
        $data = Soal::with('pilihan')->get();
        return Inertia::render("Survey", [
            'data_soal' => $data
        ]);
    }

    public function inputDataTarget(Request $request){
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required'
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
        try {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $client = new Client();
            $response = $client->get("https://geocode.maps.co/reverse?lat=$latitude&lon=$longitude")->getBody()->getContents();

            $result = json_decode($response);

            if($result->address){
                $data['provinsi'] = isset($result->address->state) ? $result->address->state : null;
                $data['kota'] = isset($result->address->city) ? $result->address->city : null;
                $data['kecamatan'] = isset($result->address->city_district) ? $result->address->city_district : null;
                $data['desa'] = isset($result->address->village) ? $result->address->village : null;
            }

        } catch (BadResponseException $e) {

        }

        $insertData = DB::table('data_targets')->insertGetId($data);

        return redirect()->route('quiz', $insertData)->with('success', "Berhasil simpan data");
    }

    public function quiz(Request $request, $id){
        $target = DataTarget::findOrFail($id);

        $lastPilihan = DB::table('pilihan_targets')->where('data_target_id', $id)->orderBy('id', 'desc')->first();

        $is_last_soal = false;
        $is_first_soal = true;
        if($lastPilihan){
            $is_first_soal = false;
            $cekLastSoal = Soal::orderBy('id', 'desc')->first();
            if((int)$lastPilihan->soal_id >= $cekLastSoal->id){
                $is_last_soal = true;

                return redirect('/');
            }

            $soal = Soal::with('pilihan')->where('id', ">", $lastPilihan->soal_id)->first();
            // dd($soal);
            if($soal->id >= $cekLastSoal->id){
                $is_last_soal = true;
            }
        }else{
            $soal = Soal::with('pilihan')->first();
        }

        return Inertia::render("Quiz", [
            'target' => $target,
            'soal' => $soal,
            'is_last_soal' => $is_last_soal,
            'is_first_soal' => $is_first_soal
        ]);
    }

    public function nextSoal(Request $request){
        $request->validate([
            'target_id' => 'required|exists:data_targets,id',
            'pilihan_id' => 'required|exists:pilihan_gandas,id',
            'soal_id' => 'required|exists:soals,id',
        ]);

        $cekPilihan = DB::table('pilihan_targets')
                ->where('soal_id', $request->soal_id)
                ->where('data_target_id', $request->target_id)
                ->first();

        $fotoBersama = null;
        if($request->image){
            $fotoBersama = $request->image->store("foto-bersama", "public");
            $dataTarget = DataTarget::where("id", $request->target_id)
                            ->update([
                                'foto_bersama' => $fotoBersama
                            ]);
        }

        if($cekPilihan){
            $updatePilihan = DB::table('pilihan_targets')
                ->where('soal_id', $request->soal_id)
                ->where('data_target_id', $request->target_id)
                ->update([
                    'updated_at' => now(),
                    'pilihan_ganda_id' => $request->pilihan_id,

                ]);

        }else{
            $insertData = DB::table('pilihan_targets')->insertGetId([
                'data_target_id' => $request->target_id,
                'pilihan_ganda_id' => $request->pilihan_id,
                'created_at' => now(),
                'updated_at' => now(),
                "soal_id" => $request->soal_id,
            ]);
        }


        $is_last_soal = false;
        $cekLastSoal = Soal::orderBy('id', 'desc')->first();
        if($cekLastSoal->id === (int)$request->soal_id){
            return response()->json([
                'next_soal' => false,
                'is_last_soal' => $is_last_soal
            ]);
        }

        $nextSoal = Soal::where("id", '>', $request->soal_id)->with('pilihan')->first();
        if($nextSoal->id === $cekLastSoal->id){
            $is_last_soal = true;
        }

        $riwayatPilihan = DB::table('pilihan_targets')
                ->where('soal_id', $nextSoal->id)
                ->where('data_target_id', $request->target_id)
                ->first();

        return response()->json([
            'next_soal' => $nextSoal,
            'is_last_soal' => $is_last_soal,
            'riwayatPilihan' => $riwayatPilihan
        ]);
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
}
