<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Actions\Fortify\CreateNewUser;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Instanciar la clase CreateNewUser
        $createNewUser = new CreateNewUser();

        // Datos del Super Admin
        $input = [
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => '123456789', // Contraseña
            'password_confirmation' => '123456789', // Confirmación de contraseña
            'tipo' => 'Super Admin', // Rol que se asignará
            'terms' => true, // Si usas términos y condiciones en Jetstream
        ];

        // Llamar al método create
        $createNewUser->create($input);

        // Opcional: Confirmar que el rol existe previamente
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin']);
    }
}
