<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\UsuariController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\FotoController;
use App\Http\Controllers\Api\JugadorController;

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

Route::apiResource('clubs', ClubController::class);

Route::post('clubs/{club}', [ClubController::class, 'update_workaround']);

Route::apiResource('users', UsuariController::class);

Route::apiResource('managers', ManagerController::class);

Route::apiResource('fotos', FotoController::class);

Route::apiResource('jugadors', JugadorController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
