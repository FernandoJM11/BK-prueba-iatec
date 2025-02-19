<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['fecha', 'total', 'metodo_pago'];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
