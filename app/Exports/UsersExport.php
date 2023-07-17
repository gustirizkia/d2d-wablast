<?php

namespace App\Exports;

use App\Models\DataTarget;
use App\Models\PilihanTarget;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data['data_target'] = PilihanTarget::get();
        $data['responden'] = DataTarget::get();
        // return response()->json($data['responden']);

        $data['soal'] = Soal::orderBy('id', 'desc')->get();

        return view('pages.excel.soal', compact('data'));
    }
}
