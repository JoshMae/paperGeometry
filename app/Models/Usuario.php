<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'idEmpleado',
        'usuario',
        'contrasenia', // Aquí se almacenará la contraseña sin cifrar
        'idRol',
        'fecha_registro',
        'estado'
    ];

    public $timestamps = false;

    // Relación con la tabla 'empleado'
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idEmpleado');
    }

    // Relación con la tabla 'rol'
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }
}

