<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HistorialProducto;
use App\Models\User;
use App\Models\Tienda;  

class UsuarioProducto extends Model
{
    use HasFactory;
    protected $table = 'usuario_productos';
    protected $fillable = [
        'precio',
        'existe',
        'id_usuario',
        'id_producto',
        'id_estado',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function existe(){
        return (bool) $this->existe;
    }
    public function HistorialProductos()
    {
        return $this->hasMany(HistorialProducto::class, 'id_usuario_producto');
    }
    // RELACIÓN MANUAL: conseguir tienda a partir del usuario
    public function tienda()
    {
        return $this->hasOne(Tienda::class, 'id_usuario', 'id_usuario');
    }
 public function producto()
{
    return $this->belongsTo(Producto::class, 'id_producto');
}

// En app/Models/UsuarioProducto.php

public function historiales()
{
    // CORRECTO Y EXPLÍCITO:
    return $this->hasMany(HistorialProducto::class, 'id_usuario_producto', 'id');
}
}