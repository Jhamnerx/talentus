<?php

namespace App\Observers;

use App\Models\DetalleCobros;

class DetalleCobroObserver
{
    public function creating(DetalleCobros $detalle): void
    {
        // empresa_id se hereda del cobro padre (no es necesario asignarlo aquí)
    }
}
