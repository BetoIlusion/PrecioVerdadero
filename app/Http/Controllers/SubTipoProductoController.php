<?php

namespace App\Http\Controllers;

use App\Models\SubTipoProducto;
use Illuminate\Http\Request;

class SubTipoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subtipos = SubTipoProducto::all();
        return response()->json($subtipos);
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
        $validatedData = $request->validate([
            'sub_tipo' => 'required|string|max:255',
            'id_tipo' => 'required|exists:tipo_productos,id',
        ],
        [
            'sub_tipo.required' => 'El campo sub_tipo es obligatorio.',
            'id_tipo.required' => 'El campo id_tipo es obligatorio.',
            'id_tipo.exists' => 'El tipo de producto seleccionado no existe.',
        ]);
        $subTipoProducto = SubTipoProducto::create($validatedData);
        return response()->json($subTipoProducto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subTipoProducto = SubTipoProducto::find($id);
        if (!$subTipoProducto) {
            return response()->json(['message' => 'Sub tipo de producto no encontrado'], 404);
        }
        return response()->json($subTipoProducto);
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
        $subTipoProducto = SubTipoProducto::find($id);
        if (!$subTipoProducto) {
            return response()->json(['message' => 'Sub tipo de producto no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'sub_tipo' => 'required|string|max:255',
            'id_tipo' => 'required|exists:tipo_productos,id',
        ],
        [
            'sub_tipo.required' => 'El campo sub_tipo es obligatorio.',
            'id_tipo.required' => 'El campo id_tipo es obligatorio.',
            'id_tipo.exists' => 'El tipo de producto seleccionado no existe.',
        ]);

        $subTipoProducto->update($validatedData);
        return response()->json($subTipoProducto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subTipoProducto = SubTipoProducto::find($id);
        if (!$subTipoProducto) {
            return response()->json(['message' => 'Sub tipo de producto no encontrado'], 404);
        }
        $subTipoProducto->delete();
        return response()->json(['message' => 'Sub tipo de producto eliminado correctamente']);
    }
}
