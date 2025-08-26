<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ShoppingList;

class ProductController extends Controller
{
    /**
     * Listar productos de una lista de compras
     */
    public function index($listId)
    {
        $list = ShoppingList::find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada',
                'data' => []
            ], 404);
        }

        $products = $list->products;

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No hay productos en esta lista',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Productos obtenidos con éxito',
            'data' => $products
        ], 200);
    }

    /**
     * Agregar un producto a la lista
     */
    public function store(Request $request, $listId)
    {
        $list = ShoppingList::find($listId);

        if (!$list) {
            return response()->json([
                'message' => 'Lista no encontrada',
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
     * Mostrar un producto específico
     */
    public function show($listId, $id)
    {
        $product = Product::where('shopping_list_id', $listId)->find($id);

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
     * Actualizar un producto
     */
    public function update(Request $request, $listId, $id)
    {
        $product = Product::where('shopping_list_id', $listId)->find($id);

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
     * Eliminar un producto
     */
    public function destroy($listId, $id)
    {
        $product = Product::where('shopping_list_id', $listId)->find($id);

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
