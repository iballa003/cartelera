<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Próximos Estrenos</title>
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
        	justify-content: center;
        	gap: 20px;
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

    	.badge-3d {
        	position: absolute;
        	top: 40px;
        	left: 10px;
        	background-color: #a10000;
        	color: white;
        	padding: 4px 8px;
        	border-radius: 5px;
        	font-size: 0.9em;
    	}
	</style>
</head>
<body>
	<h1>Próximos Estrenos</h1>

	@if ($estrenos->isEmpty())
    	<p style="text-align: center; color: #888;">No hay estrenos programados.</p>
	@else
    	<div class="estrenos-grid">
        	@foreach ($estrenos as $pelicula)
            	<div class="estreno">
                	@if ($pelicula->edad_minima)
                    	<div class="badge">+{{ $pelicula->edad_minima }}</div>
                	@endif

                	@if ($pelicula->es_3d)
                    	<div class="badge-3d">3D</div>
                	@endif

                	<img src="{{ asset($pelicula->cartel_url) }}" alt="{{ $pelicula->titulo }}">

                	<div class="titulo">{{ $pelicula->titulo }}</div>
                	<div class="fecha">
                    	Estreno: {{ \Carbon\Carbon::parse($pelicula->fecha_inicio)->format('d/m/Y') }}
                	</div>
            	</div>
        	@endforeach
    	</div>
	@endif
</body>
</html>
