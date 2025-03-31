<?php

use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;

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
    
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('proveedor')) {
            return redirect()->route('proveedor.dashboard');
        } elseif ($user->hasRole('cliente')) {
            return redirect()->route('cliente.dashboard');
        }
    
        return abort(403, 'Acceso no autorizado'); // En caso de no tener un rol válido
    })->middleware(['auth:sanctum', 'verified'])->name('dashboard');
    
    
    //las Rutas Dashboard no se tocan !!!!
    // Grupo para el rol "admin"
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard'); // Vista de ejemplo para admin
        })->name('admin.dashboard');
        // Aquí puedes añadir más rutas exclusivas para admin
    });

    // Grupo para el rol "proveedor"
    Route::middleware('role:proveedor')->group(function () {
        Route::get('/prov', function () {
            return view('proveedor.vista');
        })->name('proveedor.dashboard');
        // Route::get('/proveedor', [ProveedorController::class, 'index'])->name('proveedor.index');
        // Route::get('/user/{id}', function ($id) {
        //     $user = \App\Models\User::findOrFail($id);
        //     return view('proveedor.user-detail', ['user' => $user]);
        // })->name('user.detail');

        // Route::get('/vista-proveedor', function () {
        //     return view('proveedor.vista');
        // })->name('proveedor.vista');
    });

    // // Grupo para el rol "cliente"
    // Route::middleware('role:cliente')->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('cliente.vista');
    //     })->name('cliente.dashboard');
        
    // });
});