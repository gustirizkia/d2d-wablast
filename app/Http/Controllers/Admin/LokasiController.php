<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\PilihanGanda;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataTarget::orderBy('data_targets.id', 'desc')
                ->join("users", "data_targets.user_survey_id", 'users.id')->get();
        $dataUser = DataTarget::orderBy('data_targets.id', 'desc')
                ->join("users", "data_targets.user_survey_id", 'users.id')->limit(12)->get();


        $pilihanTarget = DB::table("pilihan_targets")
                            ->join("data_targets", 'pilihan_targets.data_target_id', 'data_targets.id')
                            ->join("pilihan_gandas", 'pilihan_targets.pilihan_ganda_id', 'pilihan_gandas.id')
                            ->select('latitude', "longitude", 'title', "nama", "pilihan_ganda_id", DB::raw("COUNT(*) as total"))
                            ->groupBy("pilihan_ganda_id")
                            ->orderBy("total", 'desc')
                            ->get();
        $soal = Soal::get();

        $user = User::where("roles", "user")->withTrashed()->get();
        // dd($user);

        return view('pages.lokasi.lokasi', compact('data', 'dataUser', "pilihanTarget", 'soal', 'user'));
    }

    public function detailSoal($soal_id, Request $request)
    {

        $data = PilihanGanda::where("soal_id", $soal_id)
                        ->with("pilihanTarget.dataTarget")
                        ->with('soal')
                        ->withCount("pilihanTarget")
                        ->get();


        return response()->json($data);
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
}
