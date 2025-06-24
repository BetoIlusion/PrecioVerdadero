<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Models\HistorialProducto;

class GraficasController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $productos = Producto::all();
        return view('graficas.index', compact('productos'));
    }
    public function precios($producto_id)
    {
        // Get the authenticated user (Mercader)
        $user = auth()->user();

        // Fetch price history from HistorialProducto for the given product and user
        $historial = HistorialProducto::whereHas('usuarioProducto', function ($query) use ($producto_id, $user) {
            $query->where('id_producto', $producto_id)
                ->where('id_usuario', $user->id)
                ->where('existe', true); // Only include active UsuarioProducto entries
        })
            ->orderBy('fecha', 'asc')
            ->get(['precio', 'fecha']);

        // Format data for Chart.js
        $labels = $historial->pluck('fecha')->map(function ($fecha) {
            return $fecha->format('Y-m-d H:i'); // Include time for precision
        })->toArray();

        $precios = $historial->pluck('precio')->toArray();

        return response()->json([
            'labels' => $labels,
            'precios' => $precios,
        ]);
    }
}
