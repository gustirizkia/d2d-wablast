<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\Soal;
use App\Models\SoalHasKecamatan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuisionerKecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataSoalKecamatan'] = DB::table("soal_has_kecamatans")
                            ->join("soals", "soal_has_kecamatans.soal_id", 'soals.id')
                            ->join("kecamatans", "soal_has_kecamatans.kecamatan_id", 'kecamatans.id_kecamatan')
                            ->join("kotas", "soal_has_kecamatans.kota_id", 'kotas.id_kota')
                            ->select("kotas.nama as kota", "kecamatans.nama as kecamatan", "soal_has_kecamatans.*", DB::raw("count(*) total_pertanyaan"))
                            ->groupBy('soal_has_kecamatans.kecamatan_id')
                            ->get();

        return view('pages.kuisioner-kecamatan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $soal = Soal::orderBy('id', 'desc')->get();
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();

        return view('pages.kuisioner-kecamatan.create', [
            'soal' => $soal,
            'provinsi' => $provinsi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan' => 'required|exists:kecamatans,id_kecamatan',
            'kota' => 'required|exists:kotas,id_kota',
            'provinsi' => 'required|exists:provinsis,id_provinsi',
            'soal_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
           foreach($request->soal_id as $soal){
                $insertData = DB::table('soal_has_kecamatans')->insertGetId([
                    'kecamatan_id' => $request->kecamatan,
                    'kota_id' => $request->kota,
                    'provinsi_id' => $request->provinsi,
                    'soal_id' => $soal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.data.kuisioner-kecamatan.index')->with('success', "Berhsail simpan data");
        } catch (Exception $th) {
            DB::rollBack();

            return redirect()->with('error', "Gagal Simpan Data");
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
        $dataKecamatan = Kecamatan::where('id_kecamatan', $id)->firstOrFail();
        $itemKota = Kota::where("id_kota", $dataKecamatan->kota_id)->first();
        $item_provinsi = Provinsi::where("id_provinsi", $itemKota->provinsi_id)->first();

        $soalHasKecamatan = SoalHasKecamatan::where("kecamatan_id", $dataKecamatan->id_kecamatan)->get();
        $soalNotSelect = Soal::whereNotIn("id", $soalHasKecamatan->pluck("soal_id"))->get();

        return view('pages.kuisioner-kecamatan.edit', [
            'item_kecamatan' => $dataKecamatan,
            'item_kota' => $itemKota,
            'item_provinsi' => $item_provinsi,
            'soalNotSelect' => $soalNotSelect,
            'soal_has_kecamatan' => $soalHasKecamatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $kecamatan = Kecamatan::where('id_kecamatan', $id)->firstOrFail();
            $kota = Kota::where("id_kota", $kecamatan->kota_id)->first();

            if($request->soal_id_active){
                $soalHasKecamatan = SoalHasKecamatan::whereNotIn("soal_id", $request->soal_id_active)->delete();
            }

            if($request->soal_id){
                foreach($request->soal_id as $soal){
                    $insertData = DB::table("soal_has_kecamatans")->insertGetId([
                        'soal_id' => $soal,
                        'kecamatan_id' => $kecamatan->id_kecamatan,
                        'kota_id' => $kecamatan->kota_id,
                        'provinsi_id' => $kota->provinsi_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route("admin.data.kuisioner-kecamatan.index")->with('success', "Berhasil update data");
        } catch (Exception $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with("error", "Update data gagal, cek data dan silahkan lakukan kembali");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
