<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    /**
     * Mostrar todas las listas de compras del usuario autenticado con sus productos
     */
    public function index()
    {
        $lists = auth()->user()->shoppingLists()->with('products')->get();

        return response()->json([
            'message' => $lists->isEmpty() ? 'No hay listas disponibles' : 'Listas obtenidas con éxito',
            'data' => $lists
        ], 200);
    }

    /**
     * Crear una nueva lista de compras para el usuario autenticado
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $list = auth()->user()->shoppingLists()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Lista creada con éxito',
            'data' => $list->load('products') // incluye productos si existen
        ], 201);
    }

    /**
     * Mostrar una lista específica del usuario autenticado con sus productos
     */
    public function show(string $id)
    {
        $list = auth()->user()->shoppingLists()->with('products')->find($id);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Lista encontrada',
            'data' => $list
        ], 200);
    }

    /**
     * Actualizar una lista de compras del usuario autenticado
     */
    public function update(Request $request, string $id)
    {
        $list = auth()->user()->shoppingLists()->find($id);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada',
                'data' => null
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $list->update($request->only(['name']));

        return response()->json([
            'message' => 'Lista actualizada con éxito',
            'data' => $list->load('products')
        ], 200);
    }

    /**
     * Eliminar una lista de compras del usuario autenticado
     */
    public function destroy(string $id)
    {
        $list = auth()->user()->shoppingLists()->find($id);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada',
                'data' => null
            ], 404);
        }

        $list->delete();

        return response()->json([
            'message' => 'Lista eliminada con éxito',
            'data' => null
        ], 200);
    }
}
