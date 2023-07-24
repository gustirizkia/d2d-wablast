<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataTargetExport;
use App\Exports\RespondenDetailExport;
use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\PilihanTarget;
use App\Models\User;
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
        $start = $request->start_date;
        $end = $request->end_date;

        $data = DataTarget::when($provinsi, function($query)use($provinsi){
                                return $query->where("provinsi_id", $provinsi);
                            })
                            ->when($kota, function($query)use($kota){
                                return $query->where("kota_id", $kota);
                            })
                            ->when($start, function($query)use($start){
                                return $query->where("created_at", ">=", $start);
                            })
                            ->when($end, function($query)use($end){
                                return $query->whereDate("created_at", "<=", $end);
                            })
                            ->when($kecamatan, function($query)use($kecamatan){
                                return $query->where("kecamatan_id", $kecamatan);
                            })
                            ->paginate(12);

        if($request->surveyor){
            // dd("CEK");
            $userId = $request->surveyor;
            $data = DataTarget::when($provinsi, function($query)use($provinsi){
                                    return $query->where("provinsi_id", $provinsi);
                                })
                                ->when($kota, function($query)use($kota){
                                    return $query->where("kota_id", $kota);
                                })
                                ->when($start, function($query)use($start){
                                    return $query->where("created_at", ">=", $start);
                                })
                                ->when($end, function($query)use($end){
                                    return $query->where("created_at", "<=", $end);
                                })
                                ->when($kecamatan, function($query)use($kecamatan){
                                    return $query->where("kecamatan_id", $kecamatan);
                                })
                                ->whereHas("user", function($q)use($userId){
                                    return $q->where("id", $userId);
                                })
                                ->paginate(12);

        }

        $provinsi = DB::table('provinsis')->whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();
        $user = User::orderBy('name', 'asc')->get();
        return view('pages.responden.index', [
            'items' => $data,
            'provinsi' => $provinsi,
            'users' => $user
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
        $pilihanTarget = PilihanTarget::with("pilihan")->where("data_target_id", $id)->paginate(12);
        // return response()->json($pilihanTarget);
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

    public function statistik()
    {
        $responden = DataTarget::with("rel_provinsi", 'rel_kota', 'rel_kecamatan', 'rel_desa')
                    ->select("data_targets.*", DB::raw("COUNT(*) as total"))
                    ->groupBy("kecamatan_id")
                    ->get();
        $count['kecamatan'] = count(DB::table('data_targets')
                            ->groupBy('kecamatan_id')
                            ->get());
        $count['kota'] = count(DB::table('data_targets')
                            ->groupBy('kota_id')
                            ->get());
        $count['provinsi'] = count(DB::table('data_targets')
                            ->groupBy('provinsi_id')
                            ->get());
        $allResponden = DataTarget::get();

        return response()->json([
            'responden' => $responden,
            'count' => $count,
            'all_responden' => $allResponden
        ]);
    }


}
