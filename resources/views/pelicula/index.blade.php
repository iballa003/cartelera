@extends('layouts.app2')

@section('content')
<div class="container mt-4">
    <h2>Películas registradas</h2>

    <a href="{{ route('dashboard') }}" class="btn btn-warning mb-3">Volver al dashboard</a>
    <a href="{{ route('peliculas.create') }}" class="btn btn-success mb-3">+ Nueva película</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="tablaPelículas" class="table table-hover">
        <thead>
            <tr>
                <th>Título</th>
                <th>Cartel</th>
                <th>3D</th>
                <th>Duracion</th>
                <th>Edad min.</th>
                <th>Rango de fechas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peliculas as $pelicula)
                <tr>
                    <td>{{ $pelicula->titulo }}</td>
                    <td>
                        @if($pelicula->cartel_url)
                            <img src="{{ $pelicula->cartel_url }}" alt="cartel" width="60">
                        @else
                            <span class="text-muted">No disponible</span>
                        @endif
                    </td>
                    <td>{{ $pelicula->es_3d ? 'Sí' : 'No' }}</td>
                    <td>{{ $pelicula->duracion }} minutos</td>
                    <td>{{ $pelicula->edad_minima }} años</td>
                    <td>
                        {{ $pelicula->fecha_inicio ?? '–' }} <br>
                        {{ $pelicula->fecha_fin ?? '–' }}
                    </td>
                    <td>
                        <a href="{{ route('peliculas.edit', $pelicula) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <button class="btn btn-sm btn-danger btnEliminar" data-id="{{$pelicula->id}}">Eliminar</button>
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
            if (confirm('¿Estás seguro de que quieres eliminar esta incidencia?')) {
                $.ajax({
                    url:'{{ url("peliculas") }}/' + peliculaId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.error) {
                            toastr.error(response.error);
                        }else{
                            toastr.success(response.message);
                            fila.remove();
                        }
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
