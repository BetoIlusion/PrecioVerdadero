<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 DB::table('usuario_productos')->insert([
            [
                'precio' => 38.00,
                'existe' => true,
                'id_usuario' => 1,
                'id_producto' => 1,
                'id_estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'precio' => 10.00,
                'existe' => true,
                'id_usuario' => 2,
                'id_producto' => 2,
                'id_estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'precio' => 84.00,
                'existe' => true,
                'id_usuario' => 1,
                'id_producto' => 1,
                'id_estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'precio' => 34.00,
                'existe' => true,
                'id_usuario' => 5,
                'id_producto' => 1,
                'id_estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
