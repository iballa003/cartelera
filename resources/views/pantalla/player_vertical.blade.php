<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelera Vertical</title>
    <style>
        body {
            margin: 0;
            background: black;
            color: white;
            font-family: sans-serif;
            overflow-x: hidden;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            width: 100%;
        }

        .cartel-wrapper {
            position: relative;
            width: auto;
            max-width: 90%;
            height: auto;
            max-height: 60vh;
            display: inline-block;
        }

        .cartel-wrapper img {
            height: 100%;
            width: 500px;
            max-width: 100%;
            object-fit: fill;
            border-radius: 10px;
        }

        .edad-badge, .threeD-badge {
            position: absolute;
            background-color: #a10000;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 1.2em;
            z-index: 1;
        }

        .edad-badge { top: 10px; left: 10px; }
        .threeD-badge { top: 60px; left: 10px; background-color: #a10000; }

        .titulo {
            font-size: 2em;
            margin-top: 10px;
            text-align: center;
        }

        .duracion {
            margin-top: 10px;
            font-size: 1.4em;
            
        }

        .horarios {
            margin-top: 15px;
            text-align: center;
        }

        .sala-bloque {
            background-color: #d26767;
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
            text-align: center;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.05);
        }

        .sala-bloque strong {
            color: #000;
            display: block;
            margin-bottom: 6px;
            font-size: 1.1em;
        }

        .badge {
            background: #a10000;
            padding: 4px 10px;
            border-radius: 6px;
            margin: 2px;
            font-size: 1em;
            display: inline-block;
        }

        .observaciones {
            color: #ccc;
            font-size: 1.2em;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            max-width: 90%;
        }

        .observaciones-wrapper {
            width: 35%;
        }
    </style>
</head>
<body>

    @foreach ($peliculas as $pelicula)
        <div class="pelicula">

            <div class="cartel-wrapper">
                @if ($pelicula->edad_minima)
                    <div class="edad-badge">+{{ $pelicula->edad_minima }}</div>
                @endif

                @if ($pelicula->es_3d)
                    <div class="threeD-badge">3D</div>
                @endif

                <img src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">
            </div>

            <h2 class="titulo">{{ $pelicula->titulo }}</h2>

            @if ($pelicula->duracion)
                @php
                    $horas = floor($pelicula->duracion / 60);
                    $minutos = $pelicula->duracion % 60;
                @endphp
                <div class="duracion">
                    <span style="color: #e80000;">Duración:</span> {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos > 0 ? $minutos . 'min' : '' }}
                </div>
            @endif

            @if ($pelicula->sesiones->isNotEmpty())
                @php $sesionesPorSala = $pelicula->sesiones->groupBy('sala'); @endphp
                <div class="horarios">
                    @foreach ($sesionesPorSala as $sala => $sesiones)
                        <div class="sala-bloque">
                            <strong>SALA: {{ $sala }}</strong>
                            <div>
                                @foreach ($sesiones as $sesion)
                                    <span class="badge">{{ \Carbon\Carbon::parse($sesion->hora)->format('H:i') }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="color: #aaa;">Horarios no disponibles</div>
            @endif
            <div class="observaciones-wrapper">
                @if ($pelicula->observaciones)
                    <div class="observaciones">{{ $pelicula->observaciones }}</div>
                @else
                    <div class="observaciones">Ninguna observación</div>
                @endif
            </div>
        </div>
    @endforeach

    <script>
        setInterval(() => {
            location.reload();
        }, 60000);
    </script>
</body>
</html>
