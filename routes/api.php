<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;




Route::post('usuarios', [UsuarioController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);



Route::middleware(\App\Http\Middleware\EnsureApiIsAuthenticated::class)->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);



    Route::get('usuarios', [UsuarioController::class, 'index']);
    Route::get('usuarios/{id}', [UsuarioController::class, 'show']);

    Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);
});


Route::middleware(\App\Http\Middleware\EnsureApiIsAuthenticated::class)->group(function () {
    Route::get('medicos', [MedicoController::class, 'index']);
    Route::get('medicos/{id}', [MedicoController::class, 'show']);
    Route::post('medicos', [MedicoController::class, 'store']);
    Route::put('medicos/{id}', [MedicoController::class, 'update']);
    Route::delete('medicos/{id}', [MedicoController::class, 'destroy']);
});
