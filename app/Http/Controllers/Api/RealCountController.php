<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RealCountController extends Controller
{
    public function getData(){
        $saksi = DB::table("saksis")->where('user_id', auth()->user()->id)->first();
        $data = DB::table("dapils")->where('id', $saksi->dapil_id)->first();
        $caleg = DB::table('calegs')->where("dapil_uuid", $data->uuid)->get();

        return response()->json([
            'dapil' => $data,
            'caleg' => $caleg
        ]);

    }

    public function inputSaksi(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'caleg' => 'required',
            'foto_c1' => 'required|image',
            'foto_diri_di_tps' => 'required|image',
            'rw' => 'required',
            'rt' => 'required',
            'tps' => 'required',
            'total_dpt' => 'required',
            'suara_sah' => 'required',
            'suara_tidak_sah' => 'required',
            'golput' => 'required',
        ]);

        if($validasi->fails())
        {
            return response()->json([
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $c1 = $request->foto_c1->store("real-count/c1", "public");
        $foto_diri_di_tps = $request->foto_c1->store("real-count/foto_di_tps", "public");
        $uuidInputanSaksi = generateUuid("inputan_saksis");

        $formInputSaksi = [
            'uuid' => $uuidInputanSaksi,
            'foto_c1' => $c1,
            'foto_diri_di_tps' => $foto_diri_di_tps,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'tps' => $request->tps,
            'total_dpt' => $request->total_dpt,
            'suara_sah' => $request->suara_sah,
            'suara_tidak_sah' => $request->suara_tidak_sah,
            'golput' => $request->golput,
            'created_at' => now(),
            'updated_at' => now(),
            "user_id" => auth()->user()->id,
        ];

        DB::beginTransaction();

        try {

            $cekInputanSaksi = DB::table("inputan_saksis")->where("user_id", auth()->user()->id)->first();
            if($cekInputanSaksi){
                return response()->json("Saksi sudah melakukan penginputan", 422);
            }

            $inputsaksi = DB::table('inputan_saksis')->insertGetId($formInputSaksi);

            $caleg = $request->caleg;

            foreach ($caleg as $key => $value) {
                DB::table("suara_calegs")->insertGetId([
                    'input_saksi_uuid' => $uuidInputanSaksi,
                    'caleg_id' => $value->id,
                    'jumlah_suara' => $value->suara,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::rollBack();

            return response()->json([
                'status' => 'success',
                "message" => "berhasil input data saksi"
            ]);

        } catch (Exception $th) {
            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage()
            ], 422);
        }


    }
}
