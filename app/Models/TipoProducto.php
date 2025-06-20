<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo',

    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function subTipos()
    {
        return $this->hasMany(SubTipoProducto::class, 'id_tipo');
    }
}
