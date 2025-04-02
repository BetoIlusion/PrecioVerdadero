<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder 1: Bebidas
        DB::table('tipo_productos')->insert([
            'tipo' => 'alimento',
        ]);

        // Seeder 2: Lácteos
        DB::table('tipo_productos')->insert([
            'tipo' => 'herramienta',
        ]);

        // Seeder 3: Carnes
        DB::table('tipo_productos')->insert([
            'tipo' => 'ropa',
        ]);
    }
}
