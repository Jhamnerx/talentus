<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\Payments;
use App\Models\BankAccount;
use App\Models\ChangesModels;
use App\Models\CashDocument;
use App\Models\CashDocumentPayment;
use App\Models\CashDocumentCredit;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\PaymentsController;

class PaymentsObserver
{

    public function retrieved(Payments $payment)
    {
        //dd($payment);
    }
    public function creating(Payments $payment)
    {
        // Generar número de secuencia si no existe
        if (empty($payment->numero)) {
            $payment->numero = (new PaymentsController())->setNextSequenceNumber();
        }

        $payment->empresa_id = session('empresa');
        $payment->user_id = Auth::user()->id;
        
        // Calcular type_movement automáticamente si no está definido
        if (empty($payment->type_movement)) {
            $payment->type_movement = $this->getTypeMovement($payment);
        }

        // Calcular description automáticamente si no está definida
        if (empty($payment->description)) {
            $payment->description = $this->getDescription($payment);
        }

        // Obtener datos de moneda del documento paymentable
        $currencyData = $this->getCurrencyDataFromPaymentable($payment);
        if (empty($payment->divisa)) {
            $payment->divisa = $currencyData['divisa'];
        }
        if (empty($payment->tipo_cambio) || $payment->tipo_cambio == 1) {
            $payment->tipo_cambio = $currencyData['tipo_cambio'];
        }

        // ✅ CRÍTICO: Calcular payment_destination_type y payment_destination_id desde payment_destination_id original
        // Solo se ejecuta si payment_destination_id contiene el valor original ('cash' o ID) pero no el tipo
        if (!empty($payment->payment_destination_id) && empty($payment->payment_destination_type)) {
            $destinationData = $this->getDestinationRecord($payment);
            $payment->payment_destination_type = $destinationData['destination_type'];
            $payment->payment_destination_id = $destinationData['destination_id'];
            
            Log::info('Destino asignado en creating()', [
                'payment_numero' => $payment->numero,
                'input_payment_destination_id' => $payment->payment_destination_id,
                'payment_destination_type' => $payment->payment_destination_type,
                'payment_destination_id' => $payment->payment_destination_id,
            ]);
        }
    }

    public function created(Payments $payment)
    {

        $payment->unique_hash = Hashids::connection(Payments::class)->encode($payment->id);
        $payment->saveQuietly(); // Usar saveQuietly para evitar recursión

        ChangesModels::create([
            'change_id' => $payment->getKey(),
            'change_type' => Payments::class,
            'type' => 'create',
            'user_id' => Auth::user()->id,
        ]);

        // Refrescar el modelo para asegurar que tiene todos los datos
        $payment->refresh();

        // Actualizar saldo de caja multi-moneda si el destino es Cash
        $this->updateCashBalance($payment);

        // Crear CashDocument automáticamente si corresponde (como FactuPRO)
        $this->processCashDocument($payment);
    }
    public function saving(Payments $payment)
    {
        //dd($payment);
    }

    public function updated(Payments $payment)
    {
        //
    }


    public function deleted(Payments $payment)
    {
        //
    }


    public function restored(Payments $payment)
    {
        //
    }


    public function forceDeleted(Payments $payment)
    {
        //
    }

