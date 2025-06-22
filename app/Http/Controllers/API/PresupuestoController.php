<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Presupuesto;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presupuestos = Presupuesto::all();
        if ($presupuestos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron presupuestos.'], 404);
        }
        return response()->json($presupuestos);
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
        $validator = Validator::make($request->all(), [
            'presupuesto' => 'required|numeric',
            'cantidad_personas' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $presupuesto = Presupuesto::create($validator->validated());

        return response()->json($presupuesto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $presupuesto = Presupuesto::find($id);
        if (!$presupuesto) {
            return response()->json(['message' => 'Presupuesto no encontrado.'], 404);
        }
        return response()->json($presupuesto);
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
        $presupuesto = Presupuesto::find($id);
        if (!$presupuesto) {
            return response()->json(['message' => 'Presupuesto no encontrado.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'presupuesto' => 'sometimes|required|numeric',
            'cantidad_personas' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $presupuesto->update($validator->validated());

        return response()->json($presupuesto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $presupuesto = Presupuesto::find($id);
        if (!$presupuesto) {
            return response()->json(['message' => 'Presupuesto no encontrado.'], 404);
        }

        $presupuesto->delete();
        return response()->json(['message' => 'Presupuesto eliminado correctamente.']);
    }
}
