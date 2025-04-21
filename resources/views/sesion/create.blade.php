@extends('layouts.app2')

@section('content')
<div class="container">
    <h2>Asignar película a pantalla</h2>
    <form action="{{ route('sesiones.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Pantalla:</label>
            <select name="pantalla_id" class="form-control">
                @foreach ($pantallas as $pantalla)
                    <option value="{{ $pantalla->id }}">{{ $pantalla->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Película:</label>
            <select name="pelicula_id" class="form-control">
                @foreach ($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}">{{ $pelicula->titulo }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha:</label>
            <input type="date" name="fecha" class="form-control" value = "{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Sala</label>
            <input type="text" name="sala" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Hora:</label>
            <input type="time" name="hora" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Asignar</button>
        <a href="{{ route('dashboard') }}" class="btn btn-warning">Cancelar</a>
    </form>
</div>
@endsection
