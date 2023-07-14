<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlamatController extends Controller
{
    public function listKota(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'provinsi' => 'required|exists:provinces,province_id'
        ]);


        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $data = DB::table('cities')->where('province_id', $request->provinsi)->orderBy('city_name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function listKecamatan(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'kota' => 'required|exists:cities,city_id'
        ]);


        if($validasi->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $data = DB::table('subdistricts')->where('city_id', $request->kota)->orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
