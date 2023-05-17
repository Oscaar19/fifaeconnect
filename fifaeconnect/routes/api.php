<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\UsuariController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\FotoController;
use App\Http\Controllers\Api\JugadorController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\GoldenController;
use App\Http\Controllers\Api\CoachController;

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

Route::get('/coaches/freeagents', [CoachController::class, 'coachesFA']);
Route::apiResource('coaches', CoachController::class);

Route::post('clubs/{club}', [ClubController::class, 'update_workaround']);


Route::apiResource('users', UsuariController::class);

Route::apiResource('goldens', GoldenController::class);

Route::post('/users/{user}/goldens', [UsuariController::class, 'golden']);
Route::delete('/users/{user}/goldens', [UsuariController::class, 'ungolden']);

Route::get('/managers/freeagents', [ManagerController::class, 'managersFA']);
Route::apiResource('managers', ManagerController::class);

Route::apiResource('fotos', FotoController::class);

Route::get('/jugadors/freeagents', [JugadorController::class, 'jugadorsFA']);
Route::apiResource('jugadors', JugadorController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [TokenController::class, 'register']);

Route::post('/login', [TokenController::class, 'login']);

Route::post('/logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', [TokenController::class, 'user'])->middleware('auth:sanctum');
