<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleVentaSeeder extends Seeder
{
    public function run()
    {
        DB::table('detalle_ventas')->insert([
            [
                'venta_id' => 1,
                'plato_id' => 1,
                'cantidad' => 2,
                'subtotal' => 36
            ],
            [
                'venta_id' => 1,
                'plato_id' => 3,
                'cantidad' => 1,
                'subtotal' => 25
            ],
            [
                'venta_id' => 2,
                'plato_id' => 2,
                'cantidad' => 1,
                'subtotal' => 30
            ],
            [
                'venta_id' => 2,
                'plato_id' => 4,
                'cantidad' => 2,
                'subtotal' => 40
            ]
        ]);
    }
}
