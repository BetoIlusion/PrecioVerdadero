<?php

use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        switch (true) {
            case $user->hasRole('proveedor'):
                return redirect()->route('proveedor.dashboard');
            case $user->hasRole('cliente'):
                return redirect()->route('cliente.dashboard');
            case $user->hasRole('admin'):
                return redirect()->route('admin.dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');

    // Ruta existente para proveedor
    Route::get('/proveedor', [ProveedorController::class, 'index'])->name('proveedor.index');

    // Ruta existente para detalle de usuario
    Route::get('/user/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        return view('proveedor.user-detail', ['user' => $user]);
    })->name('user.detail');

    // // Nueva ruta para vista de proveedor (restringida por rol)
    // Route::get('/vista-proveedor', function () {
    //     return view('proveedor.vista');
    // })->middleware('role:proveedor')->name('proveedor.vista');

    // // Nueva ruta para vista de cliente (restringida por rol)
    // Route::get('/vista-cliente', function () {
    //     return view('cliente.vista');
    // })->middleware('role:cliente')->name('cliente.vista');

    
});
