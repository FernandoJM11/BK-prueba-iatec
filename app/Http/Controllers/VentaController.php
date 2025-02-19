<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Venta::with('detalles.plato')->get(), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las ventas'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'total' => 'required|numeric|min:0',
                'metodo_pago' => ['required', Rule::in(['Efectivo', 'Tarjeta', 'Transferencia'])],
                'detalles' => 'required|array',
                'detalles.*.plato_id' => 'required|exists:platos,id',
                'detalles.*.cantidad' => 'required|integer|min:1'
            ]);

            DB::beginTransaction();

            $venta = Venta::create($request->only(['total', 'metodo_pago']));

            foreach ($request->detalles as $detalle) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'plato_id' => $detalle['plato_id'],
                    'cantidad' => $detalle['cantidad'],
                    'subtotal' => $detalle['cantidad'] * 
                        DB::table('platos')->where('id', $detalle['plato_id'])->value('precio')
                ]);
            }

            DB::commit();
            return response()->json($venta->load('detalles.plato'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al procesar la venta'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $venta = Venta::with('detalles.plato')->findOrFail($id);
            return response()->json($venta, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $venta = Venta::findOrFail($id);

            $request->validate([
                'total' => 'required|numeric|min:0',
                'metodo_pago' => ['required', Rule::in(['Efectivo', 'Tarjeta', 'Transferencia'])],
                'detalles' => 'required|array',
                'detalles.*.plato_id' => 'required|exists:platos,id',
                'detalles.*.cantidad' => 'required|integer|min:1'
            ]);

            DB::beginTransaction();

            $venta->update($request->only(['total', 'metodo_pago']));

            $venta->detalles()->delete();

            foreach ($request->detalles as $detalle) {
                $precioPlato = DB::table('platos')->where('id', $detalle['plato_id'])->value('precio');
                
                if (!$precioPlato) {
                    throw new \Exception("Plato con ID {$detalle['plato_id']} no tiene precio definido.");
                }

                DetalleVenta::create([
                    'venta_id' => $venta->id, 
                    'plato_id' => $detalle['plato_id'],
                    'cantidad' => $detalle['cantidad'],
                    'subtotal' => $detalle['cantidad'] * $precioPlato
                ]);
            }

            DB::commit();
            return response()->json($venta->load('detalles.plato'), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar la venta'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        try {
            $venta->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la venta'], 500);
        }
    }


    public function reporteDiario(Request $request)
    {
        try {
            // Validar que la fecha esté presente y tenga el formato correcto
            $request->validate([
                'fecha' => 'required|date_format:Y-m-d',
            ]);
    
            $fecha = $request->input('fecha');
    
            // Obtener las ventas del día especificado
            $ventas = Venta::with('detalles.plato')
                ->whereDate('created_at', $fecha)
                ->get();
    
            // Calcular el total de ventas del día
            $totalVentas = $ventas->sum('total');
    
            // Preparar el reporte
            $reporte = [
                'fecha' => $fecha,
                'total_ventas' => $totalVentas,
                'ventas' => $ventas,
            ];
    
            return response()->json($reporte, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al generar el reporte diario'], 500);
        }
    }
}
