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
            ['estado_producto' => 'actualizado'],
            ['estado_producto' => 'desactualizado'],
            ['estado_producto' => 'inhabilitado'],
            ['estado_producto' => 'antiguo'],
            ['estado_producto' => 'sin cambios'],
            



        ]);
    }
}
