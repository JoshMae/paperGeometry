<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    public function create()
    {
        return view('empleado.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idEmpleado' => 'required|integer',
            'usuario' => 'required|string|max:75',
            'contrasenia' => 'required|string|max:15|unique:empleado',
            'idRol' => 'required|integer',
        ]);

        Empleado::create([
            'idEmpleado' => $validatedData['idEmpleado'],
            'usuario' => $validatedData['usuario'],
            'contrasenia' => $validatedData['contrasenia'],
            'idRol' => $validatedData['idRol'],
            'fecha_registro' => now(),
            'estado' => 1,
        ]);

        return redirect()->route('empleado.create')->with('success', 'Usuario registrado exitosamente.');
    }
}
