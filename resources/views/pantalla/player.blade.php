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
            overflow-y: hidden;
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
            height: 120%;
        }

        .cartel {          
            width: 620px;
            max-width: 100%;
            height: 690px;
            object-fit: fill;
            margin-bottom: 10px;
        }

        .cartel-wrapper {
            width: auto;
            position: relative;
            display: inline-block;
            height: auto;
            max-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edad-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #a10000;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 1.4em;
            z-index: 1;
        }

        .threeD-badge {
            position: absolute;
            top: 70px;
            left: 11px;
            background-color: #a10000;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 1.4em;
            z-index: 1;
        }

           .sala-bloque {
                background-color: #d26767;
                padding: 2px;
                border-radius: 8px;
                margin-bottom: 10px;
                text-align: center;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.05);
            }
            .sala-bloque strong {
                color: #000000;
                display: block;
                margin-bottom: 6px;
                font-size: 30px;
            }

        .titulo {
            font-size: 2.5em;
            margin: 0 0 5px 0;
            text-align: left;
        }

        .horarios {
            font-size: 1.6em;
            margin-bottom: 5px;
            text-align: center;
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
            font-size: 1.8em;
            color: #ccc;
/*            margin-top: auto;*/
            text-align: center;
            padding-top: 60px;
        }

        .observaciones-wrapper {
            width: 50%;
        }

        .info {
            font-size: 1em;
            color: #ffffff;
            margin-bottom: 8px;
        }
        .duracion {
          font-size: 1.8em;
        }
        .infoDiv {
            position: relative;
            top: 60px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        @foreach ($peliculas as $pelicula)
            <div class="pelicula">
                <div class="cartel-wrapper">
                    @if ($pelicula->edad_minima)
                    <img src="{{ asset('edades/' . $pelicula->edad_minima . '.png') }}" alt="Edad mínima" style="position: absolute; top: 10px; left: 10px; height: 50px;">
                    <!-- <div class="edad-badge">
                        +{{ $pelicula->edad_minima }}
                    </div> -->
                    
                @endif
                @if ($pelicula->es_3d)
                        <div class="threeD-badge">3D</div>
                    @endif
                <img class="cartel" style="height: {{$pelicula->observaciones ? '690px' : '790px'}}" src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">
                </div>
                <div class="infoDiv" style="top: {{$pelicula->observaciones ? '60px' : '90px'}}">
                    <h2 class="titulo">{{ $pelicula->titulo }}</h2>
                    
                   @if ($pelicula->duracion)
                    @php
                        $horas = floor($pelicula->duracion / 60);
                        $minutos = $pelicula->duracion % 60;
                    @endphp
                    <div class="info">
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
                            </span>
                            {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos > 0 ? $minutos . 'min' : '' }}
                        </div>
                    </div>
                @endif


                    @if ($pelicula->sesiones->isNotEmpty())
        @php
            $sesionesPorSala = $pelicula->sesiones->groupBy('sala');
        @endphp

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
        <div style="color: #aaa; font-size: 1em;">Horarios no disponibles</div>
    @endif
</div>
            <div class="observaciones-wrapper">
                 @if ($pelicula->observaciones)
                    <div class="observaciones">{{ $pelicula->observaciones }}</div>
                @endif
            </div>
            </div>
        @endforeach
    </div>

    <script>
        // setInterval(() => {
        //     location.reload();
        // }, 60000); // recarga cada 1 minuto
    </script>
</body>
</html>

