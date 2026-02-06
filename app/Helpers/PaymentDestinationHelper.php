<?php

namespace App\Helpers;

use App\Models\Cash;
use App\Models\BankAccount;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PaymentDestinationHelper
{
    /**
     * Obtener destinos de pago disponibles: Cuentas Bancarias + Caja Abierta
     * Basado en FactuPRO: modules/Finance/Traits/FinanceTrait.php
     * 
     * @return Collection
     */
    public static function getPaymentDestinations(): Collection
    {
        try {
            $bankAccounts = self::getBankAccounts();
            $cash = self::getCash();

            if ($cash) {
                $bankAccounts->push($cash);
            }

            return $bankAccounts;
        } catch (\Exception $e) {
            // En caso de error, devolver collection vacía
            return collect([]);
        }
    }

    /**
     * Obtener cuentas bancarias formateadas
     * 
     * @return Collection
     */
    private static function getBankAccounts(): Collection
    {
        try {
            return BankAccount::with('bank')
                ->whereHas('bank') // Solo cuentas con banco válido
                ->get()
                ->map(function ($row) {
                    $banco = $row->bank->description ?? 'Banco';
                    $moneda = $row->currency_type_id ?? 'PEN';
                    $descripcion = $row->description ?? $row->number ?? 'Cuenta';

                    return [
                        'id' => $row->id,
                        'type' => 'bank',
                        'cash_id' => null,
                        'bank_account_id' => $row->id,
                        'description' => "{$banco} - {$moneda} - {$descripcion}",
                    ];
                });
        } catch (\Exception $e) {
            // Si no hay bancos o error, devolver collection vacía
            return collect([]);
        }
    }

    /**
     * Obtener caja abierta general del negocio (no por usuario)
     * En Talentus la caja es compartida por todos los usuarios
     * 
     * @return array|null
     */
    private static function getCash(): ?array
    {
        // Buscar cualquier caja abierta (no filtrar por usuario)
        $cash = Cash::where('estado', true)->first();

        if ($cash) {
            return [
                'id' => 'cash',
                'type' => 'cash',
                'cash_id' => $cash->id,
                'bank_account_id' => null,
                'description' => $cash->reference_number
                    ? "CAJA GENERAL - {$cash->reference_number}"
                    : "CAJA GENERAL",
            ];
        }

        return null;
    }

    /**
     * Obtener destino por ID
     * 
     * @param string|int $destinationId
     * @return array
     */
    public static function getDestinationRecord($destinationId): array
    {
        if ($destinationId === 'cash') {
            $cash = self::getCash();
            return [
                'destination_id' => $cash['cash_id'] ?? null,
                'destination_type' => Cash::class,
            ];
        }

        // Es una cuenta bancaria
        return [
            'destination_id' => $destinationId,
            'destination_type' => BankAccount::class,
        ];
    }
}
