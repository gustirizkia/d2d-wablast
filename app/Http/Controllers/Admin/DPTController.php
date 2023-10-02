<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\DPT\CianjurImport;
use App\Models\DataDpt;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DPTController extends Controller
{
    public function index(Request $request){

        $search = $request->q;

        $data = DataDpt::when($search, function($query)use($search){
                    return $query->where("nama", "LIKE", "%$search%")->orWhere("desa", "LIKE", "%$search%");
                })
                ->orderBy("nama", "asc")
                ->paginate(12);

        return view("pages.dpt.index", compact("data"));
    }

    public function prosesImport(Request $request)
    {
        $request->validate([
            "file" => "required"
        ]);

        $import = new CianjurImport();
       $imp = Excel::import($import, $request->file);


       return redirect()->back()->with("success", "Berhasil import");
    }
}
