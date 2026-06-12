<?php

namespace App\Observers;

use App\Models\Comprobantes;
use App\Services\StockService;

class ComprobanteObserver
{
    public function __construct(protected StockService $stock) {}

    /**
     * Handle the Comprobantes "created" event.
     */
    public function created(Comprobantes $comprobante): void
    {
        // Nota de crédito (07) con motivo de devolución: revertir stock de la venta.
        if (
            $comprobante->tipo_comprobante_id === '07'
            && $this->stock->motivoDevuelveStock($comprobante->sustento_id)
        ) {
            $this->stock->revertirNotaCredito($comprobante);
        }
    }
    public function creating(Comprobantes $nota): void
    {
        if (!\App::runningInConsole()) {
            $nota->user_id = auth()->user()->id;
            $nota->empresa_id = session('empresa');
        }
    }
    /**
     * Handle the Comprobantes "updated" event.
     */
    public function updated(Comprobantes $comprobantes): void
    {
        //
    }

    /**
     * Handle the Comprobantes "deleted" event.
     */
    public function deleted(Comprobantes $comprobantes): void
    {
        //
    }

    /**
     * Handle the Comprobantes "restored" event.
     */
    public function restored(Comprobantes $comprobantes): void
    {
        //
    }

    /**
     * Handle the Comprobantes "force deleted" event.
     */
    public function forceDeleted(Comprobantes $comprobantes): void
    {
        //
    }
}
