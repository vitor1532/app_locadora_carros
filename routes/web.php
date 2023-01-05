<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Rotas /home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas /marcas
Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware('auth');

// Rotas /modelos
Route::get('/modelos', function () {
    return view('app.modelos');
})->name('modelos')->middleware('auth');

