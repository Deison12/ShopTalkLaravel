<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ShoppingList;

class ProductController extends Controller
{
    /**
     * Listar productos de una lista del usuario autenticado
     */
    public function index($listId)
    {
        $list = auth()->user()->shoppingLists()->find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada o no pertenece al usuario',
                'data' => []
            ], 404);
        }

        $products = $list->products;

        return response()->json([
            'message' => $products->isEmpty() ? 'No hay productos en esta lista' : 'Productos obtenidos con éxito',
            'data' => $products
        ], 200);
    }

    /**
     * Agregar un producto a una lista del usuario autenticado
     */
    public function store(Request $request, $listId)
    {
        $list = auth()->user()->shoppingLists()->find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada o no pertenece al usuario',
                'data' => null
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = $list->products()->create([
            'name' => $request->name,
            'quantity' => $request->quantity ?? 1,
            'purchased' => false,
        ]);

        return response()->json([
            'message' => 'Producto agregado con éxito',
            'data' => $product
        ], 201);
    }

    /**
     * Mostrar un producto específico de una lista del usuario autenticado
     */
    public function show($listId, $id)
    {
        $list = auth()->user()->shoppingLists()->find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada o no pertenece al usuario',
                'data' => null
            ], 404);
        }

        $product = $list->products()->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Producto encontrado',
            'data' => $product
        ], 200);
    }

    /**
     * Actualizar un producto de una lista del usuario autenticado
     */
    public function update(Request $request, $listId, $id)
    {
        $list = auth()->user()->shoppingLists()->find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada o no pertenece al usuario',
                'data' => null
            ], 404);
        }

        $product = $list->products()->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'data' => null
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:1',
            'purchased' => 'sometimes|boolean',
        ]);

        $product->update($request->only(['name', 'quantity', 'purchased']));

        return response()->json([
            'message' => 'Producto actualizado con éxito',
            'data' => $product
        ], 200);
    }

    /**
     * Eliminar un producto de una lista del usuario autenticado
     */
    public function destroy($listId, $id)
    {
        $list = auth()->user()->shoppingLists()->find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada o no pertenece al usuario',
                'data' => null
            ], 404);
        }

        $product = $list->products()->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'data' => null
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado con éxito',
            'data' => null
        ], 200);
    }
}
