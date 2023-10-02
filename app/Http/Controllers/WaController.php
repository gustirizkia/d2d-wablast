<?php

namespace App\Http\Controllers;

use App\Models\MessageHasJawaban;
use App\Models\MessageWa;
use App\Models\Soal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $message = MessageWa::withCount("msgHasJawaban")->paginate(12);

        return view('pages.wa.index', [
            'message' => $message
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $messageHasJawaban = MessageHasJawaban::get();
        $soal = Soal::orderBy('title')->whereNotIn("id", $messageHasJawaban->pluck("soal_id"))->get();
        return view("pages.wa.create", [
            'soals' => $soal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $formMessage = [
            'message' => $request->message,
            'updated_at' => now(),
            'created_at' => now()
        ];

        if($request->image){
            $formMessage['image'] = $request->image->store("wa/image", "public");
        }

        DB::beginTransaction();

        try {

            $insertMessage = DB::table("message_was")->insertGetId($formMessage);

            if($request->jawaban_id){
                foreach($request->jawaban_id as $jawaban){

                    $pilihan = DB::table("pilihan_gandas")->find($jawaban);

                    $messageHasJawaban = DB::table("message_has_jawabans")->insertGetId([
                        'message_id' => $insertMessage,
                        'pilihan_id' => $jawaban,
                        "soal_id" => $pilihan->soal_id,
                        'created_at' => now()
                    ]);
                }
            }

            if($request->jawaban_iya_tidak){
                foreach($request->jawaban_iya_tidak as $soal_id => $jawaban){

                    $messageHasJawaban = DB::table("message_has_jawabans")->insertGetId([
                        'message_id' => $insertMessage,
                        'ya_tidak' => $jawaban,
                        "soal_id" => $soal_id,
                        'created_at' => now()
                    ]);
                }

            }

            DB::commit();

            return redirect()->route("admin.wa.index")->with("success", "Berhasil tambah data");
        } catch (Exception $th) {
            DB::rollBack();

            return redirect()->back()->with("error", "Gagal tambah data");
        }

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
        $message = MessageWa::findOrFail($id);
        $messageHasJawaban = MessageHasJawaban::where("message_id", $id)->get();
        $soalActive = Soal::whereIn("id", $messageHasJawaban->pluck("soal_id"))->orderBy("title")->get();
        $soal = Soal::orderBy('title')->whereNotIn("id", $messageHasJawaban->pluck("soal_id"))->get();

        return view("pages.wa.edit", [
            'soals' => $soal,
            'message' => $message,
            'messageHasJawaban' => $messageHasJawaban,
            "soalActive" => $soalActive
        ]);
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
        $message = MessageWa::findOrFail($id);
        $detail = MessageHasJawaban::where("message_id", $id)->delete();

        $message->delete();

        return redirect()->back()->with("success", "Berhasil hapus data");
    }

    public function getSoal(Request $request)
    {
        $search = $request->search;

        if($search == ""){
            $soal = DB::table("soals")->orderBy("title")->limit(5)->get();
        }else{
            $soal = DB::table("soals")->orderBy("title")->where("title", "LIKE", "%$search%")->limit(5)->get();
        }

        $response = array();
        foreach($soal as $soals){
           $response[] = array(
                "id"=>$soals->id,
                "text"=>$soals->title
           );
        }

        return response()->json($response);
    }
    public function getJawaban(Request $request)
    {
        $search = $request->search;

        if($search == ""){
            $pilihan = DB::table("pilihan_gandas")->orderBy("title")->where("soal_id", $request->soal)->limit(5)->get();
        }else{
            $pilihan = DB::table("pilihan_gandas")->orderBy("title")->where("soal_id", $request->soal)->where("title", "LIKE", "%$search%")->limit(5)->get();
        }


        $response = array();

        $soal = DB::table("soals")->find($request->soal);
        if($soal->yes_no){
            $response = [
                [
                    "id" => "iya",
                    "text" => "iya"
                ],
                [
                    "id" => "tidak",
                    "text" => "tidak"
                ],
            ];
        }else{
            foreach($pilihan as $pilihans){
               $response[] = array(
                    "id"=>$pilihans->id,
                    "text"=>$pilihans->title
               );
            }
        }


        return response()->json($response);
    }
}
