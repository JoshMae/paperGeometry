<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('usuario.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idEmpleado' => 'required|integer',
            'usuario' => 'required|string|max:45',
            'contrasenia' => 'required|string|max:45',
            'idRol' => 'required|integer',
        ]);

        Usuario::create([
            'idEmpleado' => $validatedData['idEmpleado'],
            'usuario' => $validatedData['usuario'],
            'contrasenia' => $validatedData['contrasenia'],
            'idRol' => $validatedData['idRol'],
            'fecha_registro' => now(),
            'estado' => 1,
        ]);

        return redirect()->route('usuario.create')->with('success', 'Usuario registrado exitosamente.');
    }
}
