<?php

namespace App\Exports;

use App\Models\DataTarget;
use Maatwebsite\Excel\Concerns\FromCollection;

class DetailSurveyotExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return DataTarget::all();
    }
}
