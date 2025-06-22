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
    public function usuarioProductos()
    {
        return $this->hasMany(UsuarioProducto::class, 'id_producto');
    }
    public static function listaBajoPrecioTienda($mi_latitud, $mi_longitud, $id_producto)
    {
        // Traer los UsuarioProducto (mercaderes) con el producto disponible
        $usuarioProductos = UsuarioProducto::where('id_producto', $id_producto)
            ->where('existe', true)
            ->with(['tienda.ubicacion'])
            ->get();
        if ($usuarioProductos->isEmpty()) {
            return []; // No hay productos disponibles
        }

        // Mapear para agregar precio y distancia
        $result = $usuarioProductos->map(function ($usuarioProducto) use ($mi_latitud, $mi_longitud) {
            $tienda = $usuarioProducto->tienda;
            $ubicacion = $tienda ? $tienda->ubicacion : null;
            $distancia = null;
            if ($ubicacion) {
                // Calcular distancia Haversine
                $theta = $mi_longitud - $ubicacion->longitud;
                $distancia = rad2deg(acos(
                    sin(deg2rad($mi_latitud)) * sin(deg2rad($ubicacion->latitud)) +
                        cos(deg2rad($mi_latitud)) * cos(deg2rad($ubicacion->latitud)) * cos(deg2rad($theta))
                )) * 111.13384; // Aproximación km
            }
            return [
                'tienda_id' => $tienda ? $tienda->id : null,
                'nombre_tienda' => $tienda ? $tienda->nombre : null,
                'precio' => $usuarioProducto->precio,
                'ubicacion' => $ubicacion ? [
                    'latitud' => $ubicacion->latitud,
                    'longitud' => $ubicacion->longitud,
                    'direccion' => $ubicacion->direccion,
                ] : null,
                'distancia' => $distancia,
            ];
        });

        // Ordenar por precio y luego por distancia
        $result = $result->sortBy([['precio', 'asc'], ['distancia', 'asc']])->values();

        return $result;
    }
}
