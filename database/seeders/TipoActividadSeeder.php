<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoActividad;

class TipoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Me Gusta',
            "No Me Gusta",
            "Interesado",
            "No Me Interesa",
        ];

        foreach ($tipos as $tipo) {
            TipoActividad::create(['tipo' => $tipo]);
        }
        
        
    }
}
