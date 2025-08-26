<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $table = 'shopping_lists';

    protected $fillable = [
        'name',
    ];

    /**
     * Relación con productos
     * Una lista puede tener muchos productos
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'shopping_list_id');
    }
}
