@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h3>Editar pantalla</h3>

    <form action="{{ route('sesiones.update', $sesion) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Pelicula</label>
            <select name="pelicula_id" class="form-select" required>
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}" {{$sesion->pelicula_id == $pelicula->id? 'selected' : ''}}>{{$pelicula->titulo}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Pantalla</label>
            <select name="pantalla_id" class="form-select" required>
                @foreach($pantallas as $pantalla)
                    <option value="{{ $pantalla->id }}" {{$sesion->pantalla_id == $pantalla->id? 'selected' : ''}}>{{$pantalla->nombre}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $sesion->fecha }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="text" name="hora" class="form-control" value="{{ $sesion->hora }}">
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('sesiones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection