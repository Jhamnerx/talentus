<?php

namespace App\Http\Resources;

use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * MovementCollection - Colección optimizada para miles de registros
 * 
 * Características:
 * - Balance acumulado en memoria (no en blade)
 * - Conversión automática USD → PEN
 * - calculateResiduary() para balance entre páginas
 * - Performance optimizado para +1000 registros
 * 
 * Colección optimizada usando Payments directamente
 */
class MovementCollection extends ResourceCollection
{
    /**
     * Balance acumulado estático para mantener entre registros
     */
    protected static $balance = 0;

    /**
     * Saldo residual de páginas anteriores (para paginación)
     */
    protected static $residuary = 0;

    /**
     * Tipo de cambio por defecto USD → PEN
     */
    protected static $defaultExchangeRate = 3.75;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        // Calcular saldo residual de páginas anteriores
        $this->calculateResiduary($request);

        // Transformar cada registro
        return $this->collection->transform(function (Payments $row, $key) {
            return $this->transformRow($row, $key);
        })->toArray();
    }

    /**
     * Transformar un registro individual
     *
     * @param Payments $row
     * @param int $key
     * @return array
     */
    protected function transformRow(Payments $row, int $key): array
    {
        $index = $key + 1;

        // Obtener monto y convertir si es necesario
        $amount = $this->calculateAmount($row);

        // Actualizar balance acumulado
        $this->updateBalance($row, $amount);

        // Determinar input/output
        [$input, $output] = $this->getInputOutput($row->type_movement, $amount);

        // Obtener fecha formateada
        $dateTime = $this->getFormattedDateTime($row);

        return [
            'index' => $index,
            'id' => $row->id,

            // Fecha y hora
            'date_of_payment' => $dateTime,
            'date_time' => $dateTime, // Alias para compatibilidad con movimientos
            'created_at' => $row->created_at->format('d/m/Y H:i'),

            // Documento
            'document_type' => $this->getDocumentType($row),
            'document_number' => $row->document_number,
            'number_full' => $this->getNumberFull($row),

            // Persona (cliente/proveedor)
            'person_name' => $row->person_name,
            'person_number' => $this->getPersonNumber($row),

            // Destino (Caja/Banco)
            'destination_id' => $row->destination_id,
            'destination_description' => $row->destination_description,
            'destination_type' => class_basename($row->destination_type),
            'destination_name' => $this->getDestinationName($row),
            'destination_cci' => $this->getDestinationCCI($row),

            // Método de pago
            'payment_method' => $row->payment?->paymentMethod?->description ?? '-',
            'reference' => $row->payment?->numero_operacion ?? '-',

            // Montos
            'currency_type_id' => $this->getCurrencyType($row),
            'original_amount' => number_format($row->monto, 2, '.', ''),
            'amount_pen' => number_format($amount, 2, '.', ''),
            'payment' => $amount, // Monto del pago para vista de movimientos
            'input' => $input,
            'output' => $output,
            'balance' => number_format(self::$balance, 2, '.', ''),
            'residuary' => self::$balance, // Balance acumulado

            // Tipo de movimiento
            'type_movement' => $row->type_movement,
            'instance_type' => $row->payment_type_description,
            'instance_type_description' => $row->payment_type_description, // Alias para compatibilidad

            // Usuario
            'user_id' => $row->user_id,
            'user_name' => $row->user?->name ?? '-',

            // Metadata adicional
            'payment_class' => $row->payment_type ? class_basename($row->payment_type) : '-',
        ];
    }

    /**
     * Calcular monto en PEN (convertir si es USD)
     *
     * @param Payments $row
     * @return float
     */
    protected function calculateAmount(Payments $row): float
    {
        $amount = $row->monto;

        // Obtener tipo de cambio del documento/pago
        $exchangeRate = $this->getExchangeRate($row);

        // Si es USD, convertir a PEN
        if ($this->getCurrencyType($row) === 'USD') {
            $amount *= $exchangeRate;
        }

        return $amount;
    }

    /**
     * Obtener tipo de cambio del documento
     *
     * @param Payments $row
     * @return float
     */
    protected function getExchangeRate(Payments $row): float
    {
        // Leer directamente de Payments (más eficiente, evita N+1)
        if (isset($row->tipo_cambio) && $row->tipo_cambio > 0) {
            return (float) $row->tipo_cambio;
        }

        // Fallback: leer del paymentable si no tiene tipo_cambio
        if ($row->payment && $row->payment->paymentable) {
            $paymentable = $row->payment->paymentable;

            // Buscar campo tipo_cambio o exchange_rate_sale
            if (isset($paymentable->tipo_cambio)) {
                return (float) $paymentable->tipo_cambio;
            }

            if (isset($paymentable->exchange_rate_sale)) {
                return (float) $paymentable->exchange_rate_sale;
            }
        }

        // Retornar tipo de cambio por defecto
        return self::$defaultExchangeRate;
    }

    /**
     * Actualizar balance acumulado
     *
     * @param Payments $row
     * @param float $amount
     * @return void
     */
    protected function updateBalance(Payments $row, float $amount): void
    {
        if ($row->type_movement === 'INGRESO') {
            self::$balance += $amount;
        } else {
            self::$balance -= $amount;
        }
    }

    /**
     * Calcular saldo residual de páginas anteriores (para paginación)
     *
     * @param Request $request
     * @return void
     */
    public function calculateResiduary(Request $request): void
    {
        $currentPage = $request->input('page', 1);

        // Si no es la primera página, calcular saldo de páginas anteriores
        if ($currentPage > 1) {
            $perPage = $request->input('per_page', 15);
            $previousRecords = ($currentPage - 1) * $perPage;

            // Obtener los mismos filtros aplicados
            $query = $this->buildQueryWithFilters($request);

            // Obtener registros de páginas anteriores
            $previousData = $query->limit($previousRecords)->get();

            // Calcular balance de páginas anteriores
            $ingresos = 0;
            $egresos = 0;

            foreach ($previousData as $record) {
                $amount = $this->calculateAmount($record);

                if ($record->type_movement === 'INGRESO') {
                    $ingresos += $amount;
                } else {
                    $egresos += $amount;
                }
            }

            self::$residuary = $ingresos - $egresos;
            self::$balance = self::$residuary;
        } else {
            // Primera página, resetear balance
            self::$residuary = 0;
            self::$balance = 0;
        }
    }

    /**
     * Construir query con los mismos filtros de la petición
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildQueryWithFilters(Request $request)
    {
        $query = Payments::query()
            ->with(['paymentable', 'destination', 'user'])
            ->latest('created_at');

        // Aplicar filtros (los mismos del componente Livewire)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('payment.paymentable', function ($subQ) use ($search) {
                    $subQ->where('numero', 'like', "%{$search}%")
                        ->orWhere('numero_comprobante', 'like', "%{$search}%");
                });
            });
        }

        if ($tipo = $request->input('tipo_filter')) {
            if ($tipo === 'ingreso') {
                $query->ingresos();
            } elseif ($tipo === 'egreso') {
                $query->egresos();
            }
        }

        if ($destinationType = $request->input('destination_type')) {
            if ($destinationType === 'cash') {
                $query->whereCashDestination();
            } elseif ($destinationType === 'bank') {
                $query->whereBankDestination();
            }
        }

        if ($cashId = $request->input('cash_id')) {
            $query->byCash($cashId);
        }

        if ($bankAccountId = $request->input('bank_account_id')) {
            $query->byDestinationType(\App\Models\BankAccount::class)
                ->where('destination_id', $bankAccountId);
        }

        if ($from = $request->input('from')) {
            if ($to = $request->input('to')) {
                $query->whereDateBetween($from, $to);
            }
        }

        return $query;
    }

    /**
     * Obtener input/output formateado
     *
     * @param string|null $typeMovement
     * @param float $amount
     * @return array
     */
    protected function getInputOutput(?string $typeMovement, float $amount): array
    {
        if ($typeMovement === 'INGRESO') {
            return [
                number_format($amount, 2, '.', ''),
                '-'
            ];
        }

        if ($typeMovement === 'EGRESO') {
            return [
                '-',
                number_format($amount, 2, '.', '')
            ];
        }

        // Si type_movement es null o valor inesperado, retornar guiones
        return ['-', '-'];
    }

    /**
     * Obtener fecha formateada
     *
     * @param Payments $row
     * @return string
     */
    protected function getFormattedDateTime(Payments $row): string
    {
        // Intentar obtener fecha del paymentable
        if ($row->payment && $row->payment->paymentable) {
            $paymentable = $row->payment->paymentable;

            // Buscar campo fecha o date
            if (isset($paymentable->fecha)) {
                return Carbon::parse($paymentable->fecha)->format('d/m/Y H:i A');
            }

            if (isset($paymentable->created_at)) {
                return $paymentable->created_at->format('d/m/Y H:i A');
            }
        }

        return $row->created_at->format('d/m/Y H:i A');
    }

    /**
     * Obtener tipo de documento
     *
     * @param Payments $row
     * @return string
     */
    protected function getDocumentType(Payments $row): string
    {
        if ($row->payment && $row->payment->paymentable) {
            $paymentable = $row->payment->paymentable;

            // Para Recibos
            if (method_exists($paymentable, 'tipo_documento')) {
                return $paymentable->tipo_documento?->descripcion ?? 'RECIBO';
            }

            // Para Ventas
            if (isset($paymentable->tipo_comprobante)) {
                return strtoupper($paymentable->tipo_comprobante);
            }
        }

        return $row->instance_type_description;
    }

    /**
     * Obtener número completo del documento
     *
     * @param Payments $row
     * @return string
     */
    protected function getNumberFull(Payments $row): string
    {
        if ($row->payment && $row->payment->paymentable) {
            $paymentable = $row->payment->paymentable;

            // Número de documento
            if (isset($paymentable->numero)) {
                return $paymentable->numero;
            }

            // Serie + número
            if (isset($paymentable->serie) && isset($paymentable->correlativo)) {
                return "{$paymentable->serie}-{$paymentable->correlativo}";
            }
        }

        return $row->document_number;
    }

    /**
     * Obtener número de documento de la persona
     *
     * @param Payments $row
     * @return string
     */
    protected function getPersonNumber(Payments $row): string
    {
        if ($row->payment && $row->payment->paymentable) {
            $paymentable = $row->payment->paymentable;

            // Cliente
            if (isset($paymentable->cliente)) {
                return $paymentable->cliente->numero_documento ?? '-';
            }

            // Proveedor
            if (isset($paymentable->proveedor)) {
                return $paymentable->proveedor->numero_documento ?? '-';
            }
        }

        return '-';
    }

    /**
     * Obtener nombre completo del destino
     *
     * @param Payments $row
     * @return string
     */
    protected function getDestinationName(Payments $row): string
    {
        if ($row->destination) {
            if (isset($row->destination->nombre)) {
                return $row->destination->nombre;
            }

            if (isset($row->destination->description)) {
                return $row->destination->description;
            }
        }

        return $row->destination_description;
    }

    /**
     * Obtener CCI de cuenta bancaria (si aplica)
     *
     * @param Payments $row
     * @return string
     */
    protected function getDestinationCCI(Payments $row): string
    {
        if ($row->destination && class_basename($row->destination_type) === 'BankAccount') {
            return $row->destination->cci ?? '-';
        }

        return '-';
    }

    /**
     * Obtener tipo de moneda
     *
     * @param Payments $row
     * @return string
     */
    protected function getCurrencyType(Payments $row): string
    {
        // Leer directamente de Payments (más eficiente, evita N+1)
        if (isset($row->divisa) && $row->divisa) {
            return strtoupper($row->divisa);
        }

        // Fallback: leer del paymentable si no tiene divisa
        if ($row->paymentable) {
            $paymentable = $row->paymentable;

            if (isset($paymentable->divisa)) {
                return strtoupper($paymentable->divisa);
            }

            if (isset($paymentable->moneda)) {
                return strtoupper($paymentable->moneda);
            }

            if (isset($paymentable->currency_type_id)) {
                return strtoupper($paymentable->currency_type_id);
            }
        }

        return 'PEN'; // Por defecto soles
    }

    /**
     * Resetear balance estático (útil para tests)
     *
     * @return void
     */
    public static function resetBalance(): void
    {
        self::$balance = 0;
        self::$residuary = 0;
    }

    /**
     * Obtener balance actual
     *
     * @return float
     */
    public static function getCurrentBalance(): float
    {
        return self::$balance;
    }

    /**
     * Establecer tipo de cambio por defecto
     *
     * @param float $rate
     * @return void
     */
    public static function setDefaultExchangeRate(float $rate): void
    {
        self::$defaultExchangeRate = $rate;
    }
}
