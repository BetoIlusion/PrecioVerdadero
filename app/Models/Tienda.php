<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'tipo',
        'id_usuario'
    ];
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    public function getUbicacion(){
        $ubicacion = $this->ubicacion;
        if (!$ubicacion) {
            return null; // O manejar el caso donde no hay ubicación
        }
        return [
            'latitud' => $ubicacion->latitud,
            'longitud' => $ubicacion->longitud,
            'direccion' => $ubicacion->direccion,
        ];
    }
}
