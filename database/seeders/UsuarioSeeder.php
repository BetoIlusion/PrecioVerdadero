<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mercaderes = [
            [
                'name' => 'tienda A',
                'email' => 'tienda_a@gmail.com',
                'password' => bcrypt('123456789'),
            ],
            [
                'name' => 'tienda B',
                'email' => 'tienda_b@gmail.com',
                'password' => bcrypt('123456789'),
            ],
            [
                'name' => 'tienda C',
                'email' => 'tienda_c@gmail.com',
                'password' => bcrypt('123456789'),
            ],
        ];

        foreach ($mercaderes as $mercader) {
            $user = User::create($mercader);
            $user->assignRole('mercader');
            // Crear la tienda asociada al usuario
            $tienda = \App\Models\Tienda::create([
                'nombre' => $user->name,
                'tipo' => 'mercader',
                'id_usuario' => $user->id,
            ]);
            // Base para ubicaciones cercanas
            $baseLat = 19.432608 + (mt_rand(-10, 10) / 10000);
            $baseLng = -99.133209 + (mt_rand(-10, 10) / 10000);
            // Ubicación principal
            \App\Models\Ubicacion::create([
                'latitud' => $baseLat,
                'longitud' => $baseLng,
                'direccion' => 'Ubicación principal de ' . $user->name,
                'id_tienda' => $tienda->id,
            ]);
            // Ubicaciones secundarias cercanas
            for ($i = 0; $i < 2; $i++) {
                \App\Models\Ubicacion::create([
                    'latitud' => $baseLat + (mt_rand(-5, 5) / 10000),
                    'longitud' => $baseLng + (mt_rand(-5, 5) / 10000),
                    'direccion' => 'Ubicación secundaria ' . ($i + 1) . ' de ' . $user->name,
                    'id_tienda' => $tienda->id,
                ]);
            }
        }
    }
}
