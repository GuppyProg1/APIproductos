<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

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

        // generar código de 6 dígitos
        $codigo = random_int(100000, 999999);

        // guardar código en la base de datos
        $user->login_code = $codigo;
        $user->save();

        // enviar correo
        Mail::raw("Tu código de verificacion es: $codigo", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Código de verificacion de acceso');
        });

        return response()->json([
            'message' => 'Se envió un código de verificación al correo'
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
