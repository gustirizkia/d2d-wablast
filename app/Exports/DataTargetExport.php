<?php

namespace App\Exports;

use App\Models\DataTarget;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataTargetExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DataTarget::select('nama', 'alamat', 'provinsi', 'kota', 'kecamatan', 'desa', 'created_at as tanggal')->orderBy('id', 'desc')->get();
    }
}
