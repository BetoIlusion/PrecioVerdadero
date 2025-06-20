<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTipoProducto extends Model
{
    use HasFactory;
    protected $table = 'sub_tipo_productos';
    protected $fillable = ['sub_tipo', 'id_tipo'];
    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'id_tipo');
    }
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_sub_tipo');
    }

}
