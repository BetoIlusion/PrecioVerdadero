<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;
    protected $table = 'actividads';
    protected $fillable = [
        'id_usuario_mercader',
        'id_usuario_cliente',
        'id_tipo_actividad',
    ];
    public function tipoActividad()
    {
        return $this->belongsTo(TipoActividad::class, 'id_tipo_actividad');
    }

}
