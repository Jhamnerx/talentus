<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Autentica requests de sistemas externos de tracking (plataforma GPSWox
 * y talentus-pro-tracking). Acepta la request si cumple AL MENOS una de:
 *
 *  1. La IP del cliente coincide con TRACKING_ALLOWED_IP.
 *  2. El header X-API-KEY coincide con TRACKING_API_KEY.
 *
 * Si ninguna de las dos condiciones se cumple, responde 403.
 */
class AllowedTrackingIp
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIp = config('services.tracking.allowed_ip');
        $apiKey    = config('services.tracking.api_key');

        $ipOk  = filled($allowedIp) && $request->ip() === $allowedIp;
        $keyOk = filled($apiKey)    && $request->header('X-API-KEY') === $apiKey;

        if (!$ipOk && !$keyOk) {
            Log::channel('daily')->warning('[Tracking] Acceso denegado', [
                'ip'         => $request->ip(),
                'has_apikey' => $request->hasHeader('X-API-KEY'),
                'path'       => $request->path(),
            ]);
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    }
}
