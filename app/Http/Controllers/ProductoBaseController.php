<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ProductoCreadoMail;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', // campo stock agregado
            'descripcion' => 'nullable|string'   //  campo descripcion agregado
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Con fillable, todo se guarda directamente
        $producto = Producto::create($validator->validated());

         // enviar notificación por correo
         Mail::to('admin@api.com')->send(new ProductoCreadoMail($producto));

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data'=> $producto
        ], 201);
    }

    public function show(String $id){
        $producto = Producto::find($id);

        if(!$producto){
            return response()->json([
                'message' => "No se encontró el producto con id ($id)",
                'data' => [] // array vacío en caso de no existir
            ], 404);
        }

        return response()->json([
            'message' => "Producto encontrado con id ($id)",
            'data'=> [$producto->toArray()]  // <-- IMPORTANTE
        ], 200);
    }

    
    public function update(Request $request, String $id){
        $producto = Producto::find($id);

        if(!$producto){
            return response()->json([
            'message' => "No se encontro el producto solicitado con id ($id)"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:100',
            'precio' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',           // nuevo campo stock
            'descripcion' => 'sometimes|string|nullable'    // nuevo campo descripcion
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Con fillable, todos los campos se actualizan directamente
        $producto->update($validator->validated());

        return response()->json([
            'message' => "Producto con id ($id) actualizado correctamente",
            'data'=> $producto
        ]);
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
