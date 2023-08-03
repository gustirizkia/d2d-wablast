<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatistikSoal;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function soal(Request $request)
    {
        $data = StatistikSoal::get();
        $data = $data->filter(function($model){
            return count($model->pilihan) > 0;
        });
        // return response()->json($data);

        return view("pages.statistik.kuisioner", compact('data'));
    }
}
