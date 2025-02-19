<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;

// Rutas de la API
Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index']);
    Route::post('/', [CategoriaController::class, 'store']);
    Route::get('{id}', [CategoriaController::class, 'show']);
    Route::put('{id}', [CategoriaController::class, 'update']);
    Route::delete('{id}', [CategoriaController::class, 'destroy']);
});
Route::prefix('platos')->group(function () {
    Route::get('/', [PlatoController::class, 'index']);
    Route::post('/', [PlatoController::class, 'store']);
    Route::get('{id}', [PlatoController::class, 'show']);
    Route::put('{id}', [PlatoController::class, 'update']);
    Route::delete('{id}', [PlatoController::class, 'destroy']);
});
Route::prefix('ventas')->group(function () {
    Route::get('/', [VentaController::class, 'index']);
    Route::post('/', [VentaController::class, 'store']);
    Route::get('{id}', [VentaController::class, 'show']);
    Route::put('{id}', [VentaController::class, 'update']);
    Route::delete('{id}', [VentaController::class, 'destroy']);
    Route::post('reporte-diario', [VentaController::class, 'reporteDiario']);
});