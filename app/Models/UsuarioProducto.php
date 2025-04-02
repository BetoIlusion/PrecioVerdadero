<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_usuario',
        'id_producto',
        'id_estado',
        'precio',
        'existe'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
