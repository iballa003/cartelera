@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h2>Pantallas registradas</h2>

    <a href="{{ route('dashboard') }}" class="btn btn-warning mb-3">Volver al dashboard</a>
    <a href="{{ route('pantallas.create') }}" class="btn btn-primary mb-3">+ Nueva pantalla</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="tablaPantallas" class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Orientación</th>
                <th>Modo</th>
                <th>URL</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pantallas as $pantalla)
                <tr>
                    <td>{{ $pantalla->nombre }}</td>
                    <td>{{ ucfirst($pantalla->orientacion) }}</td>
                    <td>{{ $pantalla->modo }}</td>
                    <td>
                        <a href="{{ url('/pantalla/' . $pantalla->id) }}" target="_blank">
                            /pantalla/{{ $pantalla->id }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('pantallas.edit', $pantalla) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <button class="btn btn-sm btn-danger btnEliminar" data-id="{{$pantalla->id}}">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#tablaPantallas').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });

    
</script>

@endsection
