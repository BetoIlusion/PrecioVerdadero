<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'edberto',
            'email' => 'edberto@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        $this->call([
            RoleSeeder::class, // Llama al seeder de Role
            SuperAdminSeeder::class, // Llama al seeder de SuperAdmin
            TipoProductoSeeder::class, // Llama al seeder de TipoProducto
            SubTipoProductoSeeder::class, // Llama al seeder de SubTipoProducto
            //EstadoProductoSeeder::class, // Llama al seeder de EstadoProducto
            UnidadProductoSeedor::class, // Llama al seeder de UnidadProducto
            
        ]);
    }
}
