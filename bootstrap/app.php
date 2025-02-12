<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use App\Jobs\ProcessarAgendamentosRecorrentes;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registre middlewares com alias usando group
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configurações para exceções
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            dispatch(new ProcessarAgendamentosRecorrentes());
        })->dailyAt('17:50')->timezone('America/Sao_Paulo');
    })


    ->create();
