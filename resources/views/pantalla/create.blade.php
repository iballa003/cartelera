@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h2>Crear nueva pantalla</h2>

    <form action="{{ route('pantallas.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la pantalla</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="orientacion" class="form-label">Orientación</label>
            <select name="orientacion" class="form-select" required>
                <option value="horizontal">Horizontal</option>
                <option value="vertical">Vertical</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="modo" class="form-label">Modo de visualización</label>
            <select name="modo" class="form-select" required>
                <option value="1">1 película</option>
                <option value="2">2 películas</option>
                <option value="3">3 películas</option>
                <option value="general">Vista general</option>
            </select>
        </div>
        <a href="{{ route('pantallas.index') }}" class="btn btn-warning">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar pantalla</button>

    </form>
</div>
@endsection
