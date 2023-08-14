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

class SurveyApiController extends Controller
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
            $insertData = DB::table('data_targets')->find($insertData);

            DB::commit();
            return response()->json($insertData);
        } catch (Exception $th) {
            // dd($th, $request->all());
            DB::rollBack();

            return response()->json([
                "Gagal Input Data",
                "message" => $th->getMessage()
            ], 422);
        }
    }

    public function selesaiQuiz(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'pilihan' => 'required',
            'image' => 'required|image'
        ]);

        if($validasi->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $pilihan = json_decode($request->pilihan);

        DB::beginTransaction();

        try {
            $target = DB::table("data_targets")->find($request->target_id);
            if($target->foto_bersama){
                return response()->json("Image ", 422);
            }

            foreach($pilihan as $item)
            {
                $formData = [
                        'created_at' => now(),
                        'updated_at' => now(),
                        'data_target_id' => $target->id,
                        'data_target_id' => $item->soal_id,
                        'kecamatan_id' => $target->kecamatan_id
                ];

                if($item->yes_no){
                    $formData['yes_no'] = $item->yes_no;
                    DB::table("pilihan_targets")->insertGetId($formData);
                }else{
                    $formData['pilihan_ganda_id'] = $item->pilihan_id;
                    DB::table("pilihan_targets")->insertGetId($formData);
                }
            }

            $image = $request->image->store("foto-bersama", 'public');
            $inserTarget = DB::table("data_targets")->where('id', $target->id)->update([
                'foto_bersama' => $image
            ]);

            $target['item'] = DB::table("data_targets")->find($target->id);
            $target['pilihan_request'] = $pilihan;

            Db::commit();
            return response()->json($target);
        } catch (Exception $th) {
            DB::rollBack();

            return response()->json(["error server", $th->getMessage(), $request->all()], 422);

        }

        return response()->json($pilihan);
    }
}
