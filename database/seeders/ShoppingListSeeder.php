<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShoppingList;
use App\Models\Product;

class ShoppingListSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     */
    public function run(): void
    {
        // Lista 1
        $list1 = ShoppingList::create([
            'name' => 'Mercado de Plaza',
        ]);

        $list1->products()->createMany([
            ['name' => 'Arroz', 'quantity' => 2],
            ['name' => 'Tomates', 'quantity' => 5],
            ['name' => 'Carne', 'quantity' => 1],
        ]);

        // Lista 2
        $list2 = ShoppingList::create([
            'name' => 'Fiesta del Domingo',
        ]);

        $list2->products()->createMany([
            ['name' => 'Cervezas', 'quantity' => 12],
            ['name' => 'Snacks', 'quantity' => 5],
            ['name' => 'Carbón', 'quantity' => 2],
            ['name' => 'Pollo', 'quantity' => 3],
        ]);

        // Lista 3
        $list3 = ShoppingList::create([
            'name' => 'Compras del Hogar',
        ]);

        $list3->products()->createMany([
            ['name' => 'Leche', 'quantity' => 6],
            ['name' => 'Huevos', 'quantity' => 30],
            ['name' => 'Papel higiénico', 'quantity' => 12],
        ]);
    }
}
