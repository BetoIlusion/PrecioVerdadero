<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use Illuminate\Http\Request;
use App\Models\TipoActividad;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ActividadController extends Controller
{
    public function storeInteres($id){
        $user = auth()->user();
        if (User::find($id) === null) {
            return response()->json([
                'message' => 'Usuario Mercader no encontrado.',
            ], 404);
        }
        Actividad::create([
            'id_usuario_mercader' => $id,
            'id_usuario_cliente' => $user->id,
            'id_tipo_actividad' => 3, // Me interesa
        ]);
    }
}
