<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validador = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validador->fails()){
            return response()->json(['errors' => $validador->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if(! $token = JWTAuth::attempt($credentials)){
            return response()->json(['message' => 'Credenciales invalidas'], 401);
        }

        return response()->json([
            'message' => 'Login Correcto',
            'token' => $token,
            'user' => auth('api')->user(),
        ]);
    }

    public function me(){
        return response()->json(auth('api')->user());
    }
}
