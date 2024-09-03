<?php

use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "HOLA MUNDO";
});

<<<<<<< HEAD
// Ruta en web.php
Route::get('/carrito', function () {
    return view('carrito');
});
=======
Route::get('/productos', [CatalogoController::class, 'index']);
 
>>>>>>> 4110e25aca71448bfbb0e1d1b6e0a69609b02fe8
