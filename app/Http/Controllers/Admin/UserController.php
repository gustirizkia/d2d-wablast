<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataTarget;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $data['user'] = User::where('roles', 'user')
                ->when($q, function($query)use($q){
                   return $query->where(function($result)use($q){
                        return $result->where("name", "LIKE", "%$q%")->orWhere("email", "LIKE", "%$q%");
                    });
                })
                ->orderBy('id', 'desc')->paginate(12);

        return view('pages.user.user', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();
        return view('pages.user.user-create', compact('provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|unique:users,email|email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string',
            'name' => 'required|string',
            'desa' => 'required|exists:desas,id',
            'provinsi' => 'required|exists:provinsis,id_provinsi'
        ]);

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
        ];

        $user = User::create($data);

        return redirect()->route('admin.data.user.index')->with('success', "Berhasil tambah user");

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = User::findOrFail($id);
        $responden = DataTarget::where("user_survey_id", $id)->paginate(12);

        $count['responden'] = count(DataTarget::where("user_survey_id", $id)->get());
        $count['responden_kecamatan'] = count(DataTarget::where("user_survey_id", $id)->groupBy("kecamatan_id")->get());
        $count['responden_provinsi'] = count(DataTarget::where("user_survey_id", $id)->groupBy("provinsi_id")->get());
        $count['responden_kota'] = count(DataTarget::where("user_survey_id", $id)->groupBy("kota_id")->get());


        return view('pages.user.detail', [
            'item' => $item,
            'responden' => $responden,
            'count' => $count
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::findOrFail($id);
        // dd($item);
        $provinsi = Provinsi::whereIn('id', [11, 16])->orderBy('nama', 'asc')->get();

        return view('pages.user.user-edit', compact('item', 'provinsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
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

        return redirect()->route('admin.data.user.index')->with('success', "Berhasil update data user");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
