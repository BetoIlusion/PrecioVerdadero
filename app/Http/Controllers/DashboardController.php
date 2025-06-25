<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\EstadoProducto;
use App\Models\UsuarioProducto;

use Illuminate\Support\Facades\Log;
use App\Models\Usuario;
use App\Models\Tienda;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class DashboardController extends Controller
{
  public function index()
    {
        $user = auth()->user();
        $productos = $user->usuarioProductos()->with(['producto', 'historiales'])->get();

        // Depurar y calcular promedios, filtrar solo los con producto válido
        foreach ($productos as $usuarioProducto) {
            $producto = $usuarioProducto->producto;
            $historiales = $usuarioProducto->historiales;
            $promedio = $historiales->isNotEmpty() ? $historiales->avg('precio') : 0;

            if (!$producto) {
                Log::warning("UsuarioProducto ID: {$usuarioProducto->id} no tiene producto asociado (id_producto: {$usuarioProducto->id_producto})");
            } else {
                Log::info("UsuarioProducto ID: {$usuarioProducto->id}, Producto: {$producto->nombre}, Historiales count: {$historiales->count()}, Promedio: {$promedio}");
            }

            // Asignar el promedio como atributo dinámico
            $usuarioProducto->promedio = $promedio;
        }

        // Opcional: Filtrar solo los con producto válido (descomenta si lo necesitas)
        // $productos = $productos->filter(function ($usuarioProducto) {
        //     return $usuarioProducto->producto !== null;
        // });

        return view('dashboard', compact('productos'));
    }

    public function create()
    {
        return view('superadmin.producto.create');
    }
}
