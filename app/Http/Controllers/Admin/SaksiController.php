<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dapil;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas("saksi.dapil")->get();

        return view('pages.Saksi.Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();
        $listKota = Kota::orderBy('nama', 'asc')->whereIn('provinsi_id', $provinsi->pluck("id_provinsi"))->get();
        $listKecamatan = Kecamatan::orderBy('nama', 'asc')->whereIn('kota_id', $listKota->pluck("id_kota"))->get();
        $dapil = Dapil::get();

        return view('pages.Saksi.Create', compact('provinsi', 'listKecamatan', 'listKota', 'dapil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'provinsi' => 'required|exists:provinsis,id_provinsi',
            'dapil' => 'required|exists:dapils,id',
            'kota' => 'required|exists:kotas,id_kota',
            'kecamatan' => 'required|exists:kecamatans,id_kecamatan',
            'desa' => 'required|exists:desas,id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string',
            'alamat' => 'required|string'
        ]);

        DB::beginTransaction();

        try {

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'provinsi_id' => $request->provinsi,
                'kota_id' => $request->kota,
                'kecamatan_id' => $request->kecamatan,
                'desa_id' => $request->desa,
                'target' => $request->target,
                'username' => $request->username,
                'target' => 0
            ];

            $user = User::create($data);

            $saksi = DB::table('saksis')->insertGetId([
                'user_id' => $user->id,
                'dapil_id' => $request->dapil,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            return redirect()->route('admin.real-count.saksi.index')->with('success', "Berhasil tambah saksi");
        } catch (Exception $th) {
            DB::rollBack();

            saveError("SaksiController->store", $th->getMessage());

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
        //
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
        $data = User::findOrFail($id);

        $data->delete();

        return redirect()->back()->with('success', "Berhasil hapus saksi");
    }

    public function getSurveyor(Request $request)
    {
        $search = $request->search;
        if($search == ''){
           $user = User::orderby('email','asc')->limit(7)->get();
        }else{
           $user = User::orderby('email','asc')->where('email', 'like', '%' .$search . '%')->limit(7)->get();
        }



        $response = array();
        foreach($user as $users){
           $response[] = array(
                "id"=>$users->id,
                "text"=>$users->name."/".$users->email
           );
        }

        return response()->json($response);

    }
}
