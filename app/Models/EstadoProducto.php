<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'estado_producto',
        'updated_date',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_estado');
    }
}
