<?php

namespace App\Exports;

use App\Models\DataTarget;
use App\Models\PilihanTarget;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RespondenDetailExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $dataTarget = DataTarget::findOrFail($this->id);
        $pilihanTarget = PilihanTarget::where("data_target_id", $this->id)->get();
        // dd($pilihanTarget, $dataTarget);
        return view("pages.report.responden-detail", [
            'items' => $pilihanTarget,
            'item' => $dataTarget
        ]);
    }
}
