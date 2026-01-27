<?php

namespace App\Traits;

use App\Models\Cash;
use App\Models\BankAccount;
use App\Models\GlobalPayment;

trait FinanceTrait
{
    /**
     * Crear GlobalPayment automáticamente cuando se crea un pago
     */
    public function createGlobalPayment($payment, $destination_type, $destination_id)
    {
        GlobalPayment::create([
            'destination_id' => $destination_id,
            'destination_type' => $destination_type,
            'payment_id' => $payment->id,
            'payment_type' => get_class($payment),
            'user_id' => auth()->id(),
            'empresa_id' => session('empresa'),
        ]);
    }

    /**
     * Obtener caja abierta del usuario autenticado
     */
    public function getCashOpened()
    {
        return Cash::where('user_id', auth()->id())
            ->where('estado', 1)
            ->first();
    }

    /**
     * Obtener todos los destinos disponibles (Cajas + Cuentas Bancarias)
     */
    public function getPaymentDestinations()
    {
        $destinations = collect();

        // Caja del usuario
        $cash = $this->getCashOpened();
        if ($cash) {
            $destinations->push([
                'id' => 'cash',
                'cash_id' => $cash->id,
                'type' => Cash::class,
                'description' => "CAJA - {$cash->nombre}",
                'saldo' => $cash->saldo_actual
            ]);
        }

        // Cuentas bancarias activas
        $bankAccounts = BankAccount::with('bank')
            ->where('status', 1)
            ->where('show_in_documents', 1)
            ->get();

        foreach ($bankAccounts as $account) {
            $destinations->push([
                'id' => $account->id,
                'type' => BankAccount::class,
                'description' => "{$account->bank->description} - {$account->currency_name} - {$account->number}",
                'saldo' => $account->initial_balance
            ]);
        }

        return $destinations;
    }

    /**
     * Obtener destino específico desde el ID
     */
    public function getDestinationRecord($destinationId)
    {
        if ($destinationId === 'cash') {
            $cash = $this->getCashOpened();
            return [
                'destination_id' => $cash->id,
                'destination_type' => Cash::class,
            ];
        }

        // Es una cuenta bancaria
        return [
            'destination_id' => $destinationId,
            'destination_type' => BankAccount::class,
        ];
    }

    /**
     * Eliminar GlobalPayment asociado a un pago
     */
    public function deleteGlobalPayment($payment)
    {
        GlobalPayment::where('payment_id', $payment->id)
            ->where('payment_type', get_class($payment))
            ->delete();
    }
}
