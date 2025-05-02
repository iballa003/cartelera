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
            height: 110%;


        }

        .cartel {
            
            width: 690px;
            max-width: 100%;
            height: 590px;
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
            font-size: 1.2em;
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
            font-size: 1.4em;
            color: #ccc;
/*            margin-top: auto;*/
            text-align: center;
            padding-top: 20px;
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
          font-size: 1.4em;
        }
        .infoDiv {
            position: relative;
            top: 20px;
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
                <img class="cartel" src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">
                </div>
                <div class="infoDiv">
                    <h2 class="titulo">{{ $pelicula->titulo }}</h2>
                    
                   @if ($pelicula->duracion)
                    @php
                        $horas = floor($pelicula->duracion / 60);
                        $minutos = $pelicula->duracion % 60;
                    @endphp
                    <div class="info">
                        <div class="duracion">
                            <span style="color: #e80000;">Duración:</span>
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
                @else
                    <div class="observaciones">Ninguna observación</div>
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

