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
        // Seeder 1: alimentos
        DB::table('tipo_productos')->insert([
            'tipo' => 'alimentos',
        ]);

        // Seeder 2: ferreteria
        DB::table('tipo_productos')->insert([
            'tipo' => 'ferreteria',
        ]);

        // Seeder 3: casa
        DB::table('tipo_productos')->insert([
            'tipo' => 'casa',
        ]);
    }
}
