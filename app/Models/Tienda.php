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
        return $this->hasOne(Ubicacion::class, 'id_tienda');
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
    // OPCIONAL: si quieres acceder desde Tienda al User dueño
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
