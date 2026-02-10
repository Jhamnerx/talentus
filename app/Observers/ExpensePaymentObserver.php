<?php

namespace App\Observers;

use App\Models\ExpensePayment;
use App\Models\Cash;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Log;

class ExpensePaymentObserver
{
    /**
     * Handle the ExpensePayment "created" event.
     * @deprecated Sistema deprecado - mantener por compatibilidad
     */
    public function created(ExpensePayment $expensePayment): void {}


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
        // Método deprecado - ya no actualiza registros globales
        if ($expensePayment->isDirty('payment')) {
            Log::info('ExpensePayment actualizado', [
                'id' => $expensePayment->id,
                'nuevo_monto' => $expensePayment->payment,
            ]);
        }
    }

    /**
     * Handle the ExpensePayment "deleted" event.
     */
    public function deleted(ExpensePayment $expensePayment): void
    {
        // Al eliminar el pago, revertir el saldo de caja si aplica
        $destination = $this->getDestination($expensePayment);

        if ($destination instanceof Cash && $destination->estado) {
            $destination->increment('saldo_actual', $expensePayment->payment);

            Log::info('Saldo de caja revertido por eliminación de ExpensePayment', [
                'cash_id' => $destination->id,
                'expense_payment_id' => $expensePayment->id,
                'monto_revertido' => $expensePayment->payment,
                'nuevo_saldo' => $destination->fresh()->saldo_actual,
            ]);
        }
    }
}
