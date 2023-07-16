<?php

namespace App\Exports;

use App\Models\Relawan;
use Maatwebsite\Excel\Concerns\FromCollection;

class RelawanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Relawan::all();
    }
}
