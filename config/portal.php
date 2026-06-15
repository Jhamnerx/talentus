<?php

return [

    /*
    |--------------------------------------------------------------------------
    | URL del portal de cliente (Next.js)
    |--------------------------------------------------------------------------
    |
    | Base usada para construir enlaces que apuntan al frontend del portal
    | (verificación de correo redirigida, reset de contraseña, etc.).
    |
    */

    'url' => env('PORTAL_URL', 'http://localhost:3001'),

    /*
    |--------------------------------------------------------------------------
    | Expiración de enlaces firmados (minutos)
    |--------------------------------------------------------------------------
    */

    'signed_link_minutes' => env('PORTAL_SIGNED_LINK_MINUTES', 60),

    /*
    |--------------------------------------------------------------------------
    | Expiración de URLs firmadas de PDF (minutos)
    |--------------------------------------------------------------------------
    */

    'pdf_link_minutes' => env('PORTAL_PDF_LINK_MINUTES', 10),

    /*
    |--------------------------------------------------------------------------
    | Empresa resuelta en runtime
    |--------------------------------------------------------------------------
    |
    | La establece el middleware SetPortalEmpresa por petición. No configurar.
    |
    */

    'empresa_id' => null,

];
