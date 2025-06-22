<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;
    protected $fillable = [
        'presupuesto',
        'cantidad_personas'
    ];
    protected $casts = [
        'presupuesto' => 'decimal:2',
        'cantidad_personas' => 'integer',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public static function createPresupuesto(array $data)
    {
        return self::create($data);
    }

    public static function getAllPresupuestos()
    {
        return self::all();
    }

    public static function getPresupuestoById($id)
    {
        return self::find($id);
    }

    public static function updatePresupuesto($id, array $data)
    {
        $presupuesto = self::find($id);
        if ($presupuesto) {
            $presupuesto->update($data);
        }
        return $presupuesto;
    }

    public static function deletePresupuesto($id)
    {
        $presupuesto = self::find($id);
        if ($presupuesto) {
            $presupuesto->delete();
            return true;
        }
        return false;
    }


}
