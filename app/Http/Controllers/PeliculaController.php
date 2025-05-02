<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peliculas = Pelicula::all();
        return view('pelicula.index', compact('peliculas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pelicula.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'cartel_url' => 'nullable|url',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'observaciones' => 'nullable|string',
            'duracion' => 'nullable|integer|min:1|max:500',
            'edad_minima' => 'nullable|string',
        ]);

        Pelicula::create([
            'titulo' => $request->titulo,
            'cartel_url' => $request->cartel_url,
            'es_3d' => $request->has('es_3d'),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'duracion' => $request->duracion,
            'edad_minima' => $request->edad_minima,
            'observaciones' => $request->observaciones,
        ]);
        return redirect()->route('peliculas.index')->with('success', 'Película creada');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelicula $pelicula)
    {
        return view('pelicula.edit', compact('pelicula'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelicula $pelicula)
    {
        $request->validate([
            'titulo' => 'required',
            'cartel_url' => 'nullable|url',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'observaciones' => 'nullable|string',
            'duracion' => 'nullable|integer|min:1|max:500',
            'edad_minima' => 'nullable|string',
        ]);
        $pelicula->update([
            'titulo' => $request->titulo,
            'cartel_url' => $request->cartel_url,
            'es_3d' => $request->has('es_3d'),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'duracion' => $request->duracion,
            'edad_minima' => $request->edad_minima,
            'observaciones' => $request->observaciones,
        ]);
        return redirect()->route('peliculas.index')->with('success', 'Película actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        
        $pelicula = Pelicula::findOrFail($id);
        if($pelicula->sesiones()->exists()){
            return response()->json(['error' => 'No se puede borrar la pelicula porque tiene sesiones asociadas']);
        }
        $pelicula->delete();
        return response()->json(['message' => 'Pelicula eliminada correctamente']);
    }
}
