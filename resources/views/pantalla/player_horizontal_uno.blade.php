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
            height: 100vh;
            display: flex;
        }

        .imagen {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .cartel-wrapper {
            position: relative;
            width: 100%;
            max-width: 90%;
            height: auto;
        }

        .cartel-wrapper img {
            max-height: 90vh;
            max-width: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .edad-badge, .threeD-badge {
            position: absolute;
            background-color: #a10000;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 1em;
            z-index: 1;
        }

        .edad-badge {
            top: 10px;
            left: 10px;
        }

        .threeD-badge {
            top: 50px;
            left: 10px;
            background-color: #a10000;
        }

        .info {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .titulo {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        span.badge {
            background-color: #a10000;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 1em;
            display: inline-block;
            margin-bottom: 10px;
            margin-right: 8px;
        }

        .horarios {
            margin-top: 15px;
        }

        .sala-bloque {
            background-color: #d26767;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            text-align: center;
        }

        .sala-bloque strong {
            color: #000;
            display: block;
            margin-bottom: 6px;
            font-size: 25px;
        }

        .observaciones {
            color: #ccc;
            font-size: 1.1em;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    @php $pelicula = $peliculas->first(); @endphp
    @if ($pelicula)
    <div class="imagen">
        <div class="cartel-wrapper">
            @if ($pelicula->edad_minima)
                <div class="edad-badge">+{{ $pelicula->edad_minima }}</div>
            @endif

            @if ($pelicula->es_3d)
                <div class="threeD-badge">3D</div>
            @endif

            <img src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">
        </div>
    </div>

    <div class="info">
        <h2 class="titulo">{{ $pelicula->titulo }}</h2>

        @if ($pelicula->duracion)
            @php
                $horas = floor($pelicula->duracion / 60);
                $minutos = $pelicula->duracion % 60;
            @endphp
            <div class="badge">
                <span style="color: #e80000;">Duración:</span> {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos > 0 ? $minutos . 'min' : '' }}
            </div>
        @endif

        @if ($pelicula->sesiones->isNotEmpty())
            @php $sesionesPorSala = $pelicula->sesiones->groupBy('pantalla.nombre'); @endphp
            <div class="horarios">
                @foreach ($sesionesPorSala as $sala => $sesiones)
                    <div class="sala-bloque">
                        <strong>SALA: {{ $sala }}</strong>
                        @foreach ($sesiones as $sesion)
                            <span class="badge">{{ \Carbon\Carbon::parse($sesion->hora)->format('H:i') }}</span>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <div style="color: #aaa;">Horarios no disponibles</div>
        @endif

        @if ($pelicula->observaciones)
            <div class="observaciones">{{ $pelicula->observaciones }}</div>
        @else
            <div class="observaciones">Ninguna observación</div>
        @endif
    </div>
    @else
    <div style="text-align: center; width: 100%; padding: 50px;">
        <h2 style="color: #e80000; ">Ninguna película</h2>
    </div>
    @endif
    <script>
        setInterval(() => {
            location.reload();
        }, 60000);
    </script>
</body>
</html>

