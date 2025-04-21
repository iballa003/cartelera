<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pantalla;
use App\Models\Sesion;
use App\Models\Pelicula;
class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sesiones = Sesion::all();
        return view('sesion.index', compact('sesiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pantallas = Pantalla::all();
        $peliculas = Pelicula::all();

        return view('sesion.create', compact('pantallas', 'peliculas'));
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
            'pantalla_id' => 'required|exists:pantallas,id',
            'pelicula_id' => 'required|exists:peliculas,id',
            'sala' => 'required',
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);

        Sesion::create($request->all());
        return redirect()->route('dashboard')->with('success', 'sesión asignada correctamente');
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
    public function edit(Sesion $sesion)
    {
        $peliculas = Pelicula::all();
        $pantallas = Pantalla::all();
        return view('sesion.edit', compact('sesion', 'peliculas', 'pantallas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sesion $sesion)
    {
        $request->validate([
            'pantalla_id' => 'required|exists:pantallas,id',
            'pelicula_id' => 'required|exists:peliculas,id',
            'sala' => 'required',
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);
        $sesion->update([
            'pantalla_id' => $request->pantalla_id,
            'pelicula_id' => $request->pelicula_id,
            'es_3d' => $request->has('es_3d'),
            'sala' => $request->sala,
            'fecha' => $request->fecha?? now()->format('Y-m-d'),
            'hora' => $request->hora ?? now()->format('H:i:s'),
        ]);
        return redirect()->route('sesiones.index')->with('success', 'Sesión actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sesion = Sesion::findOrFail($id);
        $sesion->delete();
        return response()->json(['message' => 'Sesion eliminada correctamente']);
    }
}
