<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialProducto extends Model
{
    use HasFactory;
    protected $table = 'historial_productos';
    protected $fillable = [
        'precio',
        'fecha',
        'fecha_hora',
    ];
    
}
