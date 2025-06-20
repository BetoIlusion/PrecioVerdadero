<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Crear permisos
       $permissions = [
        'manage users',
        'edit content',
        'view dashboard',
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    // Crear roles y asignar permisos
    $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
    $cliente = Role::firstOrCreate(['name' => 'cliente']);
    $mercader = Role::firstOrCreate(['name' => 'mercader']);

    // Asignar todos los permisos al Super Admin
    $superAdmin->syncPermissions($permissions);

    // Asignar permisos específicos a Admin
    $cliente->syncPermissions(['edit content', 'view dashboard']);

    // Asignar permisos básicos a User
    $mercader->syncPermissions(['view dashboard']);

    // Asignar rol Super Admin al primer usuario (opcional)
    $firstUser = \App\Models\User::first();
    if ($firstUser) {
        $firstUser->assignRole('Super Admin');
    }
    }
}
