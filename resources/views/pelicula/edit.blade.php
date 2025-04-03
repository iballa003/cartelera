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
            <input type="number" name="edad_minima" class="form-control" value="{{ $pelicula->edad_minima }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3">{{ $pelicula->observaciones }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
