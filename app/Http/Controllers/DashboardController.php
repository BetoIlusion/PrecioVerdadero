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
  // En app/Http/Controllers/DashboardController.php

public function index()
{
    $user = auth()->user();

    // 1. Ahora añadimos with('producto') para cargar la relación
    $productos = $user->usuarioProductos()->with('producto')->get();

    // 2. Volvemos a depurar

    return view('dashboard', compact('productos'));
}
}   
