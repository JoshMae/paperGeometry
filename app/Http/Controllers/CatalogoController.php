<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CatalogoController extends Controller
{
    public function index()
    {
        // Consume la API externa
        $response = Http::get('http://papergeometry.online/api/producto');
        
        // Verifica si la solicitud fue exitosa
        if ($response->successful()) {
            $productos = $response->json();
        } else {
            $productos = [];
        }
        
        // Pasa los datos a la vista
        return view('productos.index', ['productos' => $productos]);
    }
}
