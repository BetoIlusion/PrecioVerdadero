<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Actividad;
use App\Models\User;

class ActividadCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $actividad;

    public function __construct(Actividad $actividad)
    {
        $this->actividad = $actividad;
    }

    public function broadcastOn()
    {
        $channels = [new Channel('mercader.' . $this->actividad->id_usuario_mercader)];
        $superAdmins = User::role('Super Admin')->get();
        foreach ($superAdmins as $superAdmin) {
            $channels[] = new Channel('mercader.' . $superAdmin->id);
        }
        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->actividad->id,
            'id_usuario_cliente' => $this->actividad->id_usuario_cliente,
            'id_tipo_actividad' => $this->actividad->id_tipo_actividad,
            'message' => "Nueva actividad registrada por el cliente {$this->actividad->id_usuario_cliente}."
        ];
    }
}