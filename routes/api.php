<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoBaseController;


// PUBLICO
Route::post('login',[AuthController::class, 'login']);

Route::post('verify-code',[AuthController::class,'verifyCode']);


// RUTAS AUTENTICADAS
Route::middleware('auth:api')->group(function () {

    // AUTH
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    // PRODUCTOS

    // GET /productos -> admin, usuario y operador
    Route::get('productos', [ProductoBaseController::class, 'index'])
        ->middleware('role:admin,usuario,operador');

    // POST /productos -> admin, operador
    Route::post('productos', [ProductoBaseController::class, 'store'])
        ->middleware('role:admin,operador');

    // GET /productos/{id} -> admin, usuario, operador
    Route::get('productos/{id}', [ProductoBaseController::class, 'show'])
        ->middleware('role:admin,usuario,operador');

    // PUT /productos/{id} -> admin
    Route::put('productos/{id}', [ProductoBaseController::class, 'update'])
        ->middleware('role:admin');

    // DELETE /productos/{id} -> solo admin
    Route::delete('productos/{id}', [ProductoBaseController::class, 'destroy'])
        ->middleware('role:admin');

});