<?php

namespace App\Exports;

use App\Models\DataTarget;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataTargetExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = DataTarget::get();

        return view('pages.report.responden-all', [
            'items' => $data
        ]);
    }
}
