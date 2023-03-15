<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Verificacion;
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

Route::get('/verificacion', [Verificacion::class,'verificacion'])->middleware(['auth', 'verified'])->name('verificacion');

// Route::get('/codigo', [Verificacion::class,'verificacion'])->middleware(['auth', 'verified'])->name('codigo');

Route::get('/code', [Verificacion::class,'show'])->middleware(['auth', 'verified'])->name('mostrar');

Route::post('/validar/login', [Verificacion::class,'validar_login'])->middleware(['auth', 'verified'])->name('validar_login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
