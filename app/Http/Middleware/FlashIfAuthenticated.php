<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FlashIfAuthenticated
{
    /**
     * Se o usuário já estiver autenticado, adiciona uma mensagem flash e segue o fluxo.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            // Mostrado no layout de tarefas via partial de flash
            $request->session()->flash('success', 'Você já está autenticado.');
        }

        return $next($request);
    }
}
