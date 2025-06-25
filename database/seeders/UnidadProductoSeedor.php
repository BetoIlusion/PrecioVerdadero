<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadProductoSeedor extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unidad_productos')->insert([
            ['unidad' => 'Kg 1', 'estado' => 1],
            ['unidad' => 'Lt 2', 'estado' => 1],
            ['unidad' => 'M 3', 'estado' => 1]
        ]);
    }
}
