<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelera Vertical Múltiples Películas</title>
    <style>
        body {
            margin: 0;
            background: black;
            color: white;
            font-family: sans-serif;
            overflow-y: auto;
        }

        .contenedor {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            min-height: 100vh;
            width: 100%;
        }

        .pelicula {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 15px;
            min-height: 30vh;
            max-height: 35vh;
            box-sizing: border-box;
            margin-top: 90px;
            justify-content: center;
        }

        .cartel-wrapper {
            position: relative;
            width: auto;
            height: auto;
            display: inline-block;
            overflow: hidden;

            text-align: center;
        }

        .cartel-wrapper img.cartel {
            max-height: 33%;
            max-width: 500px;
            min-width: 50px;
            height: auto;
            object-fit: contain;
            border-radius: 10px;
        }

        .edad-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 50px;
            height: auto;
            background: none;
            padding: 0;
            border-radius: 0;
            z-index: 2;
        }

        .threeD-badge {
            position: absolute;
            top: 180px;
            left: 10px;
            background-color: #a10000;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            width: 12%; 
            text-align: center; 
            font-size: 40px;
            z-index: 2;
        }

        .info {
            padding: 15px;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            width: 30%;
            margin-right: 60px;
        }

        .titulo {
            font-size: 2em;
            margin-bottom: 5px;
            text-align: left;
        }

        .duracion {
            font-size: 1.2em;
            margin-bottom: 8px;
        }

        .horarios {
            font-size: 1em;
            margin-bottom: 10px;
        }

        .sala-bloque {
            background-color: #d26767;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 5px;
            text-align: center;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.05);
        }

        .sala-bloque strong {
            color: #000;
            font-size: 1em;
        }

        .badge {
            background: #a10000;
            padding: 4px 10px;
            border-radius: 6px;
            margin: 2px;
            font-size: 0.9em;
            display: inline-block;
        }

        .observaciones {
            color: #ccc;
            font-size: 1em;
            margin-top: 8px;
            text-align: center;
            max-width: 90%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        @foreach ($peliculas as $pelicula)
            <div class="pelicula">
                <div class="cartel-wrapper">
                    @if ($pelicula->edad_minima)
                        <img src="{{ asset('edades/' . $pelicula->edad_minima . '.png') }}" alt="Edad mínima" style="position: absolute; top: 10px; left: 10px; height: 140px; width: 20%;">
                    @endif

                    @if ($pelicula->es_3d)
                        <div class="threeD-badge">3D</div>
                    @endif

                    <img class="cartel" src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">
                </div>

                <div class="info">
                    <h2 class="titulo">{{ $pelicula->titulo }}</h2>

                    @if ($pelicula->duracion)
                        @php
                            $horas = floor($pelicula->duracion / 60);
                            $minutos = $pelicula->duracion % 60;
                        @endphp
                        <div class="duracion">
                            <span style="color: #e80000;">Duración:</span>
                            {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos > 0 ? $minutos . 'min' : '' }}
                        </div>
                    @endif

                    @if ($pelicula->sesiones->isNotEmpty())
                        @php $sesionesPorSala = $pelicula->sesiones->groupBy('sala'); @endphp
                        <div class="horarios">
                            @foreach ($sesionesPorSala as $sala => $sesiones)
                                <div class="sala-bloque">
                                    <strong>SALA: {{ $sala }}</strong><br>
                                    @foreach ($sesiones as $sesion)
                                        <span class="badge">{{ \Carbon\Carbon::parse($sesion->hora)->format('H:i') }}</span>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($pelicula->observaciones)
                        <div class="observaciones">{{ $pelicula->observaciones }}</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <script>
        setInterval(() => {
            location.reload();
        }, 60000);
    </script>
</body>
</html>
