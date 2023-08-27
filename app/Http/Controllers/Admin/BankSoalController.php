<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\Kecamatan;
use App\Models\PilihanGanda;
use App\Models\PilihanTarget;
use App\Models\Soal;
use App\Models\SoalHasKecamatan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data['soal'] = Soal::orderBy('id', 'desc')->with('skipSoal')->where('skip_soal_id', null)->paginate(12);
        // return response()->json($data);
        return view('pages.banksoal.banksoal', compact('data'));
    }

    public function filter(Request $request){
        // dd($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.banksoal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'soal' => 'required|string',
        ]);

        if($request->skip_soal){
            $request->validate([
                'skip_if_pilihan_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        try {
            $dataSoal = [
                'title' => $request->soal,
                'subtitle' => $request->deskripsi,
                'created_at' => now(),
                'updated_at' => now(),
                'color' => $this->generateColor()
            ];

            // dd($dataSoal, $request->all());

            if($request->skip_soal)
            {
                $soal = DB::table('soals')->find($request->skip_soal);
                if($soal){
                    $dataSoal['skip_soal_id'] = $request->skip_soal;
                    if($soal->yes_no){
                        $dataSoal['skip_if_yes_no'] = $request->skip_if_pilihan_id;
                    }else{
                        $dataSoal['skip_if_pilihan_id'] = $request->skip_if_pilihan_id;
                    }
                }

            }

            if($request->tipe_pilihan === 'ya_tidak'){
                $dataSoal['yes_no'] = 1;
            }

            $insertSoal = DB::table('soals')->insertGetId($dataSoal);

            if($request->tipe_pilihan !== 'ya_tidak'){
                foreach($request->pilihan as $key => $value){
                    DB::table('pilihan_gandas')->insert([
                        'soal_id' => $insertSoal,
                        'title' => $value,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }


            DB::commit();

            return redirect()->route('admin.data.bank-soal.index')->with('success', "Berhasil Tambah Bank Soal");
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal simpan data server error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Soal::with('pilihan')->findOrFail($id);

        return view('pages.banksoal.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'soal' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $dataSoal = [
                'title' => $request->soal,
                'subtitle' => $request->deskripsi,
                'updated_at' => now()
            ];

            if($request->skip_soal)
            {
                $soal = DB::table('soals')->find($request->skip_soal);
                if($soal){
                    $dataSoal['skip_soal_id'] = $request->skip_soal;
                    if($soal->yes_no){
                        $dataSoal['skip_if_yes_no'] = $request->skip_if_pilihan_id;
                    }else{
                        $dataSoal['skip_if_pilihan_id'] = $request->skip_if_pilihan_id;
                    }
                }

            }

            // dd($dataSoal, $request->all());

            if($request->tipe_pilihan === 'ya_tidak'){
                $dataSoal['yes_no'] = 1;
            }else{
                $dataSoal['yes_no'] = 0;

            }
            $insertSoal = DB::table('soals')->where('id', $id)->update($dataSoal);

            if($request->tipe_pilihan !== 'ya_tidak'){
                $array_id_pilihan = [];
                foreach($request->pilihan as $key => $value){
                    array_push($array_id_pilihan, $value['id']);
                    DB::table('pilihan_gandas')->where('id', $value['id'])->update([
                        'soal_id' => $id,
                        'title' => $value['title'],
                        'updated_at' => now()
                    ]);
                }

                // dd($array_id_pilihan);

                // delete
                $delete = DB::table('pilihan_gandas')->where('soal_id', $id)->whereNotIn('id', $array_id_pilihan)->delete();

                if($request->new_pilihan){
                    foreach ($request->new_pilihan as $key => $value) {
                        DB::table('pilihan_gandas')->insert([
                            'soal_id' => $id,
                            'title' => $value,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }



            DB::commit();

            return redirect()->route('admin.data.bank-soal.index')->with('success', "Berhasil Update Bank Soal");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal simpan data server error '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $data = Soal::findOrFail($id);

            $soalhas = SoalHasKecamatan::where("soal_id", $id)->delete();

            PilihanGanda::where("soal_id", $id)->delete();

            $data->delete();

            DB::commit();
            return redirect()->back()->with("success", "Berhasil Hapus data");
        } catch (Exception $th) {
            DB::rollBack();

            return redirect()->back()->with('error', "Gagal hapus data");
        }


    }

    public function generateColor(){
        $color = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);

        $cek = DB::table('soals')->where('color', $color)->first();
        if($cek){
            $this->generateColor();
        }

        return $color;
    }

    public function exportDataSoal(){
        return Excel::download(new UsersExport, 'data.xlsx');
    }

    public function getKecamatanById($kecamatan_id){
        $data = Kecamatan::where("id_kecamatan", $kecamatan_id)->with("kota")->first();

        return response()->json($data);

    }
}
