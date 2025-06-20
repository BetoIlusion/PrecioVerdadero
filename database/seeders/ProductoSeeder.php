<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'nombre' => 'Arroz',
                'marca' => '',
                'disponibilidad' => true,
                'id_unidad' => 1,
                'id_sub_tipo' => 1

            ],
            [
                'nombre' => 'Lentejas',
                'marca' => '',
                'disponibilidad' => true,
                'id_unidad' => 1,
                'id_sub_tipo' => 2
            ],
            [
                'nombre' => 'Frijoles',
                'marca' => '',
                'disponibilidad' => true,
                'id_unidad' => 2,
                'id_sub_tipo' => 3
            ],
            [
                'nombre' => 'Choclo',
                'marca' => '',
                'disponibilidad' => true,
                'id_unidad' => 1,
                'id_sub_tipo' => 1
            ],

        ]);
    }
}
