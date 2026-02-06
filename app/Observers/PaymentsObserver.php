<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\Payments;
use App\Models\BankAccount;
use App\Models\ChangesModels;
use App\Models\GlobalPayment;
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

        // Crear GlobalPayment automáticamente (Opción 1)
        $this->createGlobalPayment($payment);

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
     * Crear GlobalPayment automáticamente cuando se crea un Payment
     * 
     * IMPORTANTE: Siempre se crea el GlobalPayment, incluso si no hay destino.
     * Esto permite rastrear todos los movimientos financieros aunque no haya
     * caja abierta o cuenta bancaria activa.
     * 
     * destination_id puede ser NULL si:
     * - Es pago en efectivo pero no hay caja abierta
     * - Es pago bancario pero no hay cuenta activa
     * - Es pago a crédito (no genera movimiento inmediato)
     * 
     * El sistema de reportes debe manejar estos casos y permitir
     * reasignar movimientos "huérfanos" a cajas/cuentas después.
     * 
     * @param Payments $payment
     * @return void
     */
    protected function createGlobalPayment(Payments $payment): void
    {
        try {
            // Obtener destino usando payment_destination_id (como FactuPRO)
            $destinationData = $this->getDestinationRecord($payment);

            // Determinar el tipo de movimiento (INGRESO o EGRESO)
            $typeMovement = $this->getTypeMovement($payment);

            // Crear GlobalPayment con destination_type y destination_id
            GlobalPayment::create([
                'type_movement' => $typeMovement,
                'date' => $payment->fecha,
                'description' => $this->getDescription($payment),
                'payment_id' => $payment->id,
                'payment_type' => Payments::class,
                'destination_id' => $destinationData['destination_id'],
                'destination_type' => $destinationData['destination_type'],
                'user_id' => $payment->user_id,
                'empresa_id' => $payment->empresa_id,
            ]);

            // Actualizar el saldo de la caja SOLO si hay destino Y es una caja
            if ($destination instanceof Cash) {
                if ($typeMovement === 'INGRESO') {
                    $destination->increment('saldo_actual', $payment->monto);
                } else {
                    $destination->decrement('saldo_actual', $payment->monto);
                }
            }

            // Log informativo si no hay destino
            if (!$destination) {
                Log::info('GlobalPayment creado sin destino específico', [
                    'payment_id' => $payment->id,
                    'type_movement' => $typeMovement,
                    'monto' => $payment->monto,
                    'nota' => 'El movimiento está registrado pero no asignado a caja/banco. Puede reasignarse después.',
                ]);
            }
        } catch (\Exception $e) {
            // Log el error pero NO fallar la creación del Payment
            Log::error('Error al crear GlobalPayment automático', [
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
     * Generar descripción para el GlobalPayment
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
     * Procesar y crear CashDocument cuando corresponda
     * Basado en el flujo de FactuPRO: CashController::cash_document()
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
