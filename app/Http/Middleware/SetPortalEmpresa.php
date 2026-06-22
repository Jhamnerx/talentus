<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPortalEmpresa
{
    /**
     * Inyecta el contexto de empresa del cliente autenticado para que el
     * EmpresaScope funcione en peticiones stateless del portal.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clienteUser = $request->user();

        if ($clienteUser && $clienteUser->cliente) {
            $empresaId = $clienteUser->cliente->empresa_id;

            session(['empresa' => $empresaId]);
            config(['portal.empresa_id' => $empresaId]);
        }

        return $next($request);
    }
}
