<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiOffline; // Importa tu controlador
use App\Http\Controllers\Api\ApiController; // Importa tu controlador

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/downloadData', [ApiOffline::class, 'DownloadData']);

Route::post('/getPasos', [ApiOffline::class, 'GetPasos']);


// Rutas para el grupo F
// Login General de instructor
Route::post('/login', [ApiController::class, 'login']);
// Login Usuario
Route::post('/loginUser', [ApiController::class, 'loginUser']);
// Subir Crear o Actualizar los detalles de un taller que lleva el usuario
Route::post('/uploadWorkshop', [ApiController::class, 'uploadWorkshop']);
// Para crear el detalle de un taller
Route::post('/createWorkshop', [ApiController::class, 'createWorkshop']);
