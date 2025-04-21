<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pantalla;
use App\Models\Pelicula;
class PantallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pantallas = Pantalla::all();
        return view('pantalla.index', compact('pantallas'));
    }

public function mostrar($id)
{
    $pantalla = Pantalla::findOrFail($id);
    $hoy = now()->toDateString();

    $peliculas = Pelicula::whereDate('fecha_inicio', '<=', $hoy)
        ->whereDate('fecha_fin', '>=', $hoy)
        ->with(['sesiones' => function ($query) use ($id, $hoy) {
            $query->where('pantalla_id', $id)
                  ->where('fecha', $hoy)
                  ->with('pantalla')
                  ->orderBy('hora');
        }])
        ->get()
        ->filter(function ($pelicula) {
            return $pelicula->sesiones->isNotEmpty();
        });
        if(in_array($pantalla->modo, ['1','2','3'])){
            $peliculas = $peliculas->take((int) $pantalla->modo);
        }

    if ($pantalla->orientacion === 'horizontal' && $pantalla->modo === '1') {
        return view('pantalla.player_horizontal_uno', [
        'peliculas' => $peliculas,
        'orientacion' => $pantalla->orientacion,
        'pantalla' => $pantalla
    ]);
    }

    return view('pantalla.player', [
        'peliculas' => $peliculas,
        'orientacion' => $pantalla->orientacion,
        'pantalla' => $pantalla
    ]);
}


public function estrenos()
{
    $hoy = now()->toDateString();

    $estrenos = Pelicula::whereDate('fecha_inicio', '>', $hoy)
    ->orderBy('fecha_inicio')
    ->get();

    return view('pantalla.estrenos', compact('estrenos'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pantalla.create');
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
            'nombre' => 'required',
            'orientacion' => 'required|in:horizontal,vertical',
            'modo' => 'required|in:1,2,3,general'
        ]);

        Pantalla::create($request->all());
        return redirect()->route('pantallas.index')->with('success', 'pantalla creada');
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
    public function edit(Pantalla $pantalla)
    {
        return view('pantalla.edit', compact('pantalla'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pantalla $pantalla)
    {
        $request->validate([
            'nombre' => 'required',
            'orientacion' => 'required|in:horizontal,vertical',
            'modo' => 'required|in:1,2,3,general'
        ]);
        $pantalla->update([
            'nombre' => $request->nombre,
            'orientacion' => $request->orientacion,
            'modo' => $request->modo,
        ]);
        return redirect()->route('pantallas.index')->with('success', 'Pantalla actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pantalla = Pantalla::findOrFail($id);
        if($pantalla->sesiones()->exists()){
            return response()->json(['error' => 'No se puede borrar la pantalla porque tiene sesiones asociadas']);
        }
        $pantalla->delete();
        return response()->json(['message' => 'Pantalla eliminada correctamente']);
    }
}
