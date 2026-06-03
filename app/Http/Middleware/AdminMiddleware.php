<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Verifica se o usuário autenticado possui perfil de administrador.
     * Retorna 403 caso contrário.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->tipo_perfil !== 'ADMIN') {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
