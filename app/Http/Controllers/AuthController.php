<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $user = JWTAuth::user();

        return response()->json([
            'message' => 'Login Correcto',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function me(){
        return response()->json(auth('api')->user());
    }

    public function logout(Request $request){
       
        try {
           JWTAuth::invalidate(JWTAuth::getToken());
           return response()->json(['message' => 'Logout exitoso'], 200);
        }catch (JWTException $e) {
            return response()->json(['message' => 'Error al cerrar sesión'], 500);
        }
    }

    public function refresh(){

            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'message' => 'Token refrescado correctamente',
                'token' => $newToken,
            ]);

    }


}
