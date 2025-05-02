@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h2>Editar película</h2>

    <form action="{{ route('peliculas.update', $pelicula) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ $pelicula->titulo }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">URL del cartel</label>
            <input type="text" name="cartel_url" class="form-control" value="{{ $pelicula->cartel_url }}">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="es_3d" class="form-check-input" id="es_3d"
                {{ $pelicula->es_3d ? 'checked' : '' }}>
            <label class="form-check-label" for="es_3d">Película en 3D</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" value="{{ $pelicula->fecha_inicio }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de fin</label>
            <input type="date" name="fecha_fin" class="form-control" value="{{ $pelicula->fecha_fin }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Duración</label>
            <input type="number" name="duracion" class="form-control" value="{{ $pelicula->duracion }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Edad mínima</label>
                <select class="form-control form-control-sm" name="edad_minima" required>
                    <option value="todas" {{ $pelicula->edad_minima == 'todas'? 'selected' : ''}}>Para todos los públicos</option>
                    <option value="7" {{ $pelicula->edad_minima == '7'? 'selected' : ''}}>No recomendada para menores de 7 años</option>
                    <option value="todas-recomendadas" {{ $pelicula->edad_minima == 'todas-recomendadas'? 'selected' : ''}}>Para todos los públicos(recomendada para la infancia) </option>
                    <option value="7-recomendada" {{ $pelicula->edad_minima == '7-recomendada'? 'selected' : ''}}>No recomendada para menores de 7 años(recomendada para la infancia)</option>
                    <option value="12" {{ $pelicula->edad_minima == '12'? 'selected' : ''}}>No recomendada para menores de 12 años</option>
                    <option value="16" {{ $pelicula->edad_minima == '16'? 'selected' : ''}}>No recomendada para menores de 16 años</option>
                    <option value="18" {{ $pelicula->edad_minima == '18'? 'selected' : ''}}>No recomendada para menores de 18 años</option>
                    <option value="x" {{ $pelicula->edad_minima == 'x'? 'selected' : ''}}>Película x</option>
                </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3">{{ $pelicula->observaciones }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
