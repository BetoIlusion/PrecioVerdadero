<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('estado_productos')->insert([
        //     ['estado_producto' => 'Disponible', 'updated_date' => now(), 'estado' => true],
        //     ['estado_producto' => 'Agotado', 'updated_date' => now(), 'estado' => false],
        //     ['estado_producto' => 'En tránsito', 'updated_date' => now(), 'estado' => true],
        // ]);
    }
}
