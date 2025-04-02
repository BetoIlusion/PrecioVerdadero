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
        // Define sub-types and their corresponding type_product
        $subTipos = [
            'verdura' => 'alimento',
            'fruta' => 'alimento',
            'cereal' => 'alimento',
            'aceite' => 'alimento',
            'legumbre' => 'alimento',
            'carne' => 'alimento',
        ];
        $subTipos = [
            'pala' => 'herramienta',
            'rastrillo' => 'herramienta',
            'azada' => 'herramienta',
            'tijeras' => 'herramienta',
            'regadera' => 'herramienta',
        ];
        
        foreach ($subTipos as $subTipo => $tipo) {
            // Find the corresponding type_product
            $tipoProducto = TipoProducto::where('tipo', $tipo)->first();

            // If the type_product doesn't exist, create it
            if (!$tipoProducto) {
                $tipoProducto = TipoProducto::create(['tipo' => $tipo]);
            }

            // Insert the sub-type
            DB::table('sub_tipo_productos')->insert([
                'sub_tipo' => $subTipo,
                'estado' => true, // You can change this to false or randomize it
                'id_tipo' => $tipoProducto->id,
            ]);
        }
    }
}
