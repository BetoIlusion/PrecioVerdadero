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
use App\Models\HistorialProducto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\RequiredIf; 
use Illuminate\Validation\Rules\RequiredUnless;
use Illuminate\Validation\Rules\ProhibitedIf;
use Illuminate\Validation\Rules\ProhibitedUnless;


use App\Models\Usuario; 
use App\Models\Tienda;
use App\Models\Ubicacion;
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

  public function promediar($id)
    {
        $usuarioProducto = UsuarioProducto::findOrFail($id);
        $productoId = $usuarioProducto->id_producto;

        // Buscar precios de ese producto (de todos los usuarios) sin limitación de tiempo
        $precios = HistorialProducto::whereHas('usuarioProducto', function ($query) use ($productoId) {
            $query->where('id_producto', $productoId);
        })
        ->pluck('precio');

        if ($precios->count() === 0) {
            return back()->with('error', 'No hay precios para este producto.');
        }

        $promedio = round($precios->avg(), 2);

        // Actualiza el precio del producto del usuario con ese promedio
        $usuarioProducto->precio = $promedio;
        $usuarioProducto->save();

        return back()->with('success', 'Precio actualizado con el promedio de todos los precios (Bs. ' . $promedio . ').');
    }

    public function mantener($id)
    {
        $producto = UsuarioProducto::findOrFail($id);

        // Actualiza el updated_at del producto
        $producto->touch();

        // Actualiza el updated_at en la tabla historial_productos para los registros asociados
        HistorialProducto::where('id_usuario_producto', $id)->update(['updated_at' => now()]);

        return back()->with('success', 'Producto actualizado sin cambios de precio.');
    }


}
