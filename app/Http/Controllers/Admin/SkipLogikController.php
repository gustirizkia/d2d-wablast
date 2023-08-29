<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkipLogikController extends Controller
{

    public function index($soal_id)
    {
        $soal = DB::table('soals')->where('id', $soal_id)->first();
        $pilihan = DB::table("pilihan_gandas")->where('soal_id', $soal_id)->get();

        $skip_soal = DB::table('soals')->where('skip_soal_id', $soal_id)->get();

       return view('pages.skip-logik.list', [
            'skip_soal' => $skip_soal,
            'soal' => $soal,
            'pilihan' => $pilihan
       ]);
    }

    public function newTambahData($soal_id){
        $soal = DB::table('soals')->where('id', $soal_id)->first();
        $pilihan = DB::table("pilihan_gandas")->where('soal_id', $soal_id)->get();

        return view('pages.skip-logik.add-soal', [
            'soal' => $soal,
            'pilihan' => $pilihan,
        ]);
    }

    public function tambahData(Request $request, $soal_id)
    {

        $soal = DB::table('soals')->where('id', $soal_id)->first();

        $skip_soal = DB::table('soals')->where('skip_soal_id', $soal_id)->first();
        if(!$skip_soal){
            return redirect()->back()->with('error', 'Simpan terlebih dahulu pilihan untuk di skip');
        }
        // dd($skip_soal);

       return view('pages.skip-logik.index', compact('soal', 'skip_soal'));

    }
    public function editSkipSoal(Request $request, $soal_id, $skip_id)
    {

        $soal = DB::table('soals')->where('id', $soal_id)->first();

        $skip_soal = DB::table('soals')->where('id', $skip_id)->first();
        if(!$skip_soal){
            return redirect()->back()->with('error', 'Simpan terlebih dahulu pilihan untuk di skip');
        }

        $pilihanSkip = DB::table("pilihan_gandas")->where('soal_id', $skip_soal->id)->get();
        // dd($skip_soal);

       return view('pages.skip-logik._edit-soal', compact('soal', 'skip_soal', 'pilihanSkip'));

    }

    public function storePilihanSkip(Request $request){

        $request->validate([
            'soal' => 'required|exists:soals,id',
        ]);

        $soal = DB::table('soals')->find($request->soal);
        $pilihan = [
            'skip_if_pilihan_id' => $request->pilihan
        ];

        if($soal->yes_no)
        {
            $request->validate([
                'pilihan' => 'required|string'
            ]);

            $pilihan = [
                'skip_if_yes_no' => $request->pilihan
            ];

        }else{
            $request->validate([
                'pilihan' => 'required|exists:pilihan_gandas,id'
            ]);
        }


        $updateDataChild = DB::table("soals")->where("skip_soal_id", $soal->id)->update($pilihan);
        // $updateDataChildCEK = DB::table("soals")->where("skip_soal_id", $soal->id)->get();
        // dd($updateDataChild, $updateDataChildCEK);

        return redirect()->back()->with('success', "Berhasil simpan pilihan skip");

    }

    public function storeData(Request $request)
    {

    }

    public function deleteData($id) {

    }
}
