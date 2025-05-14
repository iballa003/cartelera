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

        // Evento click en el botón Eliminar
        $(document).on('click', '.btnEliminar', function() {
            let pantallaId = $(this).data('id'); // Obtener el ID de la incidencia
            let fila = $(this).closest('tr'); // Obtener la fila de la tabla
            if (confirm('¿Estás seguro de que quieres eliminar esta pantalla?')) {
                $.ajax({
                    url:'{{ url("pantallas") }}/' + pantallaId,
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
                        toastr.error('Error al eliminar la pantalla.');
                    }
            });

            }
        });
    });

    
</script>

@endsection
