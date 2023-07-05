<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataTarget::orderBy('data_targets.id', 'desc')
                ->join("users", "data_targets.user_survey_id", 'users.id')->get();
        $dataUser = DataTarget::orderBy('data_targets.id', 'desc')
                ->join("users", "data_targets.user_survey_id", 'users.id')->limit(12)->get();
        // dd($dataUser);
        return view('pages.lokasi.lokasi', compact('data', 'dataUser'));
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
}
