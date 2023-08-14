<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkipLogikController extends Controller
{
    public function tambahData($soal_id)
    {
        $soal = DB::table('soals')->where('id', $soal_id)->first();
        $skip_soal = DB::table('soals')->where('skip_soal_id', $soal_id)->first();

        $pilihan = DB::table("pilihan_gandas")->where('soal_id', $soal_id)->get();

       return view('pages.skip-logik.index', compact('soal', 'pilihan', 'skip_soal'));

    }

    public function storeData(Request $request)
    {

    }

    public function deleteData($id) {

    }
}
