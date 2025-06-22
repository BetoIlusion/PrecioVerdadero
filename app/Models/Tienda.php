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
}
