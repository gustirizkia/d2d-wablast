<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function updateProfile(Request $request)
    {
        $dataValidasi = [
            'name' => 'required|string',
            'phone' => 'required'
        ];

        $user = User::find(auth()->user()->id);

        if($request->email !== $user->email){
            $dataValidasi['email'] = 'required|email|unique:users,email';
        }

        $validasi = Validator::make($request->all(), $dataValidasi);

        if($validasi->fails()){
            return response()->json([
                'status' => 'success',
                'message' => $validasi->errors()->first()
            ], 422);
        }

        $data = $request->all();

        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        $data['updated_at'] = now();

        $user = User::where("id", auth()->user()->id)->update($data);

        return response()->json([
            'status' => 'success',
            'user' => $user = User::find(auth()->user()->id),
            'request' => $data
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json('ok');
    }

    public function login(Request $request)
    {


        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        if($user){

            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'message' => 'Login success',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ]);
            }


        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function getUser(){
        return response()->json(auth()->user());
    }
}
