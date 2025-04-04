<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\GradoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api.key')->group(function () {
    Route::resource('alumnos', AlumnoController::class);
    Route::get('/grados', [GradoController::class, 'index']);
});

