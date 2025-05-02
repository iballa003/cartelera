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
            <label class="form-label">Duración</label>
            <input type="number" name="duracion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Edad mínima</label>
                <select class="form-control form-control-sm" name="edad_minima" required>
                    <option value="todas">Para todos los públicos</option>
                    <option value="7">No recomendada para menores de 7 años</option>
                    <option value="todas-recomendadas">Para todos los públicos(recomendada para la infancia)</option>
                    <option value="7-recomendada">No recomendada para menores de 7 años(recomendada para la infancia)</option>
                    <option value="12">No recomendada para menores de 12 años</option>
                    <option value="16">No recomendada para menores de 16 años</option>
                    <option value="18">No recomendada para menores de 18 años</option>
                    <option value="x">Película x</option>
                </select>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar película</button>
    </form>
</div>
@endsection
