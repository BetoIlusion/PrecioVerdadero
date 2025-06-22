<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::whereDoesntHave('usuarioProductos', function ($query) {
            $query->where('existe', true);
        })->get();
        return response()->json($productos);
    }
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Producto encontrado.',
            'data' => $producto,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'disponibilidad' => 'required|boolean',
            'id_unidad' => 'nullable',
            'id_sub_tipo' => 'required|exists:sub_tipo_productos,id',
        ],);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422));
        }

        $validated = $validator->validated();

        if (Producto::where('nombre', $validated['nombre'])->exists()) {
            return response()->json([
                'message' => 'El producto ya existe.',
            ], 409);
        }

        $producto = Producto::create($validated);

        return response()->json([
            'message' => 'Producto creado exitosamente.',
            'data' => $producto,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'disponibilidad' => 'required|boolean',
            'id_unidad' => 'nullable',
            'id_sub_tipo' => 'required|exists:sub_tipo_productos,id',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422));
        }

        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        // Verificar si el nuevo nombre ya existe en otro producto
        $validated = $validator->validated();

        if (Producto::where('nombre', $validated['nombre'])->where('id', '!=', $id)->exists()) {
            return response()->json([
                'message' => 'Ya existe otro producto con ese nombre.',
            ], 409);
        }

        // Actualizar producto
        $producto->update($validated);

        return response()->json([
            'message' => 'Producto actualizado exitosamente.',
            'data' => $producto,
        ], 200);
    }
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado exitosamente.']);
    }
    public function getProductosBajoPrecioTienda(Request $request){
        $validator = Validator::make($request->all(), [
            'mi_latitud' => 'required|numeric',
            'mi_longitud' => 'required|numeric',
            'id_producto' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = auth()->user();
        $resultados = Producto::listaBajoPrecioTienda(
            $user->id,
            $request->mi_latitud,
            $request->mi_longitud,
            $request->id_producto
        );

        return response()->json($resultados);

    }
}
