<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioProducto;
use App\Models\Estado;
use App\Models\Sugerencia;

class UsuarioProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $opciones = UsuarioProducto::where('id', $user->id)
            ->where('id_estado', 4)
            ->with([
                'estado:id,nombre',
                'producto',
                'sugerencia:id,id_usuario_estado,usuario_producto_id'
            ])
            ->get();
        
        
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
