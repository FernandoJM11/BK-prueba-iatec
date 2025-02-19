<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatoSeeder extends Seeder
{
    public function run()
    {
        DB::table('platos')->insert([
            [
                'nombre' => ' Picante de Pollo',
                'descripcion' => 'Pollo con aji picante',
                'precio' => 18,
                'disponible' => true,
                'categoria_id' => 2
            ],
            [
                'nombre' => 'Charque',
                'descripcion' => 'Carne deshidratada con huevo quesillo y papa',
                'precio' => 30,
                'disponible' => true,
                'categoria_id' => 2
            ],
            [
                'nombre' => 'Pique',
                'descripcion' => 'Trozos de carne de vaca con papa y chorizo',
                'precio' => 25,
                'disponible' => true,
                'categoria_id' => 2
            ],
            [
                'nombre' => 'Pailita',
                'descripcion' => 'Arroz con papa frita, plátano frito, huevo, chorizo, carne',
                'precio' => 20,
                'disponible' => true,
                'categoria_id' => 2
            ]
        ]);
    }
}
