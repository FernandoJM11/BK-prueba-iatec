<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = ['venta_id', 'plato_id', 'cantidad', 'subtotal'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function plato()
    {
        return $this->belongsTo(Plato::class);
    }
}
