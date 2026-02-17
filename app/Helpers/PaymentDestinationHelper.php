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
     * ID format: "App\Models\BankAccount|{id}" para enviar directamente tipo + id
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
                        'id' => BankAccount::class . '|' . $row->id, // Formato: tipo|id
                        'type' => 'bank',
                        'destination_type' => BankAccount::class,
                        'destination_id' => $row->id,
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
     * ID format: "App\Models\Cash|{id}" para enviar directamente tipo + id
     * 
     * @return array|null
     */
    private static function getCash(): ?array
    {
        // Buscar cualquier caja abierta del sistema (no filtrar por usuario)
        $cash = Cash::where('estado', true)->first();

        if ($cash) {
            return [
                'id' => Cash::class . '|' . $cash->id, // Formato: tipo|id
                'type' => 'cash',
                'destination_type' => Cash::class,
                'destination_id' => $cash->id,
                'description' => $cash->reference_number
                    ? "CAJA GENERAL - {$cash->reference_number}"
                    : "CAJA GENERAL",
            ];
        }

        return null;
    }

    /**
     * Parsear valor del selector formato "destination_type|destination_id"
     * Ejemplo: "App\Models\Cash|1" o "App\Models\BankAccount|5"
     * 
     * @param string|null $destinationValue
     * @return array ['destination_type' => string, 'destination_id' => int]
     */
    public static function parseDestination(?string $destinationValue): array
    {
        if (empty($destinationValue)) {
            return [
                'destination_type' => null,
                'destination_id' => null,
            ];
        }

        // Parsear formato "tipo|id"
        $parts = explode('|', $destinationValue, 2);

        if (count($parts) === 2 && class_exists($parts[0]) && is_numeric($parts[1])) {
            return [
                'destination_type' => $parts[0],
                'destination_id' => (int) $parts[1],
            ];
        }

        // Formato inválido
        return [
            'destination_type' => null,
            'destination_id' => null,
        ];
    }
}
