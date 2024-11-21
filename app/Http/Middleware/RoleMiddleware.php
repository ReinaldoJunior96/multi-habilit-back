<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles  Roles permitidas
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verifica se o usuário está autenticado
        $user = auth()->guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401)
                ->header('Content-Type', 'application/json');
        }

        // Verifica se o usuário tem uma das roles permitidas
        if (!in_array($user->role, $roles)) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403)
                ->header('Content-Type', 'application/json');
        }

        // Passa a requisição para o próximo middleware ou controlador
        return $next($request);
    }
}
