<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoActividad extends Model
{
    use HasFactory;
    protected $table = 'tipo_actividads';
    protected $fillable = [
        'tipo',
    ];
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_tipo_actividad');
    }
}
