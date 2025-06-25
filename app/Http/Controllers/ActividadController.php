<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Notification;

use App\Events\ActividadCreated;


class ActividadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario_mercader' => 'required|exists:users,id',
            'id_usuario_cliente' => 'required|exists:users,id',
            'id_tipo_actividad' => 'required|exists:tipo_actividads,id',
        ]);

        $actividad = Actividad::create([
            'id_usuario_mercader' => $request->id_usuario_mercader,
            'id_usuario_cliente' => $request->id_usuario_cliente,
            'id_tipo_actividad' => $request->id_tipo_actividad,
        ]);

        // Store notification for mercader
        Notification::create([
            'user_id' => $request->id_usuario_mercader,
            'message' => "Nueva actividad registrada por el cliente {$request->id_usuario_cliente}.",
        ]);

        // Store notifications for Super Admins
        $superAdmins = \App\Models\User::role('Super Admin')->get();
        foreach ($superAdmins as $superAdmin) {
            Notification::create([
                'user_id' => $superAdmin->id,
                'message' => "Nueva actividad registrada por el cliente {$request->id_usuario_cliente} para el mercader {$request->id_usuario_mercader}.",
            ]);
        }

        event(new ActividadCreated($actividad));

            return view('tienda.index');

        //return response()->json(['message' => 'Actividad creada exitosamente.']);
    }
}
