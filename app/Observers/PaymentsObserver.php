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

        // Actualizar saldo de cuenta bancaria si el destino es BankAccount
        $this->updateBankAccountBalance($payment);

        // Crear CashDocument automáticamente si corresponde (como FactuPRO)
        $this->processCashDocument($payment);

        // Promover notificaciones FACTURADO → PAGADO si el documento queda saldado
        $this->checkAndMarkNotificacionPagada($payment);
    }
    public function saving(Payments $payment)
    {
        //dd($payment);
    }

    /**
     * Cuando un pago completa el total de un Recibo/Venta vinculado a un
     * PeriodoCobro en estado PENDIENTE, lo promueve a PAGADO.
     */
    protected function checkAndMarkNotificacionPagada(Payments $payment): void
    {
        try {
            if (!$payment->paymentable_type || !$payment->paymentable_id) {
                return;
            }

            $documento = $payment->paymentable;
            if (!$documento) {
                return;
            }

            // Verificar si el documento ya quedó marcado PAID (puede haberlo hecho el llamador)
            $recargado = $documento->fresh();
            if (!$recargado || $recargado->pago_estado !== 'PAID') {
                // Calcular suma de todos los pagos del documento
                $totalPagos = Payments::where('paymentable_type', $payment->paymentable_type)
                    ->where('paymentable_id', $payment->paymentable_id)
                    ->sum('monto');

                if (round((float) $totalPagos, 2) < round((float) $documento->total, 2)) {
                    return; // Documento no está saldado aún
                }

                // Marcar documento como PAID
                $documento->pago_estado = 'PAID';
                $documento->saveQuietly();
            }

            // Buscar PeriodosCobro PENDIENTES vinculados a este documento
            $campo = ($payment->paymentable_type === \App\Models\Recibos::class)
                ? 'recibo_id'
                : 'venta_id';

            $periodos = \App\Models\PeriodoCobro::withoutGlobalScopes()
                ->where($campo, $payment->paymentable_id)
                ->where('estado', 'PENDIENTE')
                ->get();

            foreach ($periodos as $periodo) {
                $periodo->marcarComoPagado();
            }
        } catch (\Exception $e) {
            Log::error('Error al verificar PeriodoCobro en PaymentsObserver', [
                'payment_id' => $payment->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    public function updated(Payments $payment)
    {
        //
    }


    public function deleted(Payments $payment)
    {
        // Revertir saldo de caja si el destino era una caja
        $this->reverseCashBalance($payment);

        // Revertir saldo de cuenta bancaria si el destino era una cuenta bancaria
        $this->reverseBankAccountBalance($payment);

        // Eliminar registros de CashDocumentPayment asociados
        $cashDocumentPayments = CashDocumentPayment::where('payment_id', $payment->id)->get();
        foreach ($cashDocumentPayments as $cdp) {
            $cashDocumentId = $cdp->cash_document_id;
            $cdp->delete();

            // Si el CashDocument ya no tiene más pagos, eliminarlo también
            $remainingPayments = CashDocumentPayment::where('cash_document_id', $cashDocumentId)->count();
            if ($remainingPayments === 0) {
                CashDocument::find($cashDocumentId)?->delete();
            }
        }

        Log::info('Payment eliminado: saldos revertidos y CashDocuments limpiados', [
            'payment_id' => $payment->id,
            'destination_type' => $payment->destination_type,
            'destination_id' => $payment->destination_id,
            'monto' => $payment->monto,
            'type_movement' => $payment->type_movement,
        ]);
    }


    public function restored(Payments $payment)
    {
        //
    }


    public function forceDeleted(Payments $payment)
    {
        // Misma lógica que deleted para borrado permanente
        $this->deleted($payment);
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
            if ($payment->destination_type !== Cash::class || !$payment->destination_id) {
                return;
            }

            $cash = Cash::find($payment->destination_id);
            if (!$cash) {
                Log::warning('Caja no encontrada para actualizar saldo', [
                    'payment_id' => $payment->id,
                    'cash_id' => $payment->destination_id,
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
     * Actualizar saldo de cuenta bancaria cuando se registra un pago
     * 
     * @param Payments $payment
     * @return void
     */
    protected function updateBankAccountBalance(Payments $payment): void
    {
        try {
            // Solo actualizar si el destino es una cuenta bancaria
            if ($payment->destination_type !== BankAccount::class || !$payment->destination_id) {
                return;
            }

            $bankAccount = BankAccount::find($payment->destination_id);
            if (!$bankAccount) {
                Log::warning('Cuenta bancaria no encontrada para actualizar saldo', [
                    'payment_id' => $payment->id,
                    'bank_account_id' => $payment->destination_id,
                ]);
                return;
            }

            // Determinar si es ingreso o egreso
            $esIngreso = $payment->type_movement === 'INGRESO';

            // Calcular nuevo saldo
            $saldoActual = (float) $bankAccount->initial_balance;
            $monto = (float) $payment->monto;

            if ($esIngreso) {
                $nuevoSaldo = $saldoActual + $monto;
            } else {
                $nuevoSaldo = $saldoActual - $monto;
            }

            // Actualizar saldo de la cuenta bancaria
            $bankAccount->update([
                'initial_balance' => $nuevoSaldo,
            ]);

            Log::info('Saldo de cuenta bancaria actualizado', [
                'bank_account_id' => $bankAccount->id,
                'payment_id' => $payment->id,
                'type_movement' => $payment->type_movement,
                'divisa' => $payment->divisa,
                'monto' => $payment->monto,
                'saldo_anterior' => $saldoActual,
                'saldo_nuevo' => $nuevoSaldo,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar saldo de cuenta bancaria', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }



    /**
     * Revertir saldo de caja al eliminar un pago (operación inversa a updateCashBalance)
     */
    protected function reverseCashBalance(Payments $payment): void
    {
        try {
            if ($payment->destination_type !== Cash::class || !$payment->destination_id) {
                return;
            }

            $cash = Cash::find($payment->destination_id);
            if (!$cash) {
                return;
            }

            // Invertir: si era INGRESO, revertir con EGRESO (y viceversa)
            $eraIngreso = $payment->type_movement === 'INGRESO';

            $montoPen = $payment->divisa === 'PEN' ? (float) $payment->monto : 0;
            $montoUsd = $payment->divisa === 'USD' ? (float) $payment->monto : 0;

            // Pasar esIngreso=false si era ingreso (para restar) y true si era egreso (para sumar)
            $cash->actualizarSaldoPorMoneda($montoPen, $montoUsd, !$eraIngreso);

            Log::info('Saldo de caja revertido al eliminar payment', [
                'cash_id' => $cash->id,
                'payment_id' => $payment->id,
                'monto' => $payment->monto,
                'divisa' => $payment->divisa,
                'type_movement_original' => $payment->type_movement,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al revertir saldo de caja', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Revertir saldo de cuenta bancaria al eliminar un pago (operación inversa a updateBankAccountBalance)
     */
    protected function reverseBankAccountBalance(Payments $payment): void
    {
        try {
            if ($payment->destination_type !== BankAccount::class || !$payment->destination_id) {
                return;
            }

            $bankAccount = BankAccount::find($payment->destination_id);
            if (!$bankAccount) {
                return;
            }

            $eraIngreso = $payment->type_movement === 'INGRESO';
            $saldoActual = (float) $bankAccount->initial_balance;
            $monto = (float) $payment->monto;

            // Invertir: si era ingreso se resta, si era egreso se suma
            $nuevoSaldo = $eraIngreso
                ? $saldoActual - $monto
                : $saldoActual + $monto;

            $bankAccount->update(['initial_balance' => $nuevoSaldo]);

            Log::info('Saldo de cuenta bancaria revertido al eliminar payment', [
                'bank_account_id' => $bankAccount->id,
                'payment_id' => $payment->id,
                'monto' => $payment->monto,
                'saldo_anterior' => $saldoActual,
                'saldo_nuevo' => $nuevoSaldo,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al revertir saldo de cuenta bancaria', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
        }
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

            // Usar el destino del pago si es una caja
            $cash = null;

            if ($payment->destination_type === Cash::class && $payment->destination_id) {
                $cash = Cash::find($payment->destination_id);
            }

            // Si no hay destino de caja en el pago, buscar cualquier caja abierta del sistema
            if (!$cash) {
                $cash = Cash::where('estado', true)->first();
            }

            if (!$cash) {
                return; // No hay caja disponible
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
