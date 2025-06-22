<?php

namespace App\Http\Controllers;

use App\Models\HistorialProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Historial = HistorialProducto::all();
        return response()->json($Historial);
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'precio' => 'required|numeric',
            'fecha' => 'required|date',
            'fecha_hora' => 'required|date_format:Y-m-d H:i:s',
            'id_usuario_producto' => 'required|exists:usuario_productos,id',
            'id_estado_producto' => 'required|exists:estado_productos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $historialProducto = HistorialProducto::create($request->all());
        return response()->json($historialProducto, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
