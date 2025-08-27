<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShoppingListController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;



Route::apiResource('lists', ShoppingListController::class);
// Productos dentro de una lista
Route::get('/lists/{listId}/products', [ProductController::class, 'index']);
Route::post('/lists/{listId}/products', [ProductController::class, 'store']);
Route::get('/lists/{listId}/products/{id}', [ProductController::class, 'show']);
Route::put('/lists/{listId}/products/{id}', [ProductController::class, 'update']);
Route::delete('/lists/{listId}/products/{id}', [ProductController::class, 'destroy']);

// Registrar
Route::post('/register', [RegisterController::class, 'register']);
// Listar todos
Route::get('/users', [RegisterController::class, 'index']);
// Actualizar
Route::put('/users/{id}', [RegisterController::class, 'update']);
// Eliminar
Route::delete('/users/{id}', [RegisterController::class, 'destroy']);
//login
Route::post('/login', [LoginController::class, 'login']);