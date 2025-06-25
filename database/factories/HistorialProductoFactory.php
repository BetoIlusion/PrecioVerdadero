<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EstadoProducto;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorialProducto>
 */
class HistorialProductoFactory extends Factory
{
     public static $fechaInicio;

    public function definition()
    {
        // Si es la primera vez, inicializa la fecha base
        if (!static::$fechaInicio) {
            static::$fechaInicio = Carbon::create(2024, 1, 1);
        }

        $fecha = static::$fechaInicio->copy(); // Copia actual de la fecha
        static::$fechaInicio->addDay(); // Avanza un día para el próximo registro

        return [
            'precio' => $this->faker->randomFloat(2, 10, 50),
            'fecha' => $fecha->toDateString(),
            'fecha_hora' => $fecha->setTime(rand(8, 18), rand(0, 59)), // Hora aleatoria en horario laboral
            'id_usuario_producto' => 1,
            'id_estado_producto' => rand(1,5),
        ];
    }
}
