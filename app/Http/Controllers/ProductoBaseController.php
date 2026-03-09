<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoBaseController extends BaseController
{
    public function index(){

        $productos = Producto::all();

         return response()->json([
            'message'=> 'Listado de todos los productos',
            'data'=> $productos,]);
    }

    public function store(Request $request){

        $productos = Producto::create([
            'nombre' => $request->input('nombre','Producto sin nombre'),
            'precio' => $request->input('precio',0),
        ]);

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data'=> $productos,], 201);
    }

    public function show(String $id){

        $producto = Producto::find($id);

        if(!$producto){
            return response()->json([
            'message' => "No se encontro el producto solicitado con id ($id)"], 404);
        }

        return response()->json([
            'message' => "Producto encontrado con id ($id)",
            'data'=> $producto]);
    }

    public function update(Request $request, String $id){

        $producto = Producto::find($id);

         if(!$producto){
            return response()->json([
            'message' => "No se encontro el producto solicitado con id ($id)"], 404);
        }

        $producto->update([
            'nombre' => $request->input('nombre', $producto->nombre),
            'precio' => $request->input('precio', $producto->precio),
        ]);

        return response()->json([
            'message' => "Producto con id ($id) actualizado correctamente",
            'data'=> $producto]);
    }

    public function destroy(String $id){

        $producto = Producto::find($id);

         if(!$producto){
            return response()->json([
            'message' => "No se encontro el producto solicitado con id ($id)"], 404);
        }

        $producto->delete();

        return response()->json([
            'message' => "Producto con id ($id) ha sido eliminado"]);
    }



}
