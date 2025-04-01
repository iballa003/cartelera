@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h2>Crear nueva película</h2>

    <form action="{{ route('peliculas.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cartel_url" class="form-label">URL del cartel (de TMDb)</label>
            <input type="text" name="cartel_url" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="es_3d" class="form-check-input" id="es_3d">
            <label class="form-check-label" for="es_3d">Película en 3D</label>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" class="form-control">
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha de fin</label>
            <input type="date" name="fecha_fin" class="form-control">
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar película</button>
    </form>
</div>
@endsection
