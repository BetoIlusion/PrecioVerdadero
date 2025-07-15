<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class MLController extends Controller
{
    public function formulario()
    {
        // Trae los productos desde la base de datos
        $productos = DB::table('productos')->select('id', 'nombre')->get();
        return view('prediccion', compact('productos'));
    }

    public function consultar(Request $request)
    {
        $idProducto = $request->input('id_producto');
        $fecha = $request->input('fecha');

        // Consulta API ML
        $url = env('ML_API_URL', 'http://127.0.0.1:8001') . '/predecir_precio';

        $respuesta = Http::get($url, [
            'id_producto' => $idProducto,
            'fecha_objetivo' => $fecha
        ]);

        $productos = DB::table('productos')->select('id', 'nombre')->get();

        if ($respuesta->successful()) {
            $resultado = $respuesta->json();
            return view('prediccion', compact('productos', 'resultado'));
        } else {
            $error = 'Error al consultar la predicción.';
            return view('prediccion', compact('productos', 'error'));
        }
    }
}
