<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaSeeder extends Seeder
{
    public function run()
    {
        DB::table('ventas')->insert([
            [
                'fecha' => Carbon::now(),
                'total' => 61,
                'metodo_pago' => 'Efectivo'
            ],
            [
                'fecha' => Carbon::now()->subDay(),
                'total' => 70,
                'metodo_pago' => 'Tarjeta'
            ]
        ]);
    }
}
