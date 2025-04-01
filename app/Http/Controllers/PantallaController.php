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
    $orientacion = $pantalla->orientacion;
    if ($pantalla->modo === 'general') {
        // Mostrar todas las películas activas hoy con sus sesiones
        $peliculas = Pelicula::whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->with(['sesiones' => function ($query) use ($hoy) {
                $query->where('fecha', $hoy)->orderBy('hora');
            }])
            ->get();
    } else {
        // Mostrar solo las películas asignadas a esta pantalla para hoy
        $peliculas = Pelicula::whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->whereHas('sesiones', function ($query) use ($id, $hoy) {
                $query->where('pantalla_id', $id)->where('fecha', $hoy);
            })
            ->with(['sesiones' => function ($query) use ($id, $hoy) {
                $query->where('pantalla_id', $id)->where('fecha', $hoy)->orderBy('hora');
            }])
            ->get();
    }

    // Próximos estrenos (opcionales)
    $estrenos = Pelicula::whereDate('fecha_inicio', '>', $hoy)
        ->orderBy('fecha_inicio')
        ->take(5)
        ->get();

    return view('pantalla.player', compact('pantalla', 'peliculas', 'estrenos', 'orientacion'));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
}
