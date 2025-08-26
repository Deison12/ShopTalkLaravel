<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShoppingListController;
use App\Http\Controllers\Api\ProductController;
// Route::get('/Estudiantes', function () {
//     return 'Lista de Estudiantes ';
// });
Route::apiResource('lists', ShoppingListController::class);
// Productos dentro de una lista
Route::get('/lists/{listId}/products', [ProductController::class, 'index']);
Route::post('/lists/{listId}/products', [ProductController::class, 'store']);
Route::get('/lists/{listId}/products/{id}', [ProductController::class, 'show']);
Route::put('/lists/{listId}/products/{id}', [ProductController::class, 'update']);
Route::delete('/lists/{listId}/products/{id}', [ProductController::class, 'destroy']);

