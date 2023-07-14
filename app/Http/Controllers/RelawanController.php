<?php

namespace App\Http\Controllers;

use App\Models\CalonHasSoal;
use App\Models\CalonLegislatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RelawanController extends Controller
{
    public function index($username = null){

        if(!$username)
        {
            return abort(404);
        }

        Session::put("username_calon", $username);
        return Inertia::render("Relawan/InputData");

    }

    public function getCalon()
    {
        $username = Session::get("username_calon");

        $calon = CalonLegislatif::where("username", $username)->first();

        return response()->json($calon);
    }

    public function addRelawan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $username = Session::get("username_calon");
        if(!$username){
            return abort(404);
        }

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
            "username_calon" => $username
        ];

        $insert = DB::table('relawans')->insertGetId($data);

        return redirect()->route("survey-relawan");

    }

    public function survey(){
        $username = Session::get("username_calon");
        if(!$username){
            return abort(404);
        }

        $calon = CalonLegislatif::where("username", $username)->first();
        $data = CalonHasSoal::where("calon_legislatif_id", $calon->id)->with("soal.pilihan")->get();

        dd($data);
    }
}
