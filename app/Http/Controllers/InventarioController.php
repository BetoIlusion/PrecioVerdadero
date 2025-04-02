<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class InventarioController extends Controller
{
    public function index()
    {
        return view('inventario.index');
    }
    public function create()
    {
        
        return view('proveedor.inventario.create');
    }
}
