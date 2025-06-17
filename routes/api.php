<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de la API
Route::prefix('auth')->group(function () {
    // Listar todos los usuarios (protegida)
    Route::get('/users', [AuthController::class, 'index'])->middleware('auth:sanctum');
    
    // Registrar usuario (pública)
    Route::post('/register', [AuthController::class, 'register']);
    
    // Iniciar sesión (pública)
    Route::post('/login', [AuthController::class, 'login']);

    // Actualizar usuario (protegida)
    Route::put('/users/{id}', [AuthController::class, 'update'])->middleware('auth:sanctum');
});
