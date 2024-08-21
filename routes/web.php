<?php

use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    /* return view('welcome'); */
    return "HOLA MUNDO";
});

Route::get('/productos', [CatalogoController::class, 'index']);
 
