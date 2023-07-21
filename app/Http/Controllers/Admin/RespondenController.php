<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataTargetExport;
use App\Exports\RespondenDetailExport;
use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\PilihanTarget;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RespondenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;

        $data = DataTarget::when($provinsi, function($query)use($provinsi){
                                return $query->where("provinsi_id", $provinsi);
                            })
                            ->when($kota, function($query)use($kota){
                                return $query->where("kota_id", $kota);
                            })
                            ->when($kecamatan, function($query)use($kecamatan){
                                return $query->where("kecamatan_id", $kecamatan);
                            })
                            ->get();
        $provinsi = DB::table('provinsis')->whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();
        return view('pages.responden.index', [
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
        $dataTarget = DataTarget::findOrFail($id);
        $pilihanTarget = PilihanTarget::where("data_target_id", $id)->paginate(12);
        // dd($pilihanTarget);
        return view('pages.responden.detail', [
            'items' => $pilihanTarget,
            'item' => $dataTarget
        ]);
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

    public function export(Request $request)
    {
        try {
            return Excel::download(new DataTargetExport, 'responden-'.Carbon::now()->format("d-M-Y").'.xlsx');
        } catch (Exception $th) {
            return redirect()->back()->with('error', "Failed export data");
        }



    }

    public function exportDetail($id){
        $responden = DataTarget::find($id);
        return Excel::download(new RespondenDetailExport($id), "Responden $responden->nama".".xlsx");
    }
}
