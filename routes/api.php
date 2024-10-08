<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;

Route::get('/producto', [ProductoController::class, 'index']);

Route::post('/carrito/token', [CarritoController::class, 'createCartToken']);  // Generar un token para el carrito
Route::post('/carrito/agregar', [CarritoController::class, 'addToCart']);              // Agregar producto al carrito
Route::get('/carrito', [CarritoController::class, 'getCart']);                 // Obtener productos del carrito
Route::put('/carrito/{idCarrito}', [CarritoController::class, 'updateQuantity']);                 // Actualiza cantidad de productos en carrito
Route::delete('/carrito/eliminar/{idProducto}', [CarritoController::class, 'removeFromCart']);  // Eliminar producto del carrito


