<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CalonLegislatif;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CalonHasSoal;
use App\Models\City;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinci;
use App\Models\Provinsi;
use App\Models\Soal;
use Exception;

class CalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = CalonLegislatif::orderBy('id', 'desc')->paginate(12);

        return view('pages.calon.calon', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = DB::table('provinsis')->whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();

        return view('pages.calon.calon-create', [
            'provinsi' => $provinsi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'dapil' => 'required|string',
            'provinsi' => 'required|exists:provinces,province_id',
            'kota' => 'required|exists:cities,city_id',
            'kecamatan' => 'required|exists:subdistricts,subdistrict_id',
        ]);


        $data = [
            'nama' => $request->nama,
            'dapil' => $request->dapil,
            'provinsi_id' => $request->provinsi,
            'kota_id' => $request->kota,
            'kecamatan_id' => $request->kecamatan,
            'username' => $this->generateUsername()
        ];
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $insert = DB::table('calon_legislatifs')->insertGetId($data);

        return redirect()->route('admin.calon-legislatif.index')->with('success', "Berhasil tambah data calon");

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
        $item = CalonLegislatif::findOrFail($id);
        $provinsi = Provinsi::get();
        $kota = Kota::where("province_id", $item->provinsi_id)->get();
        $kecamatan = Kecamatan::where("city_id", $item->kota_id)->get();

        return view('pages.calon.calon-edit', [
            'item' => $item,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $calon = CalonLegislatif::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'dapil' => 'required|string',
            'provinsi' => 'required|exists:provinces,province_id',
            'kota' => 'required|exists:cities,city_id',
            'kecamatan' => 'required|exists:subdistricts,subdistrict_id',
        ]);

        $data = [
            'nama' => $request->nama,
            'dapil' => $request->dapil,
            'provinsi_id' => $request->provinsi,
            'kota_id' => $request->kota,
            'kecamatan_id' => $request->kecamatan,
        ];

        $calon->update($data);

        return redirect()->route('admin.calon-legislatif.index')->with('success', "Berhasil update data calon");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calon = CalonLegislatif::findOrFail($id);
        $calon->delete();

        return redirect()->back()->with('success', "Berhasil hapus data calon");
    }

    public function generateUsername(){
        $username = Str::random(6);

        $cek = DB::table("calon_legislatifs")->where("username", $username)->first();
        if($cek)
        {
            $this->generateUsername();
        }else{
            return $username;
        }
    }


    public function bankSoalCalon($id)
    {
        $item = CalonLegislatif::with('hasSoal.soal')->findOrFail($id);
        // dd($item);
        return view('pages.calon.bank-soal', [
            'item' => $item
        ]);
    }

    public function deleteHasSoal($id)
    {
        $hasSoal = CalonHasSoal::findOrFail($id);
        $hasSoal->delete();

        return redirect()->back()->with('success', "Berhasil hapus data");
    }

    public function getSoal($calon){
        $data = CalonHasSoal::where('calon_legislatif_id', $calon)->pluck("soal_id");
        $soal = Soal::whereNotIn('id', $data)->get();

        return response()->json($soal);
    }

    public function insertSoalCalon(Request $request){
        DB::beginTransaction();
        try {
            foreach($request->soal_id as $soal){
                $insert = DB::table('calon_has_soals')->insertGetId([
                    'calon_legislatif_id' => $request->calon,
                    'soal_id' => $soal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', "Berhasil tambah soal untuk calon");
        } catch (Exception $th) {
            // dd($th);
            DB::rollBack();
           return redirect()->back()->with('error', "Gagal tambah data");
        }
    }
}
