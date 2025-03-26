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
        return view('dashboard');
    })->name('dashboard');
    Route::get('/proveedor', [ProveedorController::class, 'index'])->name('proveedor.index');
    Route::get('/user/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        return view('proveedor.user-detail', ['user' => $user]);
    })->name('user.detail');
});
