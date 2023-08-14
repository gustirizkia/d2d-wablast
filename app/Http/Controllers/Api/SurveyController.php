<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\Kota;
use App\Models\UserHasKota;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $data = DataTarget::withCount('pilihanTarget')->where("user_survey_id", auth()->user()->id)->orderBy('id', 'desc')->get();

        $listKota = UserHasKota::with("kota")->where("user_id", auth()->user()->id)->where('status', 0)->get();

        return response()->json([
            'list_kota' => $listKota,
            'target_list' => $data
        ]);
    }

    public function detailKecamatan($kota_id)
    {
        $kota = Kota::with('provinsi', "kecamatan")->where('id_kota', $kota_id)->first();

        return response()->json([
            'data' => $kota
        ]);

    }

    public function inputTarget(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required',
            'provinsi' => 'required|exists:provinsis,id_provinsi',
            'kota' => 'required|exists:kotas,id_kota',
            'kecamatan' => 'required|exists:kecamatans,id_kecamatan',
            'desa' => 'required|exists:desas,id',
        ]);

        if($validasi->fails()){
            return response()->json([
                'error' => $validasi->errors()->first()
            ], 422);
        }

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'user_survey_id' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ];

        $data['provinsi_id'] = $request->provinsi;
        $data['kota_id'] = $request->kota;
        $data['kecamatan_id'] = $request->kecamatan;
        $data['desa_id'] = $request->desa;


        DB::beginTransaction();

        try {
            $userHasKota = DB::table('user_has_kotas')->where('user_id', auth()->user()->id)->where('status', 0)->where("kota_id", $request->kota)->first();

            $updateHasKota = DB::table('user_has_kotas')->where("id", $userHasKota->id)->update([
                'status' => 1
            ]);

            $insertData = DB::table('data_targets')->insertGetId($data);

            DB::commit();
            return redirect()->route('quiz', $insertData)->with('success', "Berhasil simpan data");
        } catch (Exception $th) {
            // dd($th, $request->all());
            DB::rollBack();

            return redirect()->back()->with('error', "Gagal Input Data");
        }
    }
}
