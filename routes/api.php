<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\API\TipoProductoController as APITipoProductoController;
use App\Http\Controllers\API\SubTipoController as APISubTipoProductoController;
use App\Http\Controllers\API\ProductoController as APIProductoController;
use App\Models\TipoProducto;
use App\Http\Controllers\API\UsuarioProductoController as APIUsuarioProductoController;
use App\Http\Controllers\API\HistorialProductoController as APIHistorialProductoController;
use App\Http\Controllers\API\PresupuestoController as APIPresupuestoController;
use App\Http\Controllers\API\TiendaController as APITiendaController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    // ===========================
    // TIPO PRODUCTO
    // ===========================
    //CRUD
    Route::resource('/tipo-producto', APITipoProductoController::class);
    // lista de sub tipos por tipo
    Route::get('/tipo-producto/{id}/sub-tipos', [APITipoProductoController::class, 'mostrarSubTipos'])->name('tipo-producto.sub-tipos');

    // ============================
    // SUB TIPO PRODUCTO
    // ============================
    //CRUD
    Route::resource('/sub-tipo-producto', APISubTipoProductoController::class);
    Route::get('/sub-tipo-producto/{id}/productos', [APISubTipoProductoController::class, 'mostrarProductos'])->name('sub-tipo-producto.productos');

    // ============================
    // PRODUCTO
    // ============================
    Route::resource('/producto', APIProductoController::class);

    // =============================
    // USUARIO PRODUCTO
    // =============================
    Route::resource('/usuario-producto', APIUsuarioProductoController::class);
    Route::get('/usuario-producto/usuario', [APIUsuarioProductoController::class, 'allXusuario'])->name('usuario-producto.index');

    //cambio de precio directamente
    Route::put('/usuario-producto/{id}/precio', [APIUsuarioProductoController::class, 'updatePrecio'])->name('usuario-producto.update-precio');
    //cambia el estado de existe para mostrarse en la lista de productos del usuario
    Route::put('/usuario-producto/{id}/existe', [APIUsuarioProductoController::class, 'updateExiste'])->name('usuario-producto.update-existe');

    // =============================
    // HISTORIAL DE PRODUCTOS
    // =============================
    Route::resource('/usuario-producto/historial', APIUsuarioProductoController::class);

    // ==============================
    // PRESUPUESTOS
    // ============================== 
    Route::resource('/presupuesto', APIPresupuestoController::class);

    // ==============================
    // TIENDAS - UBICACION
    // ==============================
    Route::get('/tienda', [APITiendaController::class, 'getTienda'])->name('tienda.index');
    Route::post('/tienda', [APITiendaController::class, 'createTienda'])->name('tienda.store');
    Route::get('/tienda/ubicacion', [APITiendaController::class, 'getUbicacion'])->name('tienda.ubicacion');
    Route::post('/tienda/ubicacion', [APITiendaController::class, 'createUbicacion'])->name('tienda.ubicacion.store');
    Route::put('/tienda/ubicacion/{id}', [APITiendaController::class, 'updateUbicacion'])->name('tienda.ubicacion.update');
    Route::put('/tienda/{id}', [APITiendaController::class, 'updateTienda'])->name('tienda.update');
    Route::delete('/tienda/{id}', [APITiendaController::class, 'destroyTienda'])->name('tienda.destroy');
    // ruta directa para obtener los productos X bajo precio X ubicacion mas cercanas
    Route::get('/tienda/productos/bajo-precio', [APIProductoController::class, 'getProductosBajoPrecioTienda'])->name('productos.bajo-precio.tienda');
    




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
