<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] = User::where('roles', 'admin')->paginate(12);

        return view('pages.admin.user', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();
        $listKota = Kota::orderBy('nama', 'asc')->whereIn('provinsi_id', $provinsi->pluck("id_provinsi"))->get();
        $listKecamatan = Kecamatan::orderBy('nama', 'asc')->whereIn('kota_id', $listKota->pluck("id_kota"))->get();

        return view('pages.admin.user-create', compact('provinsi', 'listKecamatan', 'listKota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'email' => 'required|unique:users,email|email',
                'username' => 'required|unique:users,username',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|string',
                'name' => 'required|string',
                'desa' => 'required|exists:desas,id',
                'provinsi' => 'required|exists:provinsis,id_provinsi',
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
                'username' => $request->username,
                'roles' => 'admin'
            ];

            $user = User::create($data);

            DB::commit();

            return redirect()->route('admin.administator.index')->with('success', "Berhasil tambah admin");
        } catch (Exception $th) {
            DB::rollBack();
            // dd($th);
            return redirect()->back()->with("error", "Gagal tambah admin");
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
        $item = User::findOrFail($id);
        // dd($item);
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();

        return view('pages.admin.user-edit', compact('item', 'provinsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required|string',
            'desa' => 'required|exists:desas,id',
            'provinsi' => 'required|exists:provinsis,id_provinsi'
        ]);

        $validasi = [
            'name' => 'required|string'
        ];
        $user = User::findOrFail($id);

        if($request->email !== $user->email){
            $validasi['email'] = 'required|unique:users,email|email';
        }

        if($request->phone !== $user->phone){
            $validasi['phone'] = 'required|unique:users,phone';
        }

        $request->validate($validasi);
        // dd($request->all());
        $data = $request->except(['_token', '_method']);
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }else{
            unset($data['password']);
        }

        $data['desa_id'] = $request->desa;
        $data['kecamatan_id'] = $request->kecamatan;
        $data['kota_id'] = $request->kota;
        $data['provinsi_id'] = $request->provinsi;

        $user->update($data);

        return redirect()->route('admin.administator.index')->with('success', "Berhasil update data admin");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back()->with('success', "Berhasil hapus data");
    }
}
