<?php

// Polyfill: get_magic_quotes_runtime() y get_magic_quotes_gpc() eliminadas en PHP 8
// necesarias para setasign/fpdf 1.8.x
if (! function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime(): bool
    {
        return false;
    }
}
if (! function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc(): bool
    {
        return false;
    }
}

use App\Models\TipoCambio;
use App\Services\FactilizaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

if (!function_exists('tipo_cambio')) {
    /**
     * Obtiene el tipo de cambio del día.
     * Primero busca en caché, luego en la base de datos, y finalmente consulta la API de Factiliza.
     * 
     * @param string|null $fecha Fecha en formato Y-m-d (opcional, por defecto hoy)
     * @param string $tipo 'venta' o 'compra' (por defecto 'venta')
     * @param bool $forzarApi Forzar consulta a la API ignorando caché (default: false)
     * @return float|null Retorna el tipo de cambio solicitado
     * 
     * @example
     * $tc = tipo_cambio(); // Obtiene el tipo de cambio de venta de hoy
     * $tc = tipo_cambio(null, 'compra'); // Obtiene el tipo de cambio de compra de hoy
     * $tc = tipo_cambio('2024-01-15'); // Obtiene el tipo de cambio de venta del 15 de enero
     */
    function tipo_cambio(?string $fecha = null, string $tipo = 'venta', bool $forzarApi = false): ?float
    {
        $fecha = $fecha ?? now()->format('Y-m-d');
        $tipo = strtolower($tipo);

        // Validar tipo
        if (!in_array($tipo, ['venta', 'compra'])) {
            Log::warning("Tipo de cambio inválido: {$tipo}. Usando 'venta' por defecto.");
            $tipo = 'venta';
        }

        // Crear clave única para el cache
        $cacheKey = "tipo_cambio_{$tipo}_{$fecha}";

        // Intentar obtener del cache (excepto si se fuerza API)
        if (!$forzarApi && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $factiliza = new FactilizaService();
            $resultado = $factiliza->consultarTipoCambio($fecha, $forzarApi);

            if ($resultado['success'] ?? false) {
                $valor = (float) ($resultado[$tipo] ?? 0);

                // Guardar en cache por 6 horas
                Cache::put($cacheKey, $valor, now()->addHours(6));

                // También guardar en cache legacy (precioVenta/precioCompra) si es el día actual
                if ($fecha === now()->format('Y-m-d')) {
                    $legacyKey = $tipo === 'venta' ? 'precioVenta' : 'precioCompra';
                    Cache::put($legacyKey, $valor, now()->addHours(6));

                    // Mantener compatibilidad con 'cambio' (venta)
                    if ($tipo === 'venta') {
                        Cache::put('cambio', $valor, now()->addHours(6));
                    }
                }

                return $valor;
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Error al obtener tipo de cambio: {$e->getMessage()}");
            return null;
        }
    }
}

if (!function_exists('tipo_cambio_venta')) {
    /**
     * Obtiene el tipo de cambio de venta del día.
     * 
     * @param string|null $fecha Fecha en formato Y-m-d (opcional, por defecto hoy)
     * @return float|null
     */
    function tipo_cambio_venta(?string $fecha = null): ?float
    {
        return tipo_cambio($fecha, 'venta');
    }
}

if (!function_exists('tipo_cambio_compra')) {
    /**
     * Obtiene el tipo de cambio de compra del día.
     * 
     * @param string|null $fecha Fecha en formato Y-m-d (opcional, por defecto hoy)
     * @return float|null
     */
    function tipo_cambio_compra(?string $fecha = null): ?float
    {
        return tipo_cambio($fecha, 'compra');
    }
}

if (!function_exists('actualizar_tipo_cambio')) {
    /**
     * Fuerza la actualización del tipo de cambio desde la API de Factiliza.
     * 
     * @param string|null $fecha Fecha en formato Y-m-d (opcional, por defecto hoy)
     * @return array Retorna array con 'venta' y 'compra' o null si falla
     */
    function actualizar_tipo_cambio(?string $fecha = null): ?array
    {
        $fecha = $fecha ?? now()->format('Y-m-d');

        try {
            $factiliza = new FactilizaService();
            $resultado = $factiliza->consultarTipoCambio($fecha, true); // forzar API

            if ($resultado['success'] ?? false) {
                // Limpiar cache antiguo
                Cache::forget("tipo_cambio_venta_{$fecha}");
                Cache::forget("tipo_cambio_compra_{$fecha}");

                if ($fecha === now()->format('Y-m-d')) {
                    Cache::forget('precioVenta');
                    Cache::forget('precioCompra');
                    Cache::forget('cambio');
                }

                return [
                    'venta' => (float) ($resultado['venta'] ?? 0),
                    'compra' => (float) ($resultado['compra'] ?? 0),
                ];
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Error al actualizar tipo de cambio: {$e->getMessage()}");
            return null;
        }
    }
}

if (!function_exists('mask_email')) {
    /**
     * Enmascara un correo para no revelarlo por completo.
     * Ejemplo: jhamner@empresa.com => jha*****@***.com
     */
    function mask_email(string $email): string
    {
        if (!str_contains($email, '@')) {
            return str_repeat('*', max(strlen($email), 3));
        }

        [$user, $domain] = explode('@', $email, 2);

        $visible = mb_substr($user, 0, 3);
        $userMasked = $visible . str_repeat('*', max(mb_strlen($user) - mb_strlen($visible), 1));

        $dotPos = strrpos($domain, '.');
        $tld = $dotPos !== false ? substr($domain, $dotPos) : '';

        return "{$userMasked}@***{$tld}";
    }
}

if (! function_exists('normalize_wa_number')) {
    /**
     * Normaliza un número de WhatsApp a su forma comparable:
     * elimina todo lo que no sea dígito y, si tiene el código de país
     * configurado como prefijo y queda más largo que un celular local,
     * lo retira para dejar el número nacional (Perú: 9 dígitos).
     */
    function normalize_wa_number(?string $raw): string
    {
        $digits = preg_replace('/\D+/', '', (string) $raw);

        if ($digits === '') {
            return '';
        }

        $cc = (string) config('whatsapp.country_code', '51');

        if ($cc !== '' && str_starts_with($digits, $cc) && strlen($digits) > 9) {
            $digits = substr($digits, strlen($cc));
        }

        return $digits;
    }
}
