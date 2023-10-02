<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RelawanController extends Controller
{
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            "foto_bersama" => "required|image",
            'provinsi' => "required|exists:provinsis,id_provinsi",
            'kota' => "required|exists:kotas,id_kota",
            'kecamatan' => "required|exists:kecamatans,id_kecamatan",
            'desa' => "required|exists:desas,id",
            'latitude' => "required|string",
            'longitude' => "required|string",
            'nama' => "required|string",
            'alamat' => "required|string",
            'tanggal_lahir' => "required|string",
            'no_telepon' => "required|string",
            'nik' => "required|string",
        ]);

        if($validasi->fails()){
            return response()->json([
                'message' => $validasi->errors(),
                'request_all' => $request->all()
            ], 422);
        }

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
            "provinsi_id" => $request->provinsi,
            "kota_id" => $request->kota,
            "kecamatan_id" => $request->kecamatan,
            "desa_id" => $request->desa,
            "tanggal_lahir" => $request->tanggal_lahir,
            "no_telepon" => $request->no_telepon,
            "nik" => $request->nik,
            "user_id" => auth()->user()->id,
        ];

        if($request->foto_ktp){
            $ktp = $request->foto_ktp->store("relawan/ktp", "public");
            $data['foto_ktp'] = $ktp;
        }

        $foto_bersama = $request->foto_bersama->store("relawan/foto-diri", "public");
        $data['foto_bersama'] = $foto_bersama;

        $data['jk'] = $request->jenis_kelamin;

        $insert = DB::table('relawans')->insertGetId($data);

        $message = DB::table("message_was")->orderBy("id", "desc")->first();

        try {
            $client = new Client();
            $response = $client->post(env("WA_API")."send-message", [
                'verify' => false,
                "headers" => [
                    "Authorization" => "E9cLvPNczzD6Nuiv6VjvndQfQPkBBXyph3zhaIgFiWETQghueV2wnlgl37ra6V7R",
                ],
                "form_params" => [
                    "phone" => $request->no_telepon,
                    "message" => "Hallo $request->nama, terimakasih sudah bergabung bersama relawan Saderek Nirwana. Cek data anda di website resmi kami http://d2d.binamuda.com/"
                ]
            ]);

            return response()->json($response->getBody());
        } catch (RequestException $th) {
            $exception = json_decode($th->getMessage());
            return response()->json([$exception, $th->getMessage(), env("WA_API")]);
        }

        return response()->json([
            "sucess" => true,
            'message' => "Berhasil input relawan"
        ]);
    }
}
