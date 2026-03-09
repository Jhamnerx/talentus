<?php

namespace App\Traits;

use App\Models\BankAccount;
use App\Models\Cash;
use App\Models\Payments;
use Illuminate\Support\Collection;

/**
 * FinanceTrait - Funciones financieras para controladores de reportes
 * 
 * Basado en: FactuPRO modules/Finance/Traits/FinanceTrait.php
 * 
 * USO: Incluir en CONTROLADORES que generan reportes de caja/bancos
 * 
 * Ejemplo:
 * class CashReportController extends Controller {
 *     use FinanceTrait;
 *     
 *     public function index(Request $request) {
 *         $payments = Payments::all();
 *         $totalPEN = $this->calculateTotalCurrencyType($payments, 'PEN');
 *         $totalUSD = $this->calculateTotalCurrencyType($payments, 'USD');
 *     }
 * }
 */
trait FinanceTrait
{
    /**
     * Calcular total de pagos con conversión de moneda
     * 
     * Lógica FactuPRO: modules/Finance/Traits/FinanceTrait.php línea 65
     * - Si el documento está en USD y se pide PEN → multiplicar por tipo_cambio
     * - Si el documento está en PEN y se pide USD → dividir por tipo_cambio
     * - Si las monedas coinciden → usar monto directo
     * 
     * @param Collection $payments Colección de Payments con relación ->paymentable (Ventas/Recibos)
     * @param string $requestCurrencyTypeId Moneda solicitada: 'PEN' o 'USD'
     * @return float Total calculado en la moneda solicitada
     */
    public function calculateTotalCurrencyType($payments, string $requestCurrencyTypeId): float
    {
        $total = 0;

        foreach ($payments as $payment) {
            // Obtener el documento relacionado (Ventas o Recibos)
            $record = $payment->paymentable;

            if (!$record) {
                continue;
            }

            // Obtener datos de moneda del documento
            $documentCurrency = $record->divisa ?? 'PEN'; // divisa del documento
            $exchangeRate = $record->tipo_cambio ?? 1; // tipo de cambio del documento
            $amount = $payment->monto;

            // FactuPRO: modules/Finance/Traits/FinanceTrait.php líneas 68-74
            if ($documentCurrency === 'USD' && $requestCurrencyTypeId === 'PEN') {
                // Documento en USD, se pide PEN → multiplicar por tipo_cambio
                $total += $amount * $exchangeRate;
            } elseif ($documentCurrency === 'PEN' && $requestCurrencyTypeId === 'USD') {
                // Documento en PEN, se pide USD → dividir por tipo_cambio
                $total += ($exchangeRate > 0) ? ($amount / $exchangeRate) : 0;
            } else {
                // Misma moneda → usar monto directo
                $total += $amount;
            }
        }

        return round($total, 2);
    }

    /**
     * Calcular balance de caja con conversión de moneda
     * 
     * FactuPRO: modules/Finance/Traits/FinanceTrait.php línea 142
     * Suma ingresos y resta egresos, convirtiendo a la moneda solicitada
     * 
     * @param int $cashId ID de la caja
     * @param string $currencyTypeId Moneda solicitada: 'PEN' o 'USD'
     * @return float Balance en la moneda solicitada
     */
    public function getBalanceByCash(int $cashId, string $currencyTypeId = 'PEN'): float
    {
        $payments = \App\Models\Payments::where('destination_type', Cash::class)
            ->where('destination_id', $cashId)
            ->with('paymentable')
            ->get();

        $income = 0; // Ingresos
        $expense = 0; // Egresos

        foreach ($payments as $payment) {

            if (!$payment) {
                continue;
            }

            // Calcular monto convertido a la moneda solicitada
            $record = $payment->paymentable;
            $documentCurrency = $record->divisa ?? 'PEN';
            $exchangeRate = $record->tipo_cambio ?? 1;
            $amount = $payment->monto;

            // Convertir a la moneda solicitada
            if ($documentCurrency === 'USD' && $currencyTypeId === 'PEN') {
                $convertedAmount = $amount * $exchangeRate;
            } elseif ($documentCurrency === 'PEN' && $currencyTypeId === 'USD') {
                $convertedAmount = ($exchangeRate > 0) ? ($amount / $exchangeRate) : 0;
            } else {
                $convertedAmount = $amount;
            }

            // Sumar o restar según tipo de movimiento
            if ($payment->type_movement === 'INGRESO') {
                $income += $convertedAmount;
            } else {
                $expense += $convertedAmount;
            }
        }

        return round($income - $expense, 2);
    }

    /**
     * Calcular balance de cuenta bancaria con conversión de moneda
     * 
     * Similar a getBalanceByCash pero para cuentas bancarias
     * 
     * @param int $bankAccountId ID de la cuenta bancaria
     * @param string $currencyTypeId Moneda solicitada: 'PEN' o 'USD'
     * @return float Balance en la moneda solicitada
     */
    public function getBalanceByBankAccount(int $bankAccountId, string $currencyTypeId = 'PEN'): float
    {
        $payments = \App\Models\Payments::where('destination_type', BankAccount::class)
            ->where('destination_id', $bankAccountId)
            ->with('paymentable')
            ->get();

        $income = 0;
        $expense = 0;

        foreach ($payments as $payment) {

            if (!$payment) {
                continue;
            }

            // Calcular monto convertido
            $record = $payment->paymentable;
            $documentCurrency = $record->divisa ?? 'PEN';
            $exchangeRate = $record->tipo_cambio ?? 1;
            $amount = $payment->monto;

            if ($documentCurrency === 'USD' && $currencyTypeId === 'PEN') {
                $convertedAmount = $amount * $exchangeRate;
            } elseif ($documentCurrency === 'PEN' && $currencyTypeId === 'USD') {
                $convertedAmount = ($exchangeRate > 0) ? ($amount / $exchangeRate) : 0;
            } else {
                $convertedAmount = $amount;
            }

            if ($payment->type_movement === 'INGRESO') {
                $income += $convertedAmount;
            } else {
                $expense += $convertedAmount;
            }
        }

        return round($income - $expense, 2);
    }

    /**
     * Obtener lista de destinos de pago (Cajas + Cuentas Bancarias)
     * 
     * FactuPRO: modules/Finance/Traits/FinanceTrait.php línea 29
     * Usado para llenar selects en formularios
     * 
     * @return array ['cash' => Collection, 'banks' => Collection]
     */
    public function getPaymentDestinations(): array
    {
        return [
            'cash' => Cash::where('estado', true)->get(),
            'banks' => BankAccount::where('status', true)->get(),
        ];
    }

    /**
     * Obtener destino específico por ID
     * 
     * @param mixed $destinationId ID o 'cash'
     * @return array ['destination_id' => int, 'destination_type' => string, 'destination' => Model]
     */
    public function getDestinationData($destinationId): array
    {
        if ($destinationId === 'cash') {
            $cash = Cash::where('estado', true)->first();
            return [
                'destination_id' => $cash?->id,
                'destination_type' => Cash::class,
                'destination' => $cash,
            ];
        }

        $bankAccount = BankAccount::find($destinationId);
        return [
            'destination_id' => $bankAccount?->id,
            'destination_type' => BankAccount::class,
            'destination' => $bankAccount,
        ];
    }
}
