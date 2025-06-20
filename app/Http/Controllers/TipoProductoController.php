<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoProducto;

class TipoProductoController extends Controller
{
    public function index()
    {
        $tiposProductos = TipoProducto::all();
        
        return view('entidades.tipo-productos.index', compact('tiposProductos'));
    }
    public function create()
    {
        // Retorna la vista para crear un nuevo tipo de producto
        return view('entidades.tipo-productos.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);
        TipoProducto::create($request->all());
        return redirect()->route('tipos-productos.index')->with('success', 'Tipo de producto creado exitosamente.');
    }
    public function edit($id)
    {
        // Encuentra el tipo de producto por ID
        $tipoProducto = TipoProducto::findOrFail($id);
        return view('entidades.tipo-productos.edit', compact('tipoProducto'));
    }
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);        
    }                                 
}
