<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\CashDocument;
use App\Models\CashDocumentPayment;
use App\Models\CashDocumentCredit;
use Illuminate\Support\Facades\Log;

/**
 * Observer para crear automáticamente registros en cash_documents
 * cuando se crean documentos (Recibos, Ventas) con pagos asociados
 * 
 * Basado en el flujo de FactuPRO: CashController::cash_document()
 */
class DocumentoCashObserver
{
    /**
     * Procesar documento creado para relacionarlo con caja si corresponde
     * 
     * @param mixed $document Puede ser Recibo o Venta
     */
    public function created($document)
    {
        try {
            // Determinar el campo de ID según el tipo de documento
            $documentField = $this->getDocumentField($document);
            if (!$documentField) {
                return; // Tipo de documento no soportado
            }

            // Si el documento no tiene pagos, no hay nada que hacer
            if (!$document->payments || $document->payments->isEmpty()) {
                return;
            }

            // Buscar caja abierta del usuario que creó el documento
            $cash = Cash::where([
                ['user_id', $document->user_id ?? auth()->id()],
                ['estado', true], // Caja abierta
            ])->first();

            // Si no hay caja abierta, no creamos la relación
            if (!$cash) {
                return;
            }

            // Crear registro en cash_documents
            $cashDocument = CashDocument::create([
                'cash_id' => $cash->id,
                $documentField => $document->id,
            ]);

            // Crear registros en cash_document_payments por cada pago del documento
            foreach ($document->payments as $payment) {
                CashDocumentPayment::create([
                    'cash_id' => $cash->id,
                    'payment_id' => $payment->id,
                    'cash_document_id' => $cashDocument->id,
                ]);
            }

            // Si el documento es a crédito, crear registro en cash_document_credits
            $isCredit = $this->isDocumentCredit($document);
            if ($isCredit) {
                CashDocumentCredit::create([
                    'cash_id' => $cash->id,
                    $documentField => $document->id,
                    'status' => 'PENDING',
                ]);
            }

            Log::info("CashDocument creado automáticamente", [
                'document_type' => class_basename($document),
                'document_id' => $document->id,
                'cash_id' => $cash->id,
                'payments_count' => $document->payments->count(),
                'is_credit' => $isCredit,
            ]);
        } catch (\Exception $e) {
            // No fallar si hay error, solo registrar
            Log::error("Error creando CashDocument: {$e->getMessage()}", [
                'document_type' => class_basename($document),
                'document_id' => $document->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Obtener el campo de base de datos según el tipo de documento
     */
    private function getDocumentField($document): ?string
    {
        return match (class_basename($document)) {
            'Recibos' => 'recibo_id',
            'Ventas' => 'venta_id',
            'Compras' => 'compra_id',
            'Cotizaciones' => 'cotizacion_id',
            'WorkOrder' => 'orden_trabajo_id',
            default => null,
        };
    }

    /**
     * Determinar si el documento es a crédito
     */
    private function isDocumentCredit($document): bool
    {
        // Para Recibos y Ventas, verificar el estado de pago
        if (property_exists($document, 'payment_status')) {
            return $document->payment_status === 'PENDIENTE' || $document->payment_status === 'PARCIAL';
        }

        // Para otros tipos, verificar si el monto total supera los pagos
        if ($document->payments && property_exists($document, 'total')) {
            $totalPagado = $document->payments->sum('monto');
            return $totalPagado < $document->total;
        }

        return false;
    }
}
