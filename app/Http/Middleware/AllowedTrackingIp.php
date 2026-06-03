<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Permite el acceso solo desde la IP configurada en TRACKING_ALLOWED_IP.
 * Usado por los webhooks que la plataforma de rastreo envía a Talentus.
 */
class AllowedTrackingIp
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIp = config('services.tracking.allowed_ip');

        if (blank($allowedIp)) {
            // Sin IP configurada → bloquear por defecto
            abort(403, 'Tracking webhook: IP no configurada.');
        }

        $clientIp = $request->ip();

        if ($clientIp !== $allowedIp) {
            \Illuminate\Support\Facades\Log::channel('daily')->warning('[TrackingWebhook] IP no permitida', [
                'client_ip'  => $clientIp,
                'allowed_ip' => $allowedIp,
            ]);
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    }
}
