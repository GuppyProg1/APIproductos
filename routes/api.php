<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoBaseController;



// Publico
Route::post('login',[AuthController::class, 'login']);

//Autenticadas
Route::middleware('auth:api')->group(function () {

    // GET /productos/{id} -> show (acceso: admin, usuario, y operador)
    Route::get('productos/{id}', [ProductoBaseController::class, 'show'])->middleware('role:admin,usuario,operador');
});

Route::middleware('auth:api')->group(function () {

    // PUT /productos/{id} -> update (acceso: admin y operador)
    Route::put('productos/{id}', [ProductoBaseController::class, 'update'])->middleware('role:admin,operador');
});

Route::middleware('auth:api')->group(function () {

    // DELETE /productos/{id} -> destroy (acceso: solo admin)
    Route::delete('productos/{id}', [ProductoBaseController::class, 'destroy'])->middleware('role:admin');
});

Route::middleware('auth:api')->group(function () {

    Route::get('me', [AuthController::class, 'me']);

    // GET /productos -> index (acceso: admin, usuario, y operador)
    Route::get('productos', [ProductoBaseController::class, 'index'])->middleware('role:admin,usuario,operador');
    // POST /productos -> store (acceso: admin y operador)
    Route::post('productos', [ProductoBaseController::class, 'store'])->middleware('role:admin,operador');
});

Route::middleware('auth:api')->group(function () {

    // POST /logout -> logout (acceso: usuario autenticado)
    Route::post('logout', [AuthController::class, 'logout'])->middleware('role:usuario');
});

Route::middleware('auth:api')->group(function () {

    // POST /refresh -> refresh (acceso: usuario autenticado)
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('role:usuario');
});

