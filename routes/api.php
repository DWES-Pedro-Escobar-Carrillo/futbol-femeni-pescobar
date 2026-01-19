<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JugadoraController;
use App\Http\Controllers\Api\EquipController;
use App\Http\Controllers\Api\EstadiController;
use App\Http\Controllers\Api\PartitController;

// Rutes públiques d'autenticació
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Grup protegit per Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth profile
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // User info (existent)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Recursos API
    Route::apiResource('jugadores', JugadoraController::class)
        ->parameters(['jugadores' => 'jugadora']);
        
    Route::apiResource('equips', EquipController::class);
    Route::apiResource('estadis', EstadiController::class);
    Route::apiResource('partits', PartitController::class);
});