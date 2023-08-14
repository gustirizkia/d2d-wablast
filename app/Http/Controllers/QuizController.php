<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\SoalHasKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(Request $request, $id_target){
        $target = DB::table('data_targets')->find($id_target);
        $kecamatan = DB::table("kecamatans")->where('id_kecamatan', $target->kecamatan_id)->first();

        return Inertia::render("Quiz/QuizIndex", compact('target', 'kecamatan'));
    }

    public function getAllSoal($id_target){
        $soalGeneral = Soal::doesntHave("hasKecamatan")->where("skip_soal_id", null)->with("skipSoal.pilihan")->with('pilihan')->get();
        $target = DB::table('data_targets')->find($id_target);
        $soalHasKecamatan = SoalHasKecamatan::where("kecamatan_id", $target->kecamatan_id)->get()->pluck("soal_id");
        $soalKecamatan = Soal::whereIn("id", $soalHasKecamatan)->where("skip_soal_id", null)->with("skipSoal")->with('pilihan')->get();

        return response()->json([
            'soal_general' => $soalGeneral,
            'soal_kecamatan' => $soalKecamatan
        ]);
    }
}
