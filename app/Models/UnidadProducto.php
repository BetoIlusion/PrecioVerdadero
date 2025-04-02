<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'unidad',
        'estado',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function mostrar()
    {
        return UnidadProducto::all();
    }
    public function mostrarX($unidad)
    {
        return UnidadProducto::where('unidad', $unidad)->first();
    }

    public function eliminar($id)
    {
        return $this->cambiarEstado($id, false);
    }
    public function cambiarEstado($id, $estado)
    {
        $unidadProducto = UnidadProducto::find($id);
        if ($unidadProducto) {
            $unidadProducto->estado = $estado;
            $unidadProducto->save();
            return true;
        }
        return false;
    }
}
