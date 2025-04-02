<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'marca',
        'disponibilidad',
        'estado',
        'id_unidad',
        'id_sub_tipo',
    ];
    // Atributos que no se devolverán en las respuestas de la API (ocultos)
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function mostrar()
    {
        return Producto::self();
    }
    public function mostrarX($unidad)
    {
        return Producto::where('id', $unidad)->first();
    }
    //hay que corregir
    // public function existeProducto($id, $nombre)
    // {
    //     $producto = self::where('id', $id)->where('nombre', $nombre)->first();
    //     return $producto !== null;
    // }
    public function eliminar($id)
    {
        return $this->cambiarEstado($id, false);
    }
    public function cambiarEstado($id, $estado)
    {
        $producto = self::find($id);
        if ($producto) {
            $producto->estado = $estado;
            $producto->save();
            return true;
        }
        return false;
    }
}
