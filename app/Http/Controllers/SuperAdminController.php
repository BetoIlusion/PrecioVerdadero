<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnidadProducto;
use App\Models\TipoProducto;
use App\Models\SubTipoProducto;
use App\Models\Producto;
use App\Models\EstadoProducto;
use Illuminate\Support\Facades\Log;
use App\Models\UsuarioProducto;


use App\Models\Usuario; 
use App\Models\Tienda;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class SuperAdminController extends Controller
{   
  public function index(Request $request)
    {
        try {
            $productos = Producto::all();
            $estados = EstadoProducto::all();
            $producto = $request->has('id') ? Producto::find($request->id) : null;
            return view('dashboard', compact('productos', 'estados', 'producto'));
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar los productos.');
        }
        
    }
   
    public function getSubTipos($id_tipo)
{
    
    $subtipos = SubTipoProducto::where('id_tipo', $id_tipo)->get();
    \Log::info('Subtipos encontrados: ', $subtipos->toArray()); // Depuración
    return response()->json($subtipos);
}
}
