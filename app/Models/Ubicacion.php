<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'latitud',
        'longitud',
        'direccion',
        'id_tienda',
    ];
    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'id_tienda');
    }
}
