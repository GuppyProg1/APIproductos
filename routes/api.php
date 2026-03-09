<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoBaseController;



// Publico
Route::post('login',[AuthController::class, 'login']);

//Autenticadas
Route::middleware('auth:api')->group(function () {

    Route::get('me', [AuthController::class, 'me']);

    //solo consulta: admin y usuario
    Route::get('productos', [ProductoBaseController::class, 'index'])->middleware('role:admin,usuario');
    Route::post('productos', [ProductoBaseController::class, 'store'])->middleware('role:admin');
});

