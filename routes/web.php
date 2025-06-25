<?php

use App\Http\Controllers\API\UsuarioProductoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraficasController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UsuarioProductoController as WebUsuarioProductoController;

Route::get('/', function () {
    return view('welcome2');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return redirect()->route('super.dashboard');
        } elseif ($user->hasRole('mercader')) {
            return view('dashboard-mercader');
            return redirect()->route('mercader.dashboard');
        } elseif ($user->hasRole('cliente')) {
            return redirect()->route('cliente.dashboard');
        }

        return abort(403, 'Acceso no autorizado'); // En caso de no tener un rol válido
    })->middleware(['auth:sanctum', 'verified'])->name('dashboard');

    //VISTA GRAFICAS
    Route::get('/graficas', [GraficasController::class, 'index'])->name('graficas.index');
    Route::get('/graficas/precios/{producto_id}', [App\Http\Controllers\GraficasController::class, 'precios'])->name('graficas.precios');
    
    //VISTA INVENTARIO
    Route::get('/inventario', [GraficasController::class, 'index'])->name('graficas.index');



    //vista dashboard DASBOARD
    Route::get('/super/dashboard', [SuperAdminController::class, 'index'])->name('super.dashboard');


    // ====================
    // PRODUCTO - USUARIO PRODUCTO
    // ====================
    Route::resource('/usuario-producto', WebUsuarioProductoController::class);

    Route::post('/usuario-producto/actualizar', [ProductoController::class, 'actualizarEstado'])->name('usuario-producto.actualizar');
});
