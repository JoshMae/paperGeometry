<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    /* return view('welcome'); */
    return "HOLA MUNDO";
});


Route::get('empleado/create', [EmpleadoController::class, 'create'])->name('empleado.create');
Route::post('empleado/store', [EmpleadoController::class, 'store'])->name('empleado.store');


Route::get('/usuario/create', [UsuarioController::class, 'create'])->name('usuario.create');
Route::post('/usuario/store', [UsuarioController::class, 'store'])->name('usuario.store');

