<?php

namespace App\Http\Controllers;

use App\Models\CalonHasSoal;
use App\Models\CalonLegislatif;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
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

        try {
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $client = new Client();
            $response = $client->get("https://geocode.maps.co/reverse?lat=$latitude&lon=$longitude")->getBody()->getContents();

            $result = json_decode($response);

            if($result->address){
                $data['provinsi'] = isset($result->address->state) ? $result->address->state : null;
                $data['kota'] = isset($result->address->city) ? $result->address->city : null;
                $data['kecamatan'] = isset($result->address->city_district) ? $result->address->city_district : null;
                $data['desa'] = isset($result->address->village) ? $result->address->village : null;
            }

        } catch (BadResponseException $e) {

        }

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
