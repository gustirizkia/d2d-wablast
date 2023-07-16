<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Relawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['statistik_pilihans'] = DB::table("statistik_pilihans")
                                ->join('pilihan_gandas', 'statistik_pilihans.pilihan_ganda_id', 'pilihan_gandas.id')
                                ->join('soals', 'statistik_pilihans.soal_id', 'soals.id')
                                ->select('pilihan_gandas.title as title_pilihan', 'soals.title as title_soal', 'statistik_pilihans.id', "count", "statistik_pilihans.pilihan_ganda_id", "statistik_pilihans.soal_id", "statistik_pilihans.updated_at")
                                // ->limit(6)
                                ->get()
                                ->groupBy("soal_id");
        $dataArray = $data['statistik_pilihans']->toArray();
        $data['statistik_pilihans'] = array_slice($dataArray, 0, 3);
        $data['count_relawan'] = DB::table('relawans')->count();
        $data['count_surveyor'] = DB::table('users')->where('roles', 'user')->count();
        $data['count_responden'] = DB::table('data_targets')->count();

        $data['statistik_relawan'] = Relawan::select(
                                "id" ,
                                DB::raw("(count(*)) as total"),
                                DB::raw("(DATE_FORMAT(created_at, '%w-%m-%Y')) as month_year")
                            )
                            ->orderBy('created_at')
                            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%w-%m-%Y')"))
                            ->get();

        // return response()->json($data['statistik_relawan']);

        return view('pages.dashboard', compact('data'));
    }
}
