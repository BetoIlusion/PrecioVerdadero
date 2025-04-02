<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTipoProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_tipo',
        'estado',
        'id_tipo'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
