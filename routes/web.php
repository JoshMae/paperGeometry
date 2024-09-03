<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "HOLA MUNDO";
});

// Ruta en web.php
Route::get('/carrito', function () {
    return view('carrito');
});
