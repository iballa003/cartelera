@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h3>Editar pantalla</h3>

    <form action="{{ route('pantallas.update', $pantalla) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $pantalla->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Orientación</label>
            <select name="orientacion" class="form-select" required>
                <option value="horizontal" {{ old('orientacion', $pantalla->orientacion) == 'horizontal' ? 'selected' : '' }}>Horizontal</option>
                <option value="vertical" {{ old('orientacion', $pantalla->orientacion) == 'vertical' ? 'selected' : '' }}>Vertical</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Modo</label>
            <select name="modo" class="form-select" required>
                <option value="1" {{ old('modo', $pantalla->modo) == '1' ? 'selected' : '' }}>Modo 1 (una película)</option>
                <option value="2" {{ old('modo', $pantalla->modo) == '2' ? 'selected' : '' }}>Modo 2 (dos películas)</option>
                <option value="3" {{ old('modo', $pantalla->modo) == '3' ? 'selected' : '' }}>Modo 3 (tres películas)</option>
                <option value="general" {{ old('modo', $pantalla->modo) == 'general' ? 'selected' : '' }}>Modo general (todas)</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('pantallas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
