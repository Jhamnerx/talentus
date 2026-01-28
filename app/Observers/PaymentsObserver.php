<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\Payments;
use App\Models\BankAccount;
use App\Models\ChangesModels;
use App\Models\GlobalPayment;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;

class PaymentsObserver
{

    public function retrieved(Payments $payment)
    {
        //dd($payment);
    }
    public function creating(Payments $payment)
    {
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
     * Siempre se crea el GlobalPayment, con destino determinado automáticamente
     * 
     * @param Payments $payment
     * @return void
     */
    protected function createGlobalPayment(Payments $payment): void
    {
        try {
            // Determinar el destino basado en el método de pago
            $destination = $this->getDestination($payment);

            // Si no hay destino válido, usar la primera caja o cuenta bancaria disponible
            if (!$destination) {
                // Intentar buscar cualquier caja abierta
                $destination = Cash::where('estado', true)->first();

                // Si no hay caja abierta, buscar cuenta bancaria activa
                if (!$destination) {
                    $destination = BankAccount::where('status', true)->first();
                }

                // Si aún no hay destino, no crear GlobalPayment
                // Esto solo ocurriría si no hay ninguna caja ni cuenta bancaria
                if (!$destination) {
                    Log::warning('No se pudo crear GlobalPayment: no hay caja ni cuenta bancaria', [
                        'payment_id' => $payment->id,
                    ]);
                    return;
                }
            }

            // Determinar el tipo de movimiento (INGRESO o EGRESO)
            $typeMovement = $this->getTypeMovement($payment);

            // Crear el GlobalPayment
            GlobalPayment::create([
                'type_movement' => $typeMovement,
                'date' => $payment->fecha,
                'description' => $this->getDescription($payment),
                'payment_id' => $payment->id,
                'payment_type' => Payments::class,
                'destination_id' => $destination->id,
                'destination_type' => get_class($destination),
                'user_id' => $payment->user_id,
                'empresa_id' => $payment->empresa_id,
            ]);

            // Actualizar el saldo de la caja si el destino es una caja
            if ($destination instanceof Cash) {
                if ($typeMovement === 'INGRESO') {
                    $destination->increment('saldo_actual', $payment->monto);
                } else {
                    $destination->decrement('saldo_actual', $payment->monto);
                }
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
     * Determinar el destino (Cash o BankAccount) basado en el método de pago
     * 
     * Lógica mejorada:
     * - Efectivo (payment_method_id contiene '008', '009', 'efectivo') → Caja abierta del usuario
     * - Otros métodos → Primera caja abierta o cuenta bancaria activa
     * 
     * @param Payments $payment
     * @return Cash|BankAccount|null
     */
    protected function getDestination(Payments $payment)
    {
        $methodId = $payment->payment_method_id;

        // Efectivo → buscar caja abierta del usuario primero
        if (in_array($methodId, ['008', '009']) || stripos($methodId, 'efectivo') !== false) {
            $userCash = Cash::where('user_id', $payment->user_id)
                ->where('estado', true)
                ->first();

            if ($userCash) {
                return $userCash;
            }

            // Si no hay caja del usuario, buscar cualquier caja abierta
            return Cash::where('estado', true)->first();
        }

        // Depósito/Transferencia → buscar cuenta bancaria activa
        if (in_array($methodId, ['001', '003']) || stripos($methodId, 'transferencia') !== false || stripos($methodId, 'deposito') !== false) {
            return BankAccount::where('status', true)->first();
        }

        // Para otros métodos, intentar determinar por el tipo de pago
        // Si es INGRESO, preferir Caja, si es EGRESO preferir cuenta bancaria
        if ($this->getTypeMovement($payment) === 'INGRESO') {
            // Buscar caja del usuario o cualquier caja abierta
            $cash = Cash::where('user_id', $payment->user_id)
                ->where('estado', true)
                ->first();

            return $cash ?? Cash::where('estado', true)->first();
        }

        // Por defecto retornar null para que el método padre busque alternativas
        return null;
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
}
