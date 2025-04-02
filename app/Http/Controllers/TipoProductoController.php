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
    return "tipo producto create";
    return view('entidades.tipo-productos.create');
}
}
