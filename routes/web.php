<?php

use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "HOLA MUNDO";
});


// Ruta en web.php
Route::get('/carrito', function () {
    return view('carrito');
});

Route::get('/productos', [CatalogoController::class, 'index']);
 

