<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Saksi.Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.Saksi.Create');
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

    public function getSurveyor(Request $request)
    {
        $search = $request->search;
        if($search == ''){
           $user = User::orderby('email','asc')->limit(7)->get();
        }else{
           $user = User::orderby('email','asc')->where('email', 'like', '%' .$search . '%')->limit(7)->get();
        }



        $response = array();
        foreach($user as $users){
           $response[] = array(
                "id"=>$users->id,
                "text"=>$users->name."/".$users->email
           );
        }

        return response()->json($response);

    }
}
