<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dapil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DapilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Dapil::withCount("caleg", 'saksi')->paginate(12);
        // return response()->json($data);

        return view('pages.dapil.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dapil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'caleg.*.nama' => "required|string",
            'caleg.*.nomor' => "required|numeric",
            'image' => 'required|image',
            'nama_dapil' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        DB::beginTransaction();

        try {

            // insert dapil
            $image = $request->image->store("real-count", 'public');
            $uuidDapil = generateUuid('dapils');

            $dapilId = DB::table('dapils')->insertGetId([
                'uuid' => $uuidDapil,
                'title' => $request->nama_dapil,
                'deskripsi' => $request->deskripsi,
                'image' => $image,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            // insert dapil end

            // insert caleg
            foreach($request->caleg as $caleg){
                $insertCaleg = DB::table('calegs')->insertGetId([
                    'nama' => $caleg['nama'],
                    'nomor' => $caleg['nomor'],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'dapil_uuid' => $uuidDapil
                ]);
            }
            // insert caleg end

            DB::commit();
            return redirect()->route('admin.real-count.dapil.index')->with('success', "Berhasil tambah dapil");
        } catch (Exception $th) {
            DB::rollBack();
            saveError("DapilController->store", $th->getMessage());

            return redirect()->back()->with('error', "Gagal Simpan data Server Error");
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
        $item = Dapil::where("uuid", $id)->first();

        return view('pages.dapil.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'caleg.*.nama' => "required|string",
            'caleg.*.nomor' => "required|numeric",
            'image' => 'image',
            'nama_dapil' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $dataInsert = [
                'title' => $request->nama_dapil,
                'deskripsi' => $request->deskripsi,
                'created_at' => now(),
            ];

            if ($request->image) {
                $image = $request->image->store("real-count", 'public');
                $dataInsert['image'] = $image;
            }

            $updateDapil = DB::table('dapils')->where('uuid', $id)->update($dataInsert);

            // delete caleg
            DB::table('calegs')->where('dapil_uuid', $id)->delete();

            // insert caleg
                foreach($request->caleg as $caleg){
                    $insertCaleg = DB::table('calegs')->insertGetId([
                        'nama' => $caleg['nama'],
                        'nomor' => $caleg['nomor'],

                        'updated_at' => now(),
                        'dapil_uuid' => $id
                    ]);
                    // dd($caleg, $uuidDapil);
                }
            // insert caleg end

            DB::commit();
            return redirect()->route('admin.real-count.dapil.index')->with('success', "Berhasil update dapil");

        } catch (Exception $th) {
            DB::rollBack();
            saveError("DapilController->store", $th->getMessage());

            return redirect()->back()->with('error', "Gagal Simpan data Server Error");
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
