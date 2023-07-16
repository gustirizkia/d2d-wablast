<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataTargetExport;
use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RespondenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DataTarget::get();

        return view('pages.responden.index', [
            'items' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
    {
        try {
            return Excel::download(new DataTargetExport, 'responden-'.Carbon::now()->format("d-M-Y").'.xlsx');
        } catch (Exception $th) {
            return redirect()->back()->with('error', "Failed export data");
        }



    }
}
