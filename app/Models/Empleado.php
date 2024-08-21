<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'idEmpleado',
        'uduario',
        'contrasenia',
        'idRol',
        'fecha_registro',
        'estado',
    ];

    public $timestamps = false;

    // Relación con la tabla 'puesto'
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idEmpleado');
    }
}
