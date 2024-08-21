@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Usuario</h1>
    <form action="{{ route('usuario.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="idEmpleado">Empleado</label>
            <input type="number" class="form-control" id="idEmpleado" name="idEmpleado" required>
        </div>
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <!-- <div class="form-group">
            <label for="contrasenia">Contraseña</label>
            <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
        </div> -->
        <div class="form-group">
            <label for="idRol">Rol</label>
            <input type="number" class="form-control" id="idRol" name="idRol" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection
