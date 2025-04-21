@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h2>Sesiones asignadas</h2>

    <a href="{{ route('dashboard') }}" class="btn btn-warning mb-3">Volver al dashboard</a>
    <a href="{{ route('sesiones.create') }}" class="btn btn-success mb-3">+ Nueva sesión</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="tablaPelículas" class="table table-hover">
        <thead>
            <tr>
                <th>Película</th>
                <th>Pantalla</th>
                <th>Sala</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sesiones as $sesion)
                <tr>
                    <td>{{ $sesion->pelicula->titulo }} [sesión: {{Carbon\Carbon::parse($sesion->hora)->format('H:i')}}]</td>
                    <td><a href="{{ url('/pantalla/' . $sesion->pantalla->id) }}" target="_blank">
                            /pantalla/{{ $sesion->pantalla->id }}
                        </a></td>
                    <td>{{ $sesion->sala }}</td>
                    <td>{{ $sesion->fecha }}</td>
                    <td>{{ $sesion->hora }}</td>
                    <td>
                        <a href="{{ route('sesiones.edit', $sesion) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <button class="btn btn-sm btn-danger btnEliminar" data-id="{{$sesion->id}}">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#tablaPelículas').DataTable({
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

        // Evento click en el botón Eliminar
        $(document).on('click', '.btnEliminar', function() {
            let peliculaId = $(this).data('id'); // Obtener el ID de la incidencia
            let fila = $(this).closest('tr'); // Obtener la fila de la tabla
            if (confirm('¿Estás seguro de que quieres eliminar esta sesión?')) {
                $.ajax({
                    url:'{{ url("sesiones") }}/' + peliculaId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        fila.remove();
                    },
                    error: function(xhr) {
                        console.error('ERROR: ', xhr.status, xhr.responseText)
                        toastr.error('Error al eliminar la película.');
                    }
            });

            }
        });
    });
</script>
@endsection