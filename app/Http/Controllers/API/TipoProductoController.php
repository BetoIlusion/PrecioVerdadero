<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoProducto;
use App\Http\Controllers\API\TipoProductoController as APITipoProductoController;
use Illuminate\Http\Request;

class TipoProductoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        if ($user->hasRole('Super Admin')) {
         
            return response()->json(TipoProducto::all());
        }

        // Resto de roles
        if ($user->hasRole('Mercader')) {
            return "este es mercader";
            $tiposProductos = TipoProducto::where('usuario_id', $user->id)->get();
        } elseif ($user->hasRole('Cliente')) {
            return "este es cliente";
            $tiposProductos = TipoProducto::where('estado', 'activo')->get();
        } else {
            return response()->json(['error' => 'No autorizado.'], 403);
        }
        return response()->json($tiposProductos);
    }

    public function show($id)
    {
        $tipoProducto = TipoProducto::findOrFail($id);
        return response()->json($tipoProducto);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
        ]);

        if (TipoProducto::where('tipo', $validated['tipo'])->exists()) {
            return response()->json([
                'message' => 'El tipo de producto ya existe.',
            ], 409);
        } else {
            $tipoProducto = TipoProducto::create($validated);
            return response()->json([
                'message' => 'Tipo de producto creado exitosamente.',
                'data' => $tipoProducto
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);

        // Busca el tipo de producto por ID
        $tipoProducto = TipoProducto::findOrFail($id);

        // Actualiza los datos
        $tipoProducto->update($request->all());

        // Retorna respuesta JSON
        return response()->json([
            'message' => 'Tipo de producto actualizado exitosamente.',
            'data' => $tipoProducto
        ]);
    }
    public function destroy($id)
    {
        $tipoProducto = TipoProducto::findOrFail($id);
        $tipoProducto->delete();
        return response()->json(['message' => 'Tipo de producto eliminado exitosamente.']);
    }

    public function mostrarSubTipos($id)
    {
        $tipoProducto = TipoProducto::findOrFail($id);
        $subTipos = $tipoProducto->subTipos; // Asumiendo que tienes una relación definida en el modelo TipoProducto
        return response()->json($subTipos);
    }

}
