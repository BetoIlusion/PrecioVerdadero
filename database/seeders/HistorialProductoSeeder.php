<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistorialProducto;
use Database\Factories\HistorialProductoFactory;

class HistorialProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Asegura reinicio de fecha para consistencia
        HistorialProductoFactory::$fechaInicio = now();

        // Genera 20 registros apuntando a id_usuario_producto = 1
        HistorialProducto::factory()->count(20)->create([
            'id_usuario_producto' => 1,
        ]);
    }
}
