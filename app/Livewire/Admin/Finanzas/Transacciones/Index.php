<?php

namespace App\Livewire\Admin\Finanzas\Transacciones;

use App\Models\Cash;
use App\Models\Payments;
use App\Models\BankAccount;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;
    use WireUiActions;

    public $search = '';
    public $from = '';
    public $to = '';
    public $type_movement = ''; // all, INGRESO, EGRESO
    public $destination_type = ''; // all, cash, bank
    public $cash_id = '';
    public $bank_account_id = '';

    // Selector de periodo (igual que Movimientos)
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

        // Obtener todos los movimientos
        $allMovements = $query->get();

        // Procesar movimientos
        $processedMovements = $this->processMovements($allMovements);

        // Paginar
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

        return view('livewire.admin.finanzas.transacciones.index', compact(
            'movimientos',
            'totales',
            'cajas',
            'cuentasBancarias'
        ));
    }

    public function mount()
    {
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
                if ($this->from) {
                    $this->to = $this->from;
                }
                break;
            case 'date_range':
                break;
        }
    }

    private function processMovements($payments)
    {
        $result = collect();
        $saldoAcumulado = 0;

        // Si hay filtro por caja, agregar saldo inicial
        if ($this->cash_id) {
            $cash = Cash::find($this->cash_id);
            if ($cash && $cash->saldo_inicial > 0) {
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
                    'destination' => $cash->nombre,
                    'ingresos' => $cash->saldo_inicial,
                    'gastos' => 0,
                    'saldo' => $saldoAcumulado,
                    'is_saldo_inicial' => true,
                ]);
            }
        }

        foreach ($payments as $payment) {
            $paymentable = $payment->paymentable;
            $personName = '-';
            $personDocument = '';
            $documentType = $payment->description ?? 'Pago';
            $documentNumber = $payment->numero ?? '';
            $detalle = '';

            // Obtener destino
            $destination = '-';
            if ($payment->destination) {
                if ($payment->destination instanceof Cash) {
                    $destination = $payment->destination->nombre ?? '-';
                } elseif ($payment->destination instanceof BankAccount) {
                    $destination = ($payment->destination->bank->name ?? 'Banco') . ' - ' . ($payment->destination->description ?? '');
                }
            }

            // Extraer información del documento
            if ($paymentable) {
                $modelClass = get_class($paymentable);

                switch ($modelClass) {
                    case 'App\\Models\\Recibos':
                        $cliente = $paymentable->clientes;
                        $personName = $cliente->razon_social ?? '';
                        $personDocument = $cliente->numero_documento ?? '';
                        $documentType = 'RECIBO';
                        $documentNumber = $paymentable->serie_numero ?? (($paymentable->serie ?? '') . '-' . ($paymentable->numero ?? ''));
                        break;

                    case 'App\\Models\\Ventas':
                        $venta = $paymentable;
                        $cliente = $venta->cliente;
                        $personName = $cliente->nombre_completo ?? $cliente->razon_social ?? '';
                        $personDocument = $cliente->numero_documento ?? '';
                        $tipoComprobante = $venta->tipoComprobante;
                        $documentType = $tipoComprobante ? strtoupper($tipoComprobante->descripcion ?? $tipoComprobante->name ?? 'VENTA') : 'VENTA';
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
                'destination' => $destination,
                'ingresos' => $ingresos,
                'gastos' => $gastos,
                'saldo' => $saldoAcumulado,
                'payment_id' => $payment->id,
            ]);
        }

        return $result;
    }

    private function calcularTotalesFromProcessed($processedMovements)
    {
        $totalIngresosPEN = 0;
        $totalIngresosUSD = 0;
        $totalGastosPEN = 0;
        $totalGastosUSD = 0;

        foreach ($processedMovements as $mov) {
            $moneda = $mov['moneda'] ?? 'PEN';

            if ($moneda === 'PEN') {
                $totalIngresosPEN += $mov['ingresos'] ?? 0;
                $totalGastosPEN += $mov['gastos'] ?? 0;
            } elseif ($moneda === 'USD') {
                $totalIngresosUSD += $mov['ingresos'] ?? 0;
                $totalGastosUSD += $mov['gastos'] ?? 0;
            }
        }

        return [
            'ingresos_pen' => $totalIngresosPEN,
            'ingresos_usd' => $totalIngresosUSD,
            'gastos_pen' => $totalGastosPEN,
            'gastos_usd' => $totalGastosUSD,
            'saldo_pen' => $totalIngresosPEN - $totalGastosPEN,
            'saldo_usd' => $totalIngresosUSD - $totalGastosUSD,
            // Totales generales para compatibilidad
            'ingresos' => $totalIngresosPEN + $totalIngresosUSD,
            'gastos' => $totalGastosPEN + $totalGastosUSD,
            'saldo' => ($totalIngresosPEN - $totalGastosPEN) + ($totalIngresosUSD - $totalGastosUSD),
        ];
    }

    public function export()
    {
        $allMovements = $this->getAllMovementsForExport();
        $totales = $this->calcularTotalesFromProcessed($allMovements);

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

        $filename = 'transacciones_' . now()->format('YmdHis') . '.xlsx';

        return (new \App\Exports\TransaccionesExport($allMovements, $totales, $filters))
            ->download($filename);
    }

    protected function getAllMovementsForExport()
    {
        $query = Payments::query()
            ->with(['paymentable', 'destination'])
            ->oldest('created_at')
            ->oldest('id');

        if ($this->from && $this->to) {
            $query->whereDateBetween($this->from, $this->to);
        }

        if ($this->type_movement) {
            $query->where('type_movement', $this->type_movement);
        }

        if ($this->cash_id) {
            $query->where('destination_id', $this->cash_id)
                ->where('destination_type', Cash::class);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('paymentable', function ($subQuery) {
                    $subQuery->where('numero', 'like', "%{$this->search}%")
                        ->orWhere('numero_comprobante', 'like', "%{$this->search}%");
                });
            });
        }

        $payments = $query->get();
        return $this->processMovements($payments);
    }
}
