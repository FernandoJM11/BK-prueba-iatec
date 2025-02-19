<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriaController extends Controller
{
    /**
     * Muestra todas las categorías activas.
     */
    public function index()
    {
        try {
            $categorias = Categoria::whereNull('deleted_at')->get();
            return response()->json($categorias, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las categorías'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Almacena una nueva categoría.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|unique:categorias,nombre|max:255',
            ]);
    
            $categoria = Categoria::create([
                'nombre' => $request->nombre,
            ]);
    
            return response()->json([
                'message' => 'Categoría creada con éxito',
                'categoria' => $categoria
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la categoría'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Muestra una categoría específica.
     */
    public function show($id)
    {
        try {
            $categoria = Categoria::find($id);
    
            if (!$categoria || $categoria->deleted_at) {
                return response()->json(['message' => 'Categoría no encontrada'], Response::HTTP_NOT_FOUND);
            }
    
            return response()->json($categoria, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener la categoría'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
     /**
     * Actualiza una categoría.
     */
    public function update(Request $request, $id)
    {
        try {
            $categoria = Categoria::find($id);
    
            if (!$categoria || $categoria->deleted_at) {
                return response()->json(['message' => 'Categoría no encontrada'], Response::HTTP_NOT_FOUND);
            }
    
            $request->validate([
                'nombre' => 'required|string|unique:categorias,nombre,' . $id . '|max:255',
            ]);
    
            $categoria->update(['nombre' => $request->nombre]);
    
            return response()->json([
                'message' => 'Categoría actualizada con éxito',
                'categoria' => $categoria
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la categoría'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
     /**
     * Eliminación lógica de una categoría.
     */
    public function destroy($id)
    {
        try {
            $categoria = Categoria::find($id);
    
            if (!$categoria || $categoria->deleted_at) {
                return response()->json(['message' => 'Categoría no encontrada'], Response::HTTP_NOT_FOUND);
            }
    
            $categoria->delete();
    
            return response()->json(['message' => 'Categoría eliminada correctamente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la categoría'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
