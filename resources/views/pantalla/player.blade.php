<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelera</title>
    <style>
        body {
            margin: 0;
            background: black;
            color: white;
            font-family: sans-serif;
        }

        .contenedor {
            display: flex;
            flex-direction: {{ $orientacion === 'vertical' ? 'column' : 'row' }};
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            height: 100vh;
        }

        .pelicula {
            flex: 1;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            overflow: hidden;
        }

        .cartel {
            max-width: 100%;
            max-height: {{ $orientacion === 'vertical' ? '60%' : '70%' }};
            object-fit: contain;
            margin-bottom: 10px;
        }

        .titulo {
            font-size: {{ $orientacion === 'vertical' ? '2.5em' : '2em' }};
            margin: 0 0 5px 0;
            text-align: center;
        }

        .horarios {
            font-size: 1.3em;
            margin-bottom: 5px;
            text-align: center;
        }

        .badge {
            background: #555;
            padding: 4px 10px;
            border-radius: 6px;
            margin: 2px;
            font-size: 1em;
            display: inline-block;
        }

        .observaciones {
            font-size: 1.1em;
            color: #ccc;
            margin-top: auto;
            text-align: center;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        @foreach ($peliculas as $pelicula)
            <div class="pelicula">
                <img class="cartel" src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">

                <h2 class="titulo">{{ $pelicula->titulo }}</h2>

                <div class="horarios">
                    @foreach ($pelicula->sesiones as $sesion)
                        <span class="badge">{{ \Carbon\Carbon::parse($sesion->hora)->format('H:i') }}</span>
                    @endforeach
                </div>

                @if ($pelicula->es_3d)
                    <div class="badge">3D</div>
                @endif

                @if ($pelicula->observaciones)
                    <div class="observaciones">{{ $pelicula->observaciones }}</div>
                @endif
            </div>
        @endforeach


    </div>
    @if ($estrenos->isNotEmpty() && $pantalla->modo === 'general')
    <div style="width: 100%; padding: 20px; text-align: center;">
        <h2 style="color: gold; margin-bottom: 15px;">Próximos Estrenos</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            @foreach ($estrenos as $pelicula)
                <div style="margin: 10px; width: 150px; text-align: center;">
                    <img src="{{ asset($pelicula->cartel_url) }}" style="width: 100%; border-radius: 10px;">
                    <div style="color: white; font-size: 1em; margin-top: 5px;">
                        {{ $pelicula->titulo }}
                    </div>
                    <div style="color: #aaa; font-size: 0.9em;">
                        Estreno: {{ \Carbon\Carbon::parse($pelicula->fecha_inicio)->format('d/m/Y') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
    <script>
        setInterval(() => {
            location.reload();
        }, 60000); // Recarga cada 60 segundos
    </script>
</body>
</html>


