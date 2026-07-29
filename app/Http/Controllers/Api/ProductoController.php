<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    // Definimos las reglas de validación
    $validator = Validator::make($request->all(), [
        'Nombre' => 'required|string|max:255',
        'Precio' => 'required|numeric|min:0', // Evita precios negativos
        'Stock' => 'required|integer|min:0', // Evita stock negativo
        'CategoriaID' => 'required|integer|exists:Categorias,CategoriaID' // Valida que la categoría exista
    ]);

    // Si la validación falla, devolvemos un error 422 (Unprocessable Entity) con los detalles
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error de validación en los datos enviados',
            'errors' => $validator->errors()
        ], 422);
    }

    // Si pasa la validación, procedemos a crear el producto
    // (Aquí va tu lógica actual para guardar en la base de datos)
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
        // Buscamos si el producto existe
    $producto = Producto::find($id);

    if (!$producto) {
        return response()->json([
            'status' => 'error',
            'message' => 'Producto no encontrado'
        ], 404);
    }

    // Reglas de validación para actualizar (pueden ser opcionales o estrictas según tu lógica)
    $validator = Validator::make($request->all(), [
        'Nombre' => 'sometimes|required|string|max:255',
        'Precio' => 'sometimes|required|numeric|min:0',
        'Stock' => 'sometimes|required|integer|min:0',
        'CategoriaID' => 'sometimes|required|integer|exists:Categorias,CategoriaID'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error de validación en los datos a actualizar',
            'errors' => $validator->errors()
        ], 422);
    }

    // Actualizamos el producto con los datos validados
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