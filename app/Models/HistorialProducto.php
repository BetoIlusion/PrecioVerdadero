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
        'id_usuario_producto',
        'id_estado_producto'
    ];
    protected $casts = [
        'fecha' => 'date',
        'fecha_hora' => 'datetime',
    ];
    public function usuarioProducto()
    {
        return $this->belongsTo(UsuarioProducto::class, 'id_usuario_producto');
    }
    
}
