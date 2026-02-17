<?php

namespace App\Livewire\Admin\Finanzas\Movimientos;

use App\Models\Cash;
use App\Models\Payments;
use App\Models\BankAccount;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MovimientosExport;
use App\Livewire\Admin\Cobros\Payment;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;
    use WireUiActions;

    public $search = '';
    public $from = '';
    public $to = '';
    public $type_movement = ''; // all, INGRESO, EGRESO
    public $destination_type = ''; // all, cash, bank, sin_destino
    public $cash_id = '';
    public $bank_account_id = '';

    // Nuevo selector de periodo
    public $period_type = 'month'; // month, month_range, date, date_range
    public $month = '';
    public $month_start = '';
    public $month_end = '';
    public $ultima_apertura_caja = false;

    #[On('render')]
    public function render()
    {
        $query = Payments::query()
            ->with([
                'paymentable',
                'destination',
                'user',
                'bankAccount',
            ])
            ->latest('created_at');

        // Búsqueda por texto
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_operacion', 'like', '%' . $this->search . '%');
            });
        }

        // Filtro por tipo de movimiento
        if ($this->type_movement === 'INGRESO') {
            $query->ingresos();
        } elseif ($this->type_movement === 'EGRESO') {
            $query->egresos();
        }

        // Filtro por tipo de destino
        if ($this->destination_type === 'cash') {
            $query->byDestinationType('App\\Models\\Cash');
        } elseif ($this->destination_type === 'bank') {
            $query->byDestinationType('App\\Models\\BankAccount');
        } elseif ($this->destination_type === 'sin_destino') {
            $query->whereNull('destination_id');
        }

        // Filtro por caja específica
        if ($this->cash_id) {
            $query->byCash($this->cash_id);
        }

        // Filtro por cuenta bancaria específica
        if ($this->bank_account_id) {
            $query->byBankAccount($this->bank_account_id);
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereDateBetween($this->from, $this->to);
        }

        // Obtener todos los movimientos (sin paginación para calcular saldo acumulado correctamente)
        $allMovements = $query->get();

        // Procesar movimientos incluyendo saldos iniciales y saldo acumulado
        $processedMovements = $this->processMovements($allMovements);

        // Ahora sí paginar los resultados procesados
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $perPage = 50;
        $movimientos = new \Illuminate\Pagination\LengthAwarePaginator(
            $processedMovements->forPage($currentPage, $perPage),
            $processedMovements->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Calcular totales
        $totales = $this->calcularTotalesFromProcessed($processedMovements);

        $cajas = Cash::all();
        $cuentasBancarias = BankAccount::where('status', true)->get();

        return view('livewire.admin.finanzas.movimientos.index', compact(
            'movimientos',
            'totales',
            'cajas',
            'cuentasBancarias'
        ));
    }

    private function calcularTotales($query)
    {
        // Clonar query para no afectar paginación
        $allRecords = (clone $query)->get();

        $ingresos = 0;
        $egresos = 0;

        foreach ($allRecords as $record) {
            $monto = $record->monto;
            if ($record->type_movement === 'INGRESO') {
                $ingresos += $monto;
            } else {
                $egresos += $monto;
            }
        }

        return [
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'saldo' => $ingresos - $egresos,
        ];
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime('-7 days'));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime('-1 month'));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function mount()
    {
        // Inicializar con mes actual por defecto
        $this->month = Carbon::now()->format('Y-m');
        $this->setPeriodDates();
    }

    public function updatedPeriodType()
    {
        $this->resetPage();
        $this->setPeriodDates();
    }

    public function updatedMonth()
    {
        $this->resetPage();
        $this->setPeriodDates();
    }

    public function updatedMonthStart()
    {
        $this->resetPage();
        $this->setPeriodDates();
    }

    public function updatedMonthEnd()
    {
        $this->resetPage();
        $this->setPeriodDates();
    }

    public function updatedFrom()
    {
        $this->resetPage();
    }

    public function updatedTo()
    {
        $this->resetPage();
    }

    private function setPeriodDates()
    {
        switch ($this->period_type) {
            case 'month':
                if ($this->month) {
                    $date = Carbon::parse($this->month . '-01');
                    $this->from = $date->startOfMonth()->format('Y-m-d');
                    $this->to = $date->copy()->endOfMonth()->format('Y-m-d');
                }
                break;

            case 'month_range':
                if ($this->month_start && $this->month_end) {
                    $dateStart = Carbon::parse($this->month_start . '-01');
                    $dateEnd = Carbon::parse($this->month_end . '-01');
                    $this->from = $dateStart->startOfMonth()->format('Y-m-d');
                    $this->to = $dateEnd->endOfMonth()->format('Y-m-d');
                }
                break;

            case 'date':
                // El usuario ingresa directamente en $from
                if ($this->from) {
                    $this->to = $this->from;
                }
                break;

            case 'date_range':
                // El usuario ingresa directamente en $from y $to
                break;
        }
    }

    /**
     * Procesar movimientos incluyendo saldos iniciales de cajas y calcular saldo acumulado
     */
    private function processMovements($payments)
    {
        $result = collect();
        $saldoAcumulado = 0;

        // 1. Si hay filtro por caja específica, agregar saldo inicial
        if ($this->cash_id) {
            $cash = Cash::find($this->cash_id);

            if ($cash) {
                // Saldo inicial PEN
                if ($cash->saldo_inicial > 0) {
                    $saldoAcumulado += $cash->saldo_inicial;
                    $result->push([
                        'index' => $result->count() + 1,
                        'date_time' => $cash->fecha_apertura->format('d-m-Y h:i A'),
                        'person_name' => '-',
                        'person_document' => '',
                        'document_type' => 'Saldo inicial - ' . $cash->nombre,
                        'document_number' => '',
                        'detalle' => '',
                        'moneda' => 'PEN',
                        'tipo' => 'INGRESO',
                        'ingresos' => $cash->saldo_inicial,
                        'gastos' => 0,
                        'saldo' => $saldoAcumulado,
                    ]);
                }

                // Saldo inicial USD (si existe)
                if (isset($cash->saldo_inicial_usd) && $cash->saldo_inicial_usd > 0) {
                    $result->push([
                        'index' => $result->count() + 1,
                        'date_time' => $cash->fecha_apertura->format('d-m-Y h:i A'),
                        'person_name' => '-',
                        'person_document' => '',
                        'document_type' => 'Saldo inicial USD - ' . $cash->nombre,
                        'document_number' => '',
                        'detalle' => '',
                        'moneda' => 'USD',
                        'tipo' => 'INGRESO',
                        'ingresos' => $cash->saldo_inicial_usd,
                        'gastos' => 0,
                        'saldo' => $cash->saldo_inicial_usd,
                    ]);
                }
            }
        }

        // 2. Procesar cada pago y calcular saldo acumulado
        foreach ($payments as $payment) {
            $paymentable = $payment->paymentable;

            $personName = '-';
            $personDocument = '';
            $documentType = $payment->description ?? 'Pago';
            $documentNumber = $payment->numero ?? '';
            $detalle = '';
            $tipo = $payment->type_movement === 'INGRESO' ? 'CPE' : 'EGRESO';

            // Extraer información según el tipo de documento
            if ($paymentable) {
                $modelClass = get_class($paymentable);

                switch ($modelClass) {
                    case 'App\\Models\\Recibos':
                        $cliente = $paymentable->clientes;
                        $personName = $cliente->razon_social ?? '';
                        $personDocument = $cliente->numero_documento ?? '';
                        $documentType = 'RECIBO';
                        // Usar serie_numero ya concatenado o construirlo
                        $documentNumber = $paymentable->serie_numero ?? (($paymentable->serie ?? '') . '-' . ($paymentable->numero ?? ''));
                        break;

                    case 'App\\Models\\Ventas':
                        $venta = $paymentable;
                        $cliente = $venta->cliente;
                        $personName = $cliente->nombre_completo ?? $cliente->razon_social ?? '';
                        $personDocument = $cliente->numero_documento ?? '';

                        // Obtener tipo de comprobante desde la relación
                        $tipoComprobante = $venta->tipoComprobante;
                        $documentType = $tipoComprobante ? strtoupper($tipoComprobante->descripcion ?? $tipoComprobante->name ?? 'VENTA') : 'VENTA';

                        // Usar serie_correlativo ya concatenado o construirlo
                        $documentNumber = $venta->serie_correlativo ?? (($venta->serie ?? '') . '-' . ($venta->correlativo ?? ''));
                        break;

                    case 'App\\Models\\ExpensePayment':
                        $expense = $paymentable->expense ?? null;
                        $supplier = $expense->supplier ?? null;
                        $personName = $supplier->name ?? 'Proveedor';
                        $documentType = 'GASTO';
                        $documentNumber = 'EXP-' . str_pad($paymentable->id, 6, '0', STR_PAD_LEFT);
                        $detalle = $expense->expense_reason->name ?? '';
                        break;

                    case 'App\\Models\\Compras':
                        $compra = $paymentable;
                        $proveedor = $compra->proveedor;
                        $personName = $proveedor->razon_social ?? $proveedor->nombre ?? '';
                        $personDocument = $proveedor->numero_documento ?? '';

                        // Tipo de comprobante desde la relación
                        $tipoComprobante = $compra->tipoComprobante;
                        $documentType = $tipoComprobante->name ?? 'Compra';
                        $documentNumber = $compra->numero_comprobante ?? (($compra->serie ?? '') . '-' . ($compra->correlativo ?? ''));
                        $detalle = $tipoComprobante->descripcion ?? '';
                        break;
                }
            }

            // Calcular saldo acumulado
            $monto = $payment->monto;
            $ingresos = 0;
            $gastos = 0;

            if ($payment->type_movement === 'INGRESO') {
                $saldoAcumulado += $monto;
                $ingresos = $monto;
            } else {
                $saldoAcumulado -= $monto;
                $gastos = $monto;
            }

            $result->push([
                'index' => $result->count() + 1,
                'date_time' => $payment->created_at->format('d-m-Y h:i A'),
                'person_name' => $personName,
                'person_document' => $personDocument,
                'document_type' => $documentType,
                'document_number' => $documentNumber,
                'detalle' => $detalle,
                'moneda' => $payment->divisa ?? 'PEN',
                'tipo' => $tipo,
                'ingresos' => $ingresos,
                'gastos' => $gastos,
                'saldo' => $saldoAcumulado,
                'payment_id' => $payment->id,
                'destination_id' => $payment->destination_id,
            ]);
        }

        return $result;
    }

    /**
     * Calcular totales desde movimientos procesados
     */
    private function calcularTotalesFromProcessed($processedMovements)
    {
        $totalIngresos = 0;
        $totalGastos = 0;

        foreach ($processedMovements as $mov) {
            $totalIngresos += $mov['ingresos'] ?? 0;
            $totalGastos += $mov['gastos'] ?? 0;
        }

        return [
            'ingresos' => $totalIngresos,
            'gastos' => $totalGastos,
            'saldo' => $totalIngresos - $totalGastos,
        ];
    }

    public function export()
    {
        // Obtener los movimientos procesados sin paginación
        $allMovements = $this->getAllMovementsForExport();

        // Calcular totales de todos los movimientos
        $totales = $this->calcularTotalesFromProcessed($allMovements);

        // Preparar filtros para el export
        $filters = [
            'period_type' => $this->period_type,
            'month' => $this->month,
            'month_start' => $this->month_start,
            'month_end' => $this->month_end,
            'from' => $this->from,
            'to' => $this->to,
            'cash_id' => $this->cash_id,
            'type_movement' => $this->type_movement,
            'search' => $this->search,
        ];

        $filename = 'movimientos_' . now()->format('YmdHis') . '.xlsx';

        return (new \App\Exports\MovimientosExport($allMovements, $totales, $filters))
            ->download($filename);
    }

    protected function getAllMovementsForExport()
    {
        // Usar la misma lógica que processMovements() pero sin paginación
        $query = Payments::query()
            ->with([
                'paymentable',
                'destination',
            ])
            ->oldest('created_at')
            ->oldest('id');

        // Aplicar filtros de fecha
        if ($this->from && $this->to) {
            $query->whereDateBetween($this->from, $this->to);
        }

        // Filtro por tipo de movimiento
        if ($this->type_movement) {
            $query->where('type_movement', $this->type_movement);
        }

        // Filtro por destino (caja)
        if ($this->cash_id) {
            $query->where('destination_id', $this->cash_id)
                ->where('destination_type', Cash::class);
        }

        // Filtro por búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('paymentable', function ($subQuery) {
                    $subQuery->where('numero', 'like', "%{$this->search}%")
                        ->orWhere('numero_comprobante', 'like', "%{$this->search}%");
                });
            });
        }

        $payments = $query->get();

        // Obtener saldos iniciales si hay filtro por caja
        $saldos = [];
        if ($this->cash_id) {
            $cash = Cash::find($this->cash_id);
            if ($cash) {
                if ($cash->saldo_inicial_pen > 0) {
                    $saldos[] = [
                        'is_saldo_inicial' => true,
                        'index' => 0,
                        'date_time' => $this->from,
                        'person_name' => '*** SALDO INICIAL PEN ***',
                        'person_document' => '',
                        'document_type' => '',
                        'document_number' => '',
                        'detalle' => 'Apertura de Caja - ' . $cash->nombre,
                        'moneda' => 'PEN',
                        'tipo' => '',
                        'ingresos' => 0,
                        'gastos' => 0,
                        'saldo' => $cash->saldo_inicial_pen,
                        'payment_id' => null,
                        'destination_id' => $cash->id,
                    ];
                }
                if ($cash->saldo_inicial_usd > 0) {
                    $saldos[] = [
                        'is_saldo_inicial' => true,
                        'index' => 0,
                        'date_time' => $this->from,
                        'person_name' => '*** SALDO INICIAL USD ***',
                        'person_document' => '',
                        'document_type' => '',
                        'document_number' => '',
                        'detalle' => 'Apertura de Caja - ' . $cash->nombre,
                        'moneda' => 'USD',
                        'tipo' => '',
                        'ingresos' => 0,
                        'gastos' => 0,
                        'saldo' => $cash->saldo_inicial_usd,
                        'payment_id' => null,
                        'destination_id' => $cash->id,
                    ];
                }
            }
        }

        // Procesar pagos (misma lógica que processMovements())
        $saldoAcumulado = $this->cash_id ? ($saldos[0]['saldo'] ?? 0) : 0;

        foreach ($payments as $index => $payment) {
            $paymentable = $payment->paymentable;

            // Obtener información del cliente/proveedor
            $personName = '';
            $personDocument = '';
            $detalle = '';
            $documentType = '';
            $documentNumber = '';

            // (Aquí va la misma lógica que en processMovements() para extraer datos)
            if ($paymentable) {
                $detalle = $payment->detalle ?? $payment->description ?? '';
                $modelClass = get_class($paymentable);

                switch ($modelClass) {
                    case 'App\\Models\\Ventas':
                        $venta = $paymentable;
                        $cliente = $venta->cliente;
                        $personName = $cliente->nombre_completo ?? $cliente->razon_social ?? '';
                        $personDocument = $cliente->numero_documento ?? '';

                        // Obtener tipo de comprobante desde la relación
                        $tipoComprobante = $venta->tipoComprobante;
                        $documentType = $tipoComprobante ? strtoupper($tipoComprobante->descripcion ?? $tipoComprobante->name ?? 'VENTA') : 'VENTA';

                        // Usar serie_correlativo ya concatenado o construirlo
                        $documentNumber = $venta->serie_correlativo ?? (($venta->serie ?? '') . '-' . ($venta->correlativo ?? ''));
                        break;

                    case 'App\\Models\\ExpensePayment':
                        $expense = $paymentable->expense ?? null;
                        $supplier = $expense->supplier ?? null;
                        $personName = $supplier->name ?? 'Proveedor';
                        $documentType = 'GASTO';
                        $documentNumber = 'EXP-' . str_pad($paymentable->id, 6, '0', STR_PAD_LEFT);
                        $detalle = $expense->expense_reason->name ?? '';
                        break;

                    case 'App\\Models\\Compras':
                        $compra = $paymentable;
                        $proveedor = $compra->proveedor;
                        $personName = $proveedor->razon_social ?? $proveedor->nombre ?? '';
                        $personDocument = $proveedor->numero_documento ?? '';

                        $tipoComprobante = $compra->tipoComprobante;
                        $documentType = $tipoComprobante ? strtoupper($tipoComprobante->descripcion ?? $tipoComprobante->name ?? 'COMPRA') : 'COMPRA';
                        $documentNumber = $compra->numero_comprobante ?? (($compra->serie ?? '') . '-' . ($compra->correlativo ?? ''));
                        $detalle = $detalle ?: ($tipoComprobante->descripcion ?? '');
                        break;

                    case 'App\\Models\\Recibos':
                        $cliente = $paymentable->clientes;
                        $personName = $cliente->razon_social ?? '';
                        $personDocument = $cliente->numero_documento ?? '';
                        $documentType = 'RECIBO';
                        $documentNumber = $paymentable->serie_numero ?? (($paymentable->serie ?? '') . '-' . ($paymentable->numero ?? ''));
                        break;
                }
            }

            // Calcular saldo acumulado
            $monto = $payment->monto;
            $ingresos = 0;
            $gastos = 0;

            if ($payment->type_movement === 'INGRESO') {
                $saldoAcumulado += $monto;
                $ingresos = $monto;
            } else {
                $saldoAcumulado -= $monto;
                $gastos = $monto;
            }

            $saldos[] = [
                'index' => $index + 1,
                'date_time' => $payment->created_at->format('d-m-Y h:i A'),
                'person_name' => $personName,
                'person_document' => $personDocument,
                'document_type' => $documentType,
                'document_number' => $documentNumber,
                'detalle' => $detalle,
                'moneda' => $payment->moneda ?? 'PEN',
                'tipo' => $payment->type_movement,
                'ingresos' => $ingresos,
                'gastos' => $gastos,
                'saldo' => $saldoAcumulado,
                'payment_id' => $payment->id,
                'destination_id' => $payment->destination_id,
            ];
        }

        return collect($saldos);
    }
}
