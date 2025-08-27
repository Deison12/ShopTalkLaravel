<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShoppingListController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// -----------------------------
// Rutas públicas
// -----------------------------

// Registro de usuarios
Route::post('/register', [RegisterController::class, 'register']);

// Login con JWT
Route::post('/login', [LoginController::class, 'login']);

// -----------------------------
// Rutas protegidas con JWT
// -----------------------------
Route::middleware('auth:api')->group(function () {

    // Información del usuario autenticado
    Route::get('/me', [LoginController::class, 'me']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/refresh', [LoginController::class, 'refresh']);

    // CRUD de listas de compras
    Route::apiResource('lists', ShoppingListController::class);

    // CRUD de productos dentro de una lista
    Route::get('/lists/{listId}/products', [ProductController::class, 'index']);
    Route::post('/lists/{listId}/products', [ProductController::class, 'store']);
    Route::get('/lists/{listId}/products/{id}', [ProductController::class, 'show']);
    Route::put('/lists/{listId}/products/{id}', [ProductController::class, 'update']);
    Route::delete('/lists/{listId}/products/{id}', [ProductController::class, 'destroy']);

    // Gestión de usuarios (solo si quieres exponerlo protegido)
    Route::get('/users', [RegisterController::class, 'index']);
    Route::put('/users/{id}', [RegisterController::class, 'update']);
    Route::delete('/users/{id}', [RegisterController::class, 'destroy']);
});
