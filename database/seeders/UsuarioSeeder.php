<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tienda;
use App\Models\Ubicacion;
use App\Models\UsuarioProducto;

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
            [
                'name' => 'tienda D',
                'email' => 'tienda_d@gmail.com',
                'password' => bcrypt('123456789'),
            ]
        ];

        // Coordenadas base para todos (p. ej., una ciudad central)
        // Coordenadas de la Plaza 24 de Septiembre, Santa Cruz de la Sierra, Bolivia
        $baseLat = -17.783274;
        $baseLng = -63.182132;

        foreach ($mercaderes as $mercader) {
            $user = User::create($mercader);
            $user->assignRole('mercader');

            $tienda = Tienda::create([
                'nombre' => $user->name,
                'tipo' => 'mercader',
                'id_usuario' => $user->id,
            ]);

            // Generar ubicación aleatoria cercana (~3 km máximo)
            $randomOffsetLat = (mt_rand(-15000, 15000) / 1000000); // ±0.015
            $randomOffsetLng = (mt_rand(-15000, 15000) / 1000000); // ±0.015

            $lat = $baseLat + $randomOffsetLat;
            $lng = $baseLng + $randomOffsetLng;

            Ubicacion::create([
                'latitud' => $lat,
                'longitud' => $lng,
                'direccion' => 'Ubicación aproximada de ' . $user->name,
                'id_tienda' => $tienda->id,
            ]);

            UsuarioProducto::create([
                'id_usuario' => $user->id,
                'id_producto' => 1, // Asignar un producto por defecto
                'id_estado' => 1, // Asignar estado activo
                'precio' => rand(10, 100), // Precio aleatorio entre 10 y 100
                'existe' => true, // Marcar como existente
            ]);
        }

    $clientes = [
        [
            'name' => 'cliente 1',
            'email' => 'cliente1@gmail.com',
            'password' => bcrypt('123456789'),
        ],
        [
            'name' => 'cliente 2',
            'email' => 'cliente2@gmail.com',
            'password' => bcrypt('123456789'),
        ]
    ];

    foreach ($clientes as $cliente) {
        $user = User::create($cliente);
        $user->assignRole('cliente');
        // Puedes agregar lógica adicional si deseas que los clientes tengan ubicación o algo más
    }
    }

    
}
