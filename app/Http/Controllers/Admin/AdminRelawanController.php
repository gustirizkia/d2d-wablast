<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRelawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;

        $data = Relawan::when($provinsi, function($query)use($provinsi){
                                return $query->where("provinsi_id", $provinsi);
                            })
                            ->when($kota, function($query)use($kota){
                                return $query->where("kota_id", $kota);
                            })
                            ->when($kecamatan, function($query)use($kecamatan){
                                return $query->where("kecamatan_id", $kecamatan);
                            })
                            ->paginate(12);
        $provinsi = DB::table('provinsis')->whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();



        return view('pages.relawan.index', [
            'items' => $data,
            'provinsi' => $provinsi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getStatistik(Request $request){
        $relawan = Relawan::with("rel_provinsi", 'rel_kota', 'rel_kecamatan', 'rel_desa')
                    ->select("relawans.*", DB::raw("COUNT(*) as total"))
                    ->groupBy("kecamatan_id")
                    ->get();
        $count['kecamatan'] = count(DB::table('relawans')
                            ->groupBy('kecamatan_id')
                            ->get());
        $count['kota'] = count(DB::table('relawans')
                            ->groupBy('kota_id')
                            ->get());
        $count['provinsi'] = count(DB::table('relawans')
                            ->groupBy('provinsi_id')
                            ->get());
        $allRelawan = Relawan::get();

        return response()->json([
            'count' => $count,
            'relawan' => $relawan,
            'all_relawan' => $allRelawan
        ]);
    }
}
