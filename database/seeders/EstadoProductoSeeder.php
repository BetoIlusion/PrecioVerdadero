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
        DB::table('estado_productos')->insert([
            ['estado_producto' => 'actualizado', 'updated_date' => now()],
            ['estado_producto' => 'desactualizado', 'updated_date' => now()],
            ['estado_producto' => 'inhabilitado', 'updated_date' => now()],
            ['estado_producto' => 'antiguo', 'updated_date' => now()],

        ]);
    }
}
