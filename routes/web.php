<?php

use App\Http\Controllers\API\UsuarioProductoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraficasController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TipoProductoController;
USE App\Http\Controllers\TiendaController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\NotificationController;
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
            return app(DashboardController::class)->index();
        } elseif ($user->hasRole('cliente')) {
            return view('dashboard-cliente');
        }

        return abort(403, 'Acceso no autorizado'); // En caso de no tener un rol válido
    })->middleware(['auth:sanctum', 'verified'])->name('dashboard');

    //VISTA GRAFICAS
    Route::get('/graficas', [GraficasController::class, 'index'])->name('graficas.index');
    Route::get('/graficas/precios/{producto_id}', [App\Http\Controllers\GraficasController::class, 'precios'])->name('graficas.precios');

    //VISTA INVENTARIO
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');

    //las Rutas Dashboard no se tocan !!!!
    //========================================================
    //         SUPER ADMIN
    //========================================================
    Route::prefix('admin')->middleware('role:Super Admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.index');
        //INVENTARIO
         Route::get('/inventario', [InventarioController::class, 'index'])->name('admin.inventario');
        // //TIPO PRODUCTO
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


        
Route::post('/producto/{id}/mantener', [ProductoController::class, 'mantener'])->name('producto.mantener');
Route::post('/producto/{id}/promediar', [ProductoController::class, 'promediar'])->name('producto.promediar');

       
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
        //TIENDA
         //TIENDA
 Route::get('/tiendas', [TiendaController::class, 'show'])->name('tienda.index');
Route::post('/tienda', [TiendaController::class, 'store'])->name('tienda.store');
Route::put('/tienda/{id}', [TiendaController::class, 'update'])->name('tienda.update');
Route::delete('/tienda/{id}', [TiendaController::class, 'destroy'])->name('tienda.destroy');

  
//notificaciones
Route::middleware('auth')->group(function () {
    Route::post('/actividad', [ActividadController::class, 'store'])->name('actividad.store');
    Route::post('/notification/{id}/read', [NotificationController::class, 'markAsRead'])->name('notification.markAsRead');
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');});  


});


    //vista dashboard DASBOARD
    Route::get('/super/dashboard', [SuperAdminController::class, 'index'])->name('super.dashboard');

    // vista CLIENTE
    Route::get('/app',[DashboardController::class,'linkApk'])->name('download.app');


    // ====================
    // PRODUCTO - USUARIO PRODUCTO
    // ====================
    Route::resource('/usuario-producto', WebUsuarioProductoController::class);

    Route::post('/usuario-producto/actualizar', [ProductoController::class, 'actualizarEstado'])->name('usuario-producto.actualizar');
    Route::post('/usuario-producto/{id}/mantener', [ProductoController::class, 'mantener'])->name('usuario-producto.mantener');
    Route::post('/usuario-producto/{id}/promediar', [ProductoController::class, 'promediar'])->name('usuario-producto.promediar');
    Route::get('/usuario-producto/{id}/modificar', [ProductoController::class, 'modificar'])->name('producto.modificar');
});
