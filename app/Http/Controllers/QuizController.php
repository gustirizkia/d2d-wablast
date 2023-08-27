<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\SoalHasKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(Request $request, $id_target){
        $target = DB::table('data_targets')->find($id_target);
        $kecamatan = DB::table("kecamatans")->where('id_kecamatan', $target->kecamatan_id)->first();

        return Inertia::render("Quiz/QuizIndex", compact('target', 'kecamatan'));
    }

    public function saveOne(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'data_target_id' => 'required|exists:data_targets,id',
            'soal_id' => 'required|exists:soals,id',
            'pilihan' => 'required'
        ]);

        if($validasi->fails()){
            return response()->json($validasi->errors()->first(), 422);
        }

        $cekExists = DB::table("pilihan_targets")->where("soal_id", $request->soal_id)
                    ->where('data_target_id', $request->data_target_id)->first();


        $soal = DB::table('soals')->find($request->soal_id);
        $target = DB::table("data_targets")->find($request->data_target_id);

        $data = [
            'data_target_id' => $request->data_target_id,
            'soal_id' => $soal->id,
            'kecamatan_id' => $target->kecamatan_id,
            'created_at' => now(),
            'updated_at' => now()
        ];

        if($soal->yes_no){
            $data['yes_no'] = $request->pilihan;
        }else{
            $data['pilihan_ganda_id'] = $request->pilihan;
        }

        if($cekExists)
        {
            $updateData = DB::table("pilihan_targets")->where("soal_id", $request->soal_id)
                        ->where('data_target_id', $request->data_target_id)->update($data);

            $getData = DB::table("pilihan_targets")->where("soal_id", $request->soal_id)
                    ->where('data_target_id', $request->data_target_id)->first();
        }else{
            $insertPiliihanTarget = DB::table('pilihan_targets')->insertGetId($data);
            $getData = DB::table("pilihan_targets")->find($insertPiliihanTarget);
        }


        return response()->json($getData);


    }

    public function getAllSoal($id_target){
        $target = DB::table('data_targets')->find($id_target);

        $soalGeneral = Soal::doesntHave("hasKecamatan")
                        ->where("skip_soal_id", null)
                        ->with("skipSoal.pilihan")
                        ->with('pilihan')
                        ->get();

        $soalGeneral->map(function($e)use($id_target){
                $e->idTarget = $id_target;

                return $e;
        });

        $soalHasKecamatan = SoalHasKecamatan::where("kecamatan_id", $target->kecamatan_id)
                            ->get()
                            ->pluck("soal_id");
        $soalKecamatan = Soal::whereIn("id", $soalHasKecamatan)
                            ->where("skip_soal_id", null)->with("skipSoal")
                            ->with('pilihan')->get();

        return response()->json([
            'soal_general' => $soalGeneral,
            'soal_kecamatan' => $soalKecamatan
        ]);
    }
}
