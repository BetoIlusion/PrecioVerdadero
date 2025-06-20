<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioProducto extends Model
{
    use HasFactory;
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
}
