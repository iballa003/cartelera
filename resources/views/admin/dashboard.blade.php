@extends('layouts.app2')

@section('content')
<div class="container">
    <h1>Panel de administración</h1>
    <ul>
        <li><a href="{{ route('pantallas.index') }}">Pantallas</a></li>
        <li><a href="{{ route('peliculas.index') }}">Películas</a></li>
        <li><a href="{{ route('sesiones.create') }}">Asignar Sesión</a></li>
    </ul>
</div>
@endsection
