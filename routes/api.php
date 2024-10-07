<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AtendenteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\MedicoController;
use App\Http\Middleware\EnsureApiIsAuthenticated as EnsureApiIsAuthenticatedAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;




Route::post('usuarios', [UsuarioController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/test', [UsuarioController::class, 'test']);


Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('usuarios', [UsuarioController::class, 'index']);
    Route::get('usuarios/{id}', [UsuarioController::class, 'show']);

    Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);
});


Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('medicos', [MedicoController::class, 'index']);
    Route::get('medicos/{id}', [MedicoController::class, 'show']);
    Route::post('medicos', [MedicoController::class, 'store']);
    Route::put('medicos/{id}', [MedicoController::class, 'update']);
    Route::delete('medicos/{id}', [MedicoController::class, 'destroy']);
});

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('enderecos', [EnderecoController::class, 'index']);
    Route::get('enderecos/{id}', [EnderecoController::class, 'show']);
    Route::post('enderecos', [EnderecoController::class, 'store']);
    Route::put('enderecos/{id}', [EnderecoController::class, 'update']);
    Route::delete('enderecos/{id}', [EnderecoController::class, 'destroy']);
});

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('atendentes', [AtendenteController::class, 'index']);
    Route::get('atendentes/{id}', [AtendenteController::class, 'show']);
    Route::post('atendentes', [AtendenteController::class, 'store']);
    Route::put('atendentes/{id}', [AtendenteController::class, 'update']);
    Route::delete('atendentes/{id}', [AtendenteController::class, 'destroy']);
});

Route::middleware(EnsureApiIsAuthenticatedAlias::class)->group(function () {
    Route::get('agendamentos', [AgendamentoController::class, 'index']);
    Route::get('agendamentos/{id}', [AgendamentoController::class, 'show']);
    Route::post('agendamentos', [AgendamentoController::class, 'store']);
    Route::put('agendamentos/{id}', [AgendamentoController::class, 'update']);
    Route::delete('agendamentos/{id}', [AgendamentoController::class, 'destroy']);
});