    /**
     * Actualizar saldo de caja multi-moneda cuando se registra un pago
     * 
     * @param Payments $payment
     * @return void
     */
    protected function updateCashBalance(Payments $payment): void
    {
        try {
            // Solo actualizar si el destino es una caja
            if ($payment->payment_destination_type !== Cash::class || !$payment->payment_destination_id) {
                return;
            }

            $cash = Cash::find($payment->payment_destination_id);
            if (!$cash) {
                Log::warning('Caja no encontrada para actualizar saldo', [
                    'payment_id' => $payment->id,
                    'cash_id' => $payment->payment_destination_id,
                ]);
                return;
            }

            // Determinar si es ingreso o egreso
            $esIngreso = $payment->type_movement === 'INGRESO';

            // Determinar montos por moneda
            $montoPen = 0;
            $montoUsd = 0;

            if ($payment->divisa === 'PEN') {
                $montoPen = (float) $payment->monto;
            } elseif ($payment->divisa === 'USD') {
                $montoUsd = (float) $payment->monto;
            }

            // Actualizar saldo usando el método del modelo Cash
            $cash->actualizarSaldoPorMoneda($montoPen, $montoUsd, $esIngreso);

            Log::info('Saldo de caja actualizado (multi-moneda)', [
                'cash_id' => $cash->id,
                'payment_id' => $payment->id,
                'type_movement' => $payment->type_movement,
                'divisa' => $payment->divisa,
                'monto' => $payment->monto,
                'saldo_pen' => $cash->fresh()->saldo_actual_pen,
                'saldo_usd' => $cash->fresh()->saldo_actual_usd,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar saldo de caja', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Obtener destination_id y destination_type desde payment_destination_id
     * Igual que FactuPRO: modules/Finance/Traits/FinanceTrait.php getDestinationRecord()
     * 
     * @param Payments $payment
     * @return array ['destination_id' => int|null, 'destination_type' => string|null]
     */
    protected function getDestinationRecord(Payments $payment): array
    {
        // Si payment_destination_id es 'cash' → es Caja
        if ($payment->payment_destination_id === 'cash') {
            $cash = Cash::where('estado', true)->first();
            return [
                'destination_id' => $cash?->id,
                'destination_type' => Cash::class,
            ];
        }

        // Si es un número → es BankAccount
        if ($payment->payment_destination_id) {
            return [
                'destination_id' => $payment->payment_destination_id,
                'destination_type' => BankAccount::class,
            ];
        }

        // Sin destino especificado
        return [
            'destination_id' => null,
            'destination_type' => null,
        ];
    }

    /**
     * Obtener divisa, monto y tipo_cambio del paymentable (Ventas/Recibos/Compras)
     * 
     * Esto evita N+1 queries en reportes al tener estos valores directamente en Payments
     * 
     * @param Payments $payment
     * @return array ['divisa' => string, 'monto' => float, 'tipo_cambio' => float]
     */
    protected function getCurrencyDataFromPaymentable(Payments $payment): array
    {
        $paymentable = $payment->paymentable;

        // Valores por defecto
        $defaults = [
            'divisa' => 'PEN',
            'monto' => $payment->monto ?? 0,
            'tipo_cambio' => 1,
        ];

        if (!$paymentable) {
            return $defaults;
        }

        // Leer divisa del documento (Ventas, Recibos, Compras tienen 'divisa')
        $divisa = $defaults['divisa'];
        if (isset($paymentable->divisa)) {
            $divisa = strtoupper($paymentable->divisa);
        } elseif (isset($paymentable->currency_type_id)) {
            $divisa = strtoupper($paymentable->currency_type_id);
        } elseif (isset($paymentable->moneda)) {
            $divisa = strtoupper($paymentable->moneda);
        }

        // Leer tipo_cambio del documento
        $tipoCambio = $defaults['tipo_cambio'];
        if (isset($paymentable->tipo_cambio)) {
            $tipoCambio = (float) $paymentable->tipo_cambio;
        } elseif (isset($paymentable->exchange_rate_sale)) {
            $tipoCambio = (float) $paymentable->exchange_rate_sale;
        }

        return [
            'divisa' => $divisa,
            'monto' => $payment->monto ?? 0,
            'tipo_cambio' => $tipoCambio,
        ];
    }

    /**
     * Determinar el tipo de movimiento basado en el tipo de documento
     * 
     * @param Payments $payment
     * @return string
     */
    protected function getTypeMovement(Payments $payment): string
    {
        $paymentableType = $payment->paymentable_type;

        // Ingresos: Recibos (de ingreso) y Ventas
        if (in_array($paymentableType, ['App\Models\Recibos', 'App\Models\Ventas', 'App\Models\Factura'])) {
            return 'INGRESO';
        }

        // Egresos: Compras, RecibosPagosVarios (recibos de egreso/salidas)
        if (in_array($paymentableType, ['App\Models\Compras', 'App\Models\RecibosPagosVarios'])) {
            return 'EGRESO';
        }

        // Por defecto, usar el helper del modelo Payment
        return $payment->isIncome() ? 'INGRESO' : 'EGRESO';
    }

    /**
     * Generar descripción para el Payment
     * 
     * @param Payments $payment
     * @return string
     */
    protected function getDescription(Payments $payment): string
    {
        $paymentable = $payment->paymentable;
        $typeMovement = $this->getTypeMovement($payment);

        if (!$paymentable) {
            return "Pago de {$payment->payment_method_id}";
        }

        // Construir descripción según el tipo
        $documentNumber = $paymentable->numero ?? $paymentable->id ?? 'S/N';

        // Obtener nombre del cliente según el modelo
        $clientName = 'Cliente';
        try {
            // Recibos usa clientes() (plural)
            if (method_exists($paymentable, 'clientes') && $paymentable->clientes) {
                $clientName = $paymentable->clientes->nombre ?? $paymentable->clientes->razon_social ?? 'Cliente';
            }
            // Ventas/Compras usan cliente() (singular)
            elseif (method_exists($paymentable, 'cliente') && $paymentable->cliente) {
                $clientName = $paymentable->cliente->nombre ?? $paymentable->cliente->razon_social ?? 'Cliente';
            }
            // Otros modelos pueden usar customer
            elseif (method_exists($paymentable, 'customer') && $paymentable->customer) {
                $clientName = $paymentable->customer->name ?? $paymentable->customer->razon_social ?? 'Cliente';
            }
        } catch (\Exception $e) {
            // Si hay error obteniendo el cliente, usar valor por defecto
            $clientName = 'Cliente';
        }

        return "{$typeMovement} - {$documentNumber} - {$clientName}";
    }

    /**
     * Procesar y crear CashDocument cuando corresponda (Sistema de Reportes)
     * 
     * Basado en el flujo de FactuPRO: CashController::cash_document()
     * 
     * CashDocument es la tabla que vincula documentos (Ventas, Recibos, Compras)
     * con las cajas donde se registraron. Es ESENCIAL para:
     * 
     * - Reportes de caja por periodo
     * - Historial de documentos por caja
     * - Conciliación de ingresos/egresos
     * - Auditoría de movimientos
     * 
     * Este método se ejecuta DESPUÉS de crear el Payment, por lo que el documento
     * ya está completamente guardado con todos sus pagos.
     * 
     * @param Payments $payment
     */
    protected function processCashDocument(Payments $payment): void
    {
        try {
            // Solo procesar si el pago está asociado a un documento soportado
            $paymentable = $payment->paymentable;
            if (!$paymentable) {
                return;
            }

            // Determinar el tipo de documento y campo correspondiente
            $documentType = class_basename($paymentable);
            $documentField = $this->getDocumentFieldForCash($documentType);

            if (!$documentField) {
                return; // Tipo de documento no soportado
            }

            // Buscar caja abierta del usuario
            $cash = Cash::where([
                ['user_id', $payment->user_id],
                ['estado', true], // Caja abierta
            ])->first();

            if (!$cash) {
                return; // No hay caja abierta, no creamos relación
            }

            // Verificar si ya existe el CashDocument para este documento
            $cashDocument = CashDocument::where([
                'cash_id' => $cash->id,
                $documentField => $paymentable->id,
            ])->first();

            // Si no existe, crear el registro
            if (!$cashDocument) {
                $cashDocument = CashDocument::create([
                    'cash_id' => $cash->id,
                    $documentField => $paymentable->id,
                ]);

                // Si es a crédito, registrar en cash_document_credits
                if ($this->isDocumentCredit($paymentable)) {
                    CashDocumentCredit::create([
                        'cash_id' => $cash->id,
                        $documentField => $paymentable->id,
                        'status' => 'PENDING',
                    ]);
                }

                Log::info("CashDocument creado desde PaymentsObserver", [
                    'document_type' => $documentType,
                    'document_id' => $paymentable->id,
                    'cash_id' => $cash->id,
                ]);
            }

            // SIEMPRE crear el registro en cash_document_payments
            // (Incluso si el CashDocument ya existía, este pago específico puede ser nuevo)
            CashDocumentPayment::updateOrCreate(
                [
                    'cash_id' => $cash->id,
                    'payment_id' => $payment->id,
                ],
                [
                    'cash_document_id' => $cashDocument->id,
                ]
            );
        } catch (\Exception $e) {
            // No fallar si hay error, solo registrar
            Log::error("Error procesando CashDocument en PaymentsObserver: {$e->getMessage()}", [
                'payment_id' => $payment->id ?? null,
                'paymentable_type' => get_class($payment->paymentable ?? null),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Obtener el campo de base de datos según el tipo de documento para CashDocument
     */
    private function getDocumentFieldForCash(string $documentType): ?string
    {
        return match ($documentType) {
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
        // Para documentos con payment_status
        if (property_exists($document, 'payment_status')) {
            return $document->payment_status === 'PENDIENTE' || $document->payment_status === 'PARCIAL';
        }

        // Para otros tipos, verificar si el total supera los pagos
        if (property_exists($document, 'total') && method_exists($document, 'payments')) {
            $totalPagado = $document->payments()->sum('monto');
            return $totalPagado < $document->total;
        }

        return false;
    }
}
