<?php

namespace App\Traits;

use App\Models\Cash;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

/**
 * Trait con métodos auxiliares para gestión de caja
 * Inspirado en FinanceTrait de FactuPRO pero adaptado a Talentus
 */
trait CashHelperTrait
{
    /**
     * Obtener destinos de pago disponibles (Cajas + Cuentas Bancarias)
     * 
     * @return array
     */
    public function getPaymentDestinations(): array
    {
        $destinations = [];

        // Agregar caja activa del usuario si existe
        $activeCash = Cash::whereActive()->first();
        if ($activeCash) {
            $destinations[] = [
                'id' => 'cash',
                'cash_id' => $activeCash->id,
                'description' => 'CAJA GENERAL - ' . $activeCash->nombre,
                'type' => 'cash',
            ];
        }

        // Agregar cuentas bancarias activas
        if (class_exists(BankAccount::class)) {
            $bankAccounts = BankAccount::where('status', true)
                ->with('bank')
                ->get();

            foreach ($bankAccounts as $account) {
                $destinations[] = [
                    'id' => 'bank_account-' . $account->id,
                    'bank_account_id' => $account->id,
                    'description' => $account->bank->description . ' - ' . $account->description . ' (' . $account->currency_type_id . ')',
                    'type' => 'bank_account',
                ];
            }
        }

        return $destinations;
    }

    /**
     * Obtener caja activa del usuario autenticado
     * 
     * @return array|null
     */
    public function getCash(): ?array
    {
        $cash = Cash::whereActive()->first();

        if (!$cash) {
            return null;
        }

        return [
            'id' => 'cash',
            'cash_id' => $cash->id,
            'description' => 'CAJA GENERAL - ' . $cash->nombre,
        ];
    }

    /**
     * Formatear número para reportes
     * 
     * @param float $number
     * @param int $decimals
     * @return string
     */
    public function generalApplyNumberFormat(float $number, int $decimals = 2): string
    {
        return number_format($number, $decimals, '.', ',');
    }

    /**
     * Crear registro de pago en caja para un documento
     * 
     * @param mixed $payment Modelo de pago (Payments, etc.)
     * @param int $cashId ID de la caja
     * @param int|null $cashDocumentId ID del documento en caja
     * @param int|null $cashDocumentCreditId ID del crédito en caja
     * @return void
     */
    public function createCashDocumentPayment(
        $payment,
        int $cashId,
        ?int $cashDocumentId = null,
        ?int $cashDocumentCreditId = null
    ): void {
        \App\Models\CashDocumentPayment::create([
            'cash_id' => $cashId,
            'payment_id' => $payment->id,
            'cash_document_id' => $cashDocumentId,
            'cash_document_credit_id' => $cashDocumentCreditId,
        ]);
    }

    /**
     * Obtener tipos de pago disponibles
     * 
     * @return array
     */
    public function getCollectionPaymentTypes(): array
    {
        return [
            ['id' => 'recibo', 'description' => 'Recibos'],
            ['id' => 'venta', 'description' => 'Ventas'],
            ['id' => 'compra', 'description' => 'Compras'],
            ['id' => 'gasto', 'description' => 'Gastos'],
            ['id' => 'cotizacion', 'description' => 'Cotizaciones'],
        ];
    }

    /**
     * Obtener tipos de destino para pagos
     * 
     * @return array
     */
    public function getCollectionDestinationTypes(): array
    {
        $destinations = [];

        // Caja General
        $activeCash = Cash::whereActive()->first();
        if ($activeCash) {
            $destinations[] = [
                'id' => 'cash',
                'description' => 'Caja General',
                'type' => 'cash',
            ];
        }

        // Cuentas Bancarias
        if (class_exists(BankAccount::class)) {
            $destinations[] = [
                'id' => 'bank_account',
                'description' => 'Cuentas Bancarias',
                'type' => 'bank_account',
            ];
        }

        return $destinations;
    }

    /**
     * Verificar si existe caja activa para el usuario
     * 
     * @return bool
     */
    public function hasActiveCash(): bool
    {
        return Cash::whereActive()->exists();
    }

    /**
     * Obtener saldo actual de la caja activa
     * 
     * @return float
     */
    public function getActiveCashBalance(): float
    {
        $cash = Cash::whereActive()->first();
        return $cash ? $cash->saldo_actual : 0.00;
    }

    /**
     * Calcular total de ingresos de una caja
     * 
     * @param Cash $cash
     * @return float
     */
    public function calculateCashIncome(Cash $cash): float
    {
        $totales = $cash->calcularTotales();
        return $totales['ingresos'];
    }

    /**
     * Calcular total de egresos de una caja
     * 
     * @param Cash $cash
     * @return float
     */
    public function calculateCashExpense(Cash $cash): float
    {
        $totales = $cash->calcularTotales();
        return $totales['egresos'];
    }

    /**
     * Verificar si un documento está asociado a una caja
     * 
     * @param string $documentType Tipo: 'recibo', 'venta', 'compra', etc.
     * @param int $documentId ID del documento
     * @return bool
     */
    public function isDocumentInCash(string $documentType, int $documentId): bool
    {
        return \App\Models\CashDocument::where($documentType . '_id', $documentId)->exists();
    }

    /**
     * Obtener caja donde está registrado un documento
     * 
     * @param string $documentType
     * @param int $documentId
     * @return Cash|null
     */
    public function getCashByDocument(string $documentType, int $documentId): ?Cash
    {
        $cashDocument = \App\Models\CashDocument::where($documentType . '_id', $documentId)->first();
        return $cashDocument ? $cashDocument->cash : null;
    }
}
