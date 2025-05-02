<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pantalla general</title>
	<style>
    	body {
        	background-color: #000;
        	color: white;
        	font-family: sans-serif;
        	margin: 0;
        	padding: 20px;
    	}

    	h1 {
        	text-align: center;
        	margin-bottom: 30px;
        	color: #fc0303;
    	}

    	.estrenos-grid {
		  display: flex;
		  flex-wrap: wrap;
		  justify-content: start;
		  gap: 10px;
		  width: 80%;
		  margin: auto;
		}

    	.estreno {
        	background-color: #111;
        	border-radius: 10px;
        	width: 180px;
        	text-align: center;
        	padding: 10px;
        	box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
        	position: relative;
    	}

    	.estreno img {
        	width: 100%;
        	border-radius: 8px;
        	margin-bottom: 10px;
    	}

    	.titulo {
        	font-size: 1.1em;
        	font-weight: bold;
    	}

    	.fecha {
        	color: #ccc;
        	font-size: 0.9em;
    	}

    	.horarios {
            font-size: 1em;
            margin-bottom: 10px;
        }

    	.badge {
        	position: absolute;
        	top: 10px;
        	left: 10px;
        	background-color: #a10000;
        	color: white;
        	padding: 4px 8px;
        	border-radius: 5px;
        	font-size: 0.9em;
    	}

    	.badge_horarios {
            background: #a10000;
            padding: 4px 10px;
            border-radius: 6px;
            margin: 2px;
            font-size: 0.9em;
            display: inline-block;
            color: white;
        }

    	.badge-3d {
        	position: absolute;
        	top: 68px;
        	left: 10px;
        	background-color: #a10000;
        	color: white;
        	padding: 4px 8px;
        	border-radius: 5px;
        	font-size: 0.9em;
    	}
    	.sala-bloque {
            background-color: #d26767;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            text-align: center;
            color: black;
        }
	</style>
</head>
<body>
	<h1>Pantalla general</h1>

	@if ($peliculas->isEmpty())
    	<p style="text-align: center; color: #888;">No hay películas.</p>
	@else
    	<div class="estrenos-grid">
        	@foreach ($peliculas as $pelicula)
            	<div class="estreno">
                	@if ($pelicula->edad_minima)
                    	<img src="{{ asset('edades/' . $pelicula->edad_minima . '.png') }}" alt="Edad mínima" style="position: absolute; top: 10px; left: 10px; height: 50px; width: 50px;">
                	@endif

                	@if ($pelicula->es_3d)
                    	<div class="badge-3d">3D</div>
                	@endif

                	<img src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">

                	<div class="titulo">{{ $pelicula->titulo }}</div>
                	@if ($pelicula->sesiones->isNotEmpty())
                        @php $sesionesPorSala = $pelicula->sesiones->groupBy('sala'); @endphp
                        <div class="horarios">
                            @foreach ($sesionesPorSala as $sala => $sesiones)
                                <div class="sala-bloque">
                                    <strong>SALA: {{ $sala }}</strong><br>
                                    @foreach ($sesiones as $sesion)
                                        <span class="badge_horarios">{{ \Carbon\Carbon::parse($sesion->hora)->format('H:i') }}</span>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                	

            	</div>
        	@endforeach
    	</div>
	@endif
</body>
</html>