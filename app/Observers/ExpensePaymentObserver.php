<?php

namespace App\Observers;

use App\Models\ExpensePayment;
use App\Models\GlobalPayment;
use App\Models\Cash;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Log;

class ExpensePaymentObserver
{
    /**
     * Handle the ExpensePayment "created" event.
     */
    public function created(ExpensePayment $expensePayment): void
    {
        $this->createGlobalPayment($expensePayment);
    }

    /**
     * Crea el movimiento financiero global
     */
    private function createGlobalPayment(ExpensePayment $expensePayment): void
    {
        try {
            $destination = $this->getDestination($expensePayment);

            if (!$destination) {
                Log::warning('No se encontró destino para ExpensePayment', [
                    'expense_payment_id' => $expensePayment->id,
                    'expense_method_type_id' => $expensePayment->expense_method_type_id,
                    'expense_id' => $expensePayment->expense_id,
                ]);
                return;
            }

            GlobalPayment::create([
                'payment_id' => $expensePayment->id,
                'payment_type' => ExpensePayment::class,
                'destination_id' => $destination->id,
                'destination_type' => get_class($destination),
                'type_movement' => 'EGRESO',
                'description' => $this->getDescription($expensePayment),
            ]);

            // Actualizar saldo si es Cash
            if ($destination instanceof Cash && $destination->estado) {
                $destination->decrement('saldo_actual', $expensePayment->payment);

                Log::info('Saldo de caja decrementado por ExpensePayment', [
                    'cash_id' => $destination->id,
                    'expense_payment_id' => $expensePayment->id,
                    'monto' => $expensePayment->payment,
                    'nuevo_saldo' => $destination->fresh()->saldo_actual,
                ]);
            }

            Log::info('GlobalPayment creado desde ExpensePayment', [
                'expense_payment_id' => $expensePayment->id,
                'destination' => get_class($destination),
                'destination_id' => $destination->id,
                'monto' => $expensePayment->payment,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear GlobalPayment desde ExpensePayment', [
                'expense_payment_id' => $expensePayment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Determina el destino del pago según el método
     */
    private function getDestination(ExpensePayment $expensePayment): Cash|BankAccount|null
    {
        $methodType = $expensePayment->expenseMethodType;

        if (!$methodType) {
            return null;
        }

        // CAJA GENERAL (ID 1) → Cash
        if ($methodType->id === 1 || stripos($methodType->description, 'caja') !== false) {
            return Cash::where('estado', true)->first();
        }

        // Transferencia (ID 4) → BankAccount
        if ($methodType->id === 4 || stripos($methodType->description, 'transferencia') !== false) {
            return BankAccount::where('status', true)->first();
        }

        // Tarjetas (ID 2, 3) → BankAccount
        if ($methodType->has_card) {
            return BankAccount::where('status', true)->first();
        }

        // Cheque (ID 5) → BankAccount
        if ($methodType->id === 5 || stripos($methodType->description, 'cheque') !== false) {
            return BankAccount::where('status', true)->first();
        }

        // Fallback: buscar cualquier Cash abierta, luego BankAccount activa
        return Cash::where('estado', true)->first()
            ?? BankAccount::where('status', true)->first();
    }

    /**
     * Genera descripción automática del movimiento
     */
    private function getDescription(ExpensePayment $expensePayment): string
    {
        $expense = $expensePayment->expense;

        if (!$expense) {
            return "EGRESO - Pago de gasto #{$expensePayment->expense_id}";
        }

        $serie = $expense->serie_numero ?? $expense->numero_documento ?? 'Sin número';
        $proveedor = $expense->proveedor->name ?? 'Sin proveedor';
        $method = $expensePayment->expenseMethodType->description ?? 'Sin método';

        return "EGRESO - {$serie} - {$proveedor} - {$method}";
    }

    /**
     * Handle the ExpensePayment "updated" event.
     */
    public function updated(ExpensePayment $expensePayment): void
    {
        // Si cambia el monto, actualizar GlobalPayment
        if ($expensePayment->isDirty('payment')) {
            $globalPayment = $expensePayment->globalPayment;

            if ($globalPayment) {
                $globalPayment->update([
                    'description' => $this->getDescription($expensePayment),
                ]);
            }
        }
    }

    /**
     * Handle the ExpensePayment "deleted" event.
     */
    public function deleted(ExpensePayment $expensePayment): void
    {
        // Al eliminar el pago, revertir el saldo de caja si aplica
        $globalPayment = $expensePayment->globalPayment;

        if ($globalPayment && $globalPayment->destination instanceof Cash) {
            $cash = $globalPayment->destination;
            if ($cash->estado) {
                $cash->increment('saldo_actual', $expensePayment->payment);

                Log::info('Saldo de caja revertido por eliminación de ExpensePayment', [
                    'cash_id' => $cash->id,
                    'expense_payment_id' => $expensePayment->id,
                    'monto_revertido' => $expensePayment->payment,
                    'nuevo_saldo' => $cash->fresh()->saldo_actual,
                ]);
            }
        }
    }
}
