<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\PilihanTarget;
use App\Models\Soal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->filter;

        $data['data_target'] = PilihanTarget::get();
        $data['responden'] = DataTarget::get();
        // return response()->json($data['responden']);

        $data['soal'] = Soal::orderBy('id', 'desc')->get();

        return view('pages.banksoal.banksoal', compact('data', 'filter'));
    }

    public function filter(Request $request){
        dd($request->all());
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
        $request->validate([
            'soal' => 'required|string',
            'pilihan' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $dataSoal = [
                'title' => $request->soal,
                'subtitle' => $request->deskripsi,
                'created_at' => now(),
                'updated_at' => now(),
                'color' => $this->generateColor()
            ];

            $insertSoal = DB::table('soals')->insertGetId($dataSoal);

            foreach($request->pilihan as $key => $value){
                DB::table('pilihan_gandas')->insert([
                    'soal_id' => $insertSoal,
                    'title' => $value,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('admin.bank-soal.index')->with('success', "Berhasil Tambah Bank Soal");
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
        $request->validate([
            'soal' => 'required|string',
            'pilihan' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $dataSoal = [
                'title' => $request->soal,
                'subtitle' => $request->deskripsi,
                'updated_at' => now()
            ];

            $insertSoal = DB::table('soals')->where('id', $id)->update($dataSoal);
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


            DB::commit();

            return redirect()->route('admin.bank-soal.index')->with('success', "Berhasil Update Bank Soal");
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
        //
    }

    public function generateColor(){
        $color = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);

        $cek = DB::table('soals')->where('color', $color)->first();
        if($cek){
            $this->generateColor();
        }

        return $color;
    }
}
