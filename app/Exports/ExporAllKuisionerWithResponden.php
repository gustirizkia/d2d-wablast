<?php

namespace App\Exports;

use App\Models\DataTarget;
use App\Models\Soal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExporAllKuisionerWithResponden implements FromView
{
    public function view(): View
    {
        $soal = Soal::get();
        $dataTarget = DataTarget::get();
        return view('pages.responden.export-all', compact('soal', 'dataTarget'));
    }
}
