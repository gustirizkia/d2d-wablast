<?php

namespace App\Http\Controllers;

use App\Models\CalonHasSoal;
use App\Models\CalonLegislatif;
use App\Models\Provinsi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Stevebauman\Location\Facades\Location;

class RelawanController extends Controller
{
    public function index($username = null){
        $calon = CalonLegislatif::first();
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();
        return Inertia::render("Relawan/TambahRelawan", [
            'provinsi' => $provinsi,
            'calon' => $calon
        ]);

    }

    public function getCalon()
    {
        $username = Session::get("username_calon");

        $calon = CalonLegislatif::where("username", $username)->first();

        return response()->json($calon);
    }

    public function successAdd(){
        return Inertia::render("Relawan/RelawanSuccess");
    }

    public function addRelawan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string'
        ]);

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude ? $request->latitude : 1,
            'longitude' => $request->longitude ? $request->longitude : 1,
            'created_at' => now(),
            'updated_at' => now(),
            "provinsi_id" => $request->provinsi,
            "kota_id" => $request->kota,
            "kecamatan_id" => $request->kecamatan,
            "desa_id" => $request->desa,
            "tanggal_lahir" => $request->tanggal_lahir
        ];

        $ktp = $request->foto_ktp->store("relawan/ktp", "public");
        $data['foto_ktp'] = $ktp;

        if(!$request->latitude || !$request->longitude || $request->longitude === 'undefined' || $request->latitude === "undefined"){
            $location = Location::get(request()->getClientIp());
            if($location){
                $data['latitude'] = $location->latitude;
                $data['longitude'] = $location->longitude;
            }
        }

        // try {
        //     $latitude = $request->latitude;
        //     $longitude = $request->longitude;

        //     $client = new Client();
        //     $response = $client->get("https://geocode.maps.co/reverse?lat=$latitude&lon=$longitude")->getBody()->getContents();

        //     $result = json_decode($response);

        //     if($result->address){
        //         $data['provinsi'] = isset($result->address->state) ? $result->address->state : null;
        //         $data['kota'] = isset($result->address->city) ? $result->address->city : null;
        //         $data['kecamatan'] = isset($result->address->city_district) ? $result->address->city_district : null;
        //         $data['desa'] = isset($result->address->village) ? $result->address->village : null;
        //     }

        // } catch (BadResponseException $e) {

        // }

        $insert = DB::table('relawans')->insertGetId($data);

        return redirect("/successAdd");

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
