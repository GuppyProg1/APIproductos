<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ProductoController extends BaseController
{
    public function index(){
         return response()->json([
            'message'=> 'Listado de todos los productos',]);
    }

    public function store(Request $request){
         return response()->json([
            'message' => 'Producto creado'], 200);
    }

    public function show(String $id){
        return response()->json([
            'message' => "Mostrando el producto con id ($id)"]);
    }

    public function update(Request $request, String $id){
        return response()->json([
            'message' => "Producto con id ($id) actualizado"]);
    }

    public function destroy(String $id){
        return response()->json([
            'message' => "Producto con id ($id) eliminado"]);
    }



}
