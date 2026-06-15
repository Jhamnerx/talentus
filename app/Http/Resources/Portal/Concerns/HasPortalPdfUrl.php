<?php

namespace App\Http\Resources\Portal\Concerns;

use Illuminate\Support\Facades\URL;

trait HasPortalPdfUrl
{
    /**
     * URL temporal firmada para previsualizar/descargar el PDF del documento.
     * La firma incluye el cliente autenticado y autoriza el stream sin token.
     */
    protected function pdfUrl(string $tipo, int|string $id): string
    {
        return URL::temporarySignedRoute(
            'api.portal.files.stream',
            now()->addMinutes((int) config('portal.pdf_link_minutes', 10)),
            [
                'tipo' => $tipo,
                'id' => $id,
                'cliente' => optional(request()->user())->cliente_id,
            ]
        );
    }
}
