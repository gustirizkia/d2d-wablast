<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
}
