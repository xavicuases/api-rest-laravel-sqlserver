<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // 1. LISTAR todos los productos (con su categoría)
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return response()->json([
            'status' => 'success',
            'data' => $productos
        ], 200);
    }

    // 2. CREAR un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Precio' => 'required|numeric',
            'Stock' => 'required|integer',
            'CategoriaID' => 'required|integer'
        ]);

        $producto = Producto::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Producto creado correctamente',
            'data' => $producto
        ], 201);
    }

    // 3. MOSTRAR un producto específico
    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $producto
        ], 200);
    }

    // 4. ACTUALIZAR un producto
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $request->validate([
            'Nombre' => 'string|max:100',
            'Precio' => 'numeric',
            'Stock' => 'integer',
            'CategoriaID' => 'integer'
        ]);

        $producto->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Producto actualizado correctamente',
            'data' => $producto
        ], 200);
    }

    // 5. ELIMINAR un producto
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Producto eliminado correctamente'
        ], 200);
    }
}