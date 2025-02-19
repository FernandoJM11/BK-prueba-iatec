<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Entradas'],
            ['nombre' => 'Platos Fuertes'],
            ['nombre' => 'Postres'],
            ['nombre' => 'Bebidas']
        ]);
    }
}
