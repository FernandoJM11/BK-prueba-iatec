<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $platos = Plato::with('categoria')->get();
            return response()->json($platos, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener los platos'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:platos,nombre',
                'descripcion' => 'nullable|string',
                'precio' => 'required|numeric|min:0',
                'disponible' => 'boolean',
                'categoria_id' => 'nullable|exists:categorias,id'
            ]);

            $plato = Plato::create($request->all());

            return response()->json($plato, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el plato'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $plato = Plato::with('categoria')->findOrFail($id);
            return response()->json($plato, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Plato no encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plato $plato)
    {
        try {
            $request->validate([
                'nombre' => ['required', 'string', 'max:255', Rule::unique('platos', 'nombre')->ignore($plato->id)],
                'descripcion' => 'nullable|string',
                'precio' => 'required|numeric|min:0',
                'disponible' => 'boolean',
                'categoria_id' => 'nullable|exists:categorias,id'
            ]);

            $plato->update($request->all());

            return response()->json($plato, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el plato'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plato $plato)
    {
        try {
            $plato->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el plato'], 500);
        }
    }
}
