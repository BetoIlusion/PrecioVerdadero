<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];

    // Atributos que no se devolverán en las respuestas de la API (ocultos)
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
