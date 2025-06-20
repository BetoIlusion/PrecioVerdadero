<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TipoProducto; // Import the TipoProducto model
class SubTipoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definición: tipo y sus subtipos
        // 1 -> alimentos
        // 2 -> ferreteria
        $tiposConSubtipos = [
            1 => ['enlatado', 'fruta', 'grano', 'legumbre', 'carne','galleta'],
            2 => ['pala', 'escoba', 'pintura', 'malla', 'ladrillo'],
        ];

        foreach ($tiposConSubtipos as $tipo => $subTipos) {
            foreach ($subTipos as $sub) {
               DB::table('sub_tipo_productos')->insert([
                    'sub_tipo' => $sub,
                    'id_tipo' => $tipo,
                ]);
            }
        }
    }
}
