<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnidadProducto;
use App\Models\TipoProducto;
use App\Models\SubTipoProducto;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    public function create()
    {
        $UnidadProducto = UnidadProducto::all();
        //\Log::info('UnidadProducto::all() lista', ['UnidadProducto' => UnidadProducto::all()]);
        $TipoProducto = TipoProducto::all();
        //dd($TipoProducto);
        return view('superadmin.producto.create', compact('UnidadProducto', 'TipoProducto'));
    }
    public function getSubTipos($id_tipo)
{
    
    $subtipos = SubTipoProducto::where('id_tipo', $id_tipo)->get();
    \Log::info('Subtipos encontrados: ', $subtipos->toArray()); // Depuración
    return response()->json($subtipos);
}
}
