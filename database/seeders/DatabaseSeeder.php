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

        $this->call([
            SuperAdminSeeder::class,
            RoleSeeder::class,
            TipoProductoSeeder::class,
            SubTipoProductoSeeder::class,
            UnidadProductoSeedor::class,
            EstadoProductoSeeder::class,
            ProductoSeeder::class,

        ]);
        // $user = \App\Models\User::factory()->create([
        //     'name' => 'edberto',
        //     'email' => 'edberto@gmail.com',
        //     'password' => bcrypt('123456789'),
        // ]);
        // $user->assignRole('Super Admin');
    }
}
