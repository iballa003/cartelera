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
            width: 90%;
            height: 100%;
            
        }

        .cartel-wrapper {
            position: relative;
            width: auto;
            max-width: 100%;
            display: inline-block;
            height: 100%;
            min-height: 50%;
            max-height: 100%;
        }

        .cartel-wrapper img {
            height: 100%;
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
            font-size: 1.2em;
            z-index: 1;
        }

        .edad-badge { top: 10px; left: 10px; }
        .threeD-badge { top: 300px; left: 10px; background-color: #a10000; width: 12%; text-align: center; font-size: 40px;}

        .titulo {
            font-size: 2.5em;
            margin-top: 15px;
            text-align: center;
        }

        .duracion {
            margin-top: -15px;
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
            text-align: center;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.05);
        }

        .sala-bloque strong {
            color: #000;
            display: block;
            margin-bottom: 6px;
            font-size: 30px;
        }

        .badge {
            background: #a10000;
            padding: 4px 10px;
            border-radius: 6px;
            margin: 2px;
            font-size: 1.2em;
            display: inline-block;
        }

        .observaciones {
            color: #ccc;
            font-size: 1.2em;
            margin-top: 5px;
            text-align: center;
            padding: 10px;
            max-width: 90%;
        }

        .observaciones-wrapper {
            width: 40%;
            padding: 20px;
        }
    </style>
</head>
<body>

    @foreach ($peliculas as $pelicula)
        <div class="pelicula">

            <div class="cartel-wrapper">
                @if ($pelicula->edad_minima)
                    <img src="{{ asset('edades/' . $pelicula->edad_minima . '.png') }}" alt="Edad mínima" style="position: absolute; top: 10px; left: 10px; height: 25%; width: 25%;">
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
                    <span style="color: #e80000;">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        >
                          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                          <path d="M12 7v5" />
                          <path d="M12 12l2 -3" />
                        </svg>
                    </span> {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos > 0 ? $minutos . 'min' : '' }}
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
                @endif
            </div>
        </div>
    @endforeach

    <script>
        // setInterval(() => {
        //     location.reload();
        // }, 60000);
    </script>
</body>
</html>
