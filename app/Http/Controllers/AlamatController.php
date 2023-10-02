<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlamatController extends Controller
{
    public function allProvinsi(Request $request)
    {
        $data = Provinsi::orderBy("nama")->get();

        return response()->json($data);
    }

    public function listKota(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'provinsi' => 'required|exists:provinsis,id_provinsi'
        ]);


        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $data = DB::table('kotas')->where('provinsi_id', $request->provinsi)->orderBy('nama', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function listKecamatan(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'kota' => 'required|exists:kotas,id_kota'
        ]);


        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $data = DB::table('kecamatans')->where('kota_id', $request->kota)->orderBy('nama', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function listDesa(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'kecamatan' => 'required|exists:kecamatans,id_kecamatan'
        ]);


        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $data = DB::table('desas')->where('kecamatan_id', $request->kecamatan)->orderBy('nama', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
