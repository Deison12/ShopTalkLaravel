<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    /**
     * Mostrar todas las listas de compras con productos
     */
    public function index()
    {
        $lists = ShoppingList::with('products')->get();

        if ($lists->isEmpty()) {
            return response()->json([
                'message' => 'No hay listas disponibles',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Listas obtenidas con éxito',
            'data' => $lists
        ], 200);
    }

    /**
     * Crear una nueva lista de compras
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $list = ShoppingList::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Lista creada con éxito',
            'data' => $list->load('products') // incluye productos si existen
        ], 201);
    }

    /**
     * Mostrar una lista específica con productos
     */
    public function show(string $id)
    {
        $list = ShoppingList::with('products')->find($id);

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
     * Actualizar una lista de compras
     */
    public function update(Request $request, string $id)
    {
        $list = ShoppingList::find($id);

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
     * Eliminar una lista de compras
     */
    public function destroy(string $id)
    {
        $list = ShoppingList::find($id);

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
