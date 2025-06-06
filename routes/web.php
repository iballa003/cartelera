<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PantallaController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pantalla/{id}',[PantallaController::class, 'mostrar']);
Route::get('/estrenos',[PantallaController::class, 'estrenos']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('pantallas', PantallaController::class);
    Route::resource('peliculas', PeliculaController::class);
    //Route::resource('sesiones', SesionController::class)->only(['create', 'store']);
    Route::resource('sesiones', SesionController::class)->parameters(['sesiones' => 'sesion']);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
