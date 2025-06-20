<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\UsuarioProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioProductoController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }
        $usuarioProductos = UsuarioProducto::where('id_usuario', $user->id)
            ->where('existe', true)
            ->get();
        if ($usuarioProductos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos para este usuario.'], 404);
        }
        return response()->json($usuarioProductos);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'precio' => 'required',
            'existe' => 'required|boolean',
            'id_producto' => 'required|exists:productos,id',
            'id_sub_tipo' => 'required|exists:sub_tipo_productos,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }
        if (UsuarioProducto::where('id', $user->id)
            ->where('id_producto', $request->id_producto)
            ->where('existe', false)
            ->exists()
        ) {
            $usuarioProducto = new UsuarioProducto();
            $usuarioProducto->existe = true;
            $usuarioProducto->save();
        }

        $usuarioProducto = new Producto();
        $usuarioProducto->id_usuario = $user->id;
        $usuarioProducto->id_producto = $request->id_producto;
        $usuarioProducto->id_sub_tipo = $request->id_sub_tipo;
        $usuarioProducto->precio = $request->precio;
        $usuarioProducto->existe = $request->existe;
        $usuarioProducto->save();

        return response()->json([
            'message' => 'Producto creado exitosamente.',
            'usuario_producto' => $usuarioProducto
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $usuarioProducto = UsuarioProducto::where('id_usuario', $user->id)
            ->where('id_producto', $id)
            ->where('existe', true)
            ->first();
        if (!$usuarioProducto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($usuarioProducto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $usuarioProducto = UsuarioProducto::where('id_usuario', $user->id)
            ->where('id_producto', $id)
            ->first();
        if (!$usuarioProducto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'precio' => 'required',
            'existe' => 'required|boolean',
            'id_sub_tipo' => 'required|exists:sub_tipo_productos,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $usuarioProducto->precio = $request->precio;
        $usuarioProducto->existe = $request->existe;
        $usuarioProducto->id_sub_tipo = $request->id_sub_tipo;
        $usuarioProducto->save();

        return response()->json([
            'message' => 'Producto actualizado exitosamente.',
            'usuario_producto' => $usuarioProducto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updateExiste(Request $request, string $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'existe' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $usuarioProducto = UsuarioProducto::where('id_usuario', $user->id)
            ->where('id_producto', $id)
            ->first();

        if (!$usuarioProducto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $usuarioProducto->existe = $request->existe;
        $usuarioProducto->save();

        return response()->json([
            'message' => 'Atributo "existe" actualizado exitosamente.',
            'usuario_producto' => $usuarioProducto
        ]);
    }
    public function updatePrecio(Request $request, string $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'precio' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $usuarioProducto = UsuarioProducto::where('id_usuario', $user->id)
            ->where('id_producto', $id)
            ->first();

        if (!$usuarioProducto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $usuarioProducto->precio = $request->precio;
        $usuarioProducto->save();

        return response()->json([
            'message' => 'Precio actualizado exitosamente.',
            'usuario_producto' => $usuarioProducto
        ]);
    }
}
