<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TipoProductoController;

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
            \Log::info('El usuario ha entrado al sistema');
            return redirect()->route('super.dashboard');
            return "super admin ingreso a su dashboard";
        } elseif ($user->hasRole('proveedor')) {
            return redirect()->route('proveedor.dashboard');
        } elseif ($user->hasRole('cliente')) {
            \Log::info('cliente dashboard');
            return redirect()->route('cliente.dashboard');
        }

        return abort(403, 'Acceso no autorizado'); // En caso de no tener un rol válido
    })->middleware(['auth:sanctum', 'verified'])->name('dashboard');


    //las Rutas Dashboard no se tocan !!!!
    //========================================================
    //         SUPER ADMIN
    //========================================================
    Route::prefix('admin')->middleware('role:Super Admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.index');
        //INVENTARIO
        Route::get('/inventario', [InventarioController::class, 'index'])->name('admin.inventario');
        //TIPO PRODUCTO
        Route::get('/tipo-producto', [TipoProductoController::class, 'index'])->name('tipo-producto.index');
        Route::get('/tipo-producto/create', [TipoProductoController::class, 'create'])->name('tipo-producto.create');
        Route::post('/tipo-producto', [TipoProductoController::class, 'store'])->name('tipo-producto.store');
        Route::get('/tipo-producto/{id}/edit', [TipoProductoController::class, 'edit'])->name('tipo-producto.edit');
        Route::put('/tipo-producto/{id}', [TipoProductoController::class, 'update'])->name('tipo-producto.update');
        Route::delete('/tipo-producto/{id}', [TipoProductoController::class, 'destroy'])->name('tipo-producto.destroy');
        //SUBTIPO PRODUCTO
        
        //PRODUCTO
        Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('super.dashboard');
        Route::get('/productos/create', [SuperAdminController::class, 'create'])->name('super.inventario');
        Route::get('/subtipos/{id_tipo}', [SuperAdminController::class, 'getSubTipos']);
        Route::post('/productos', [SuperAdminController::class, 'store'])->name('productos.store');
    });

    //========================================================
    //         PROVEEDOR
    //========================================================
    Route::prefix('proveedor')->middleware('role:proveedor')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard'); 
        })->name('proveedor.dashboard');
        Route::get('/inventario', [InventarioController::class, 'index'])->name('proveedor.inventario');
        Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
    });
    //========================================================
    //         CLIENTE
    //========================================================
    // // Grupo para el rol "cliente"
    // Route::middleware('role:cliente')->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('cliente.vista');
    //     })->name('cliente.dashboard');

    // });
});
