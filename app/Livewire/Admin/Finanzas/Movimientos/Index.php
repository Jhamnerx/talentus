<?php

namespace App\Livewire\Admin\Finanzas\Movimientos;

use App\Models\Cash;
use App\Models\GlobalPayment;
use App\Models\BankAccount;
use App\Http\Resources\MovementCollection;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MovimientosExport;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $tipo_filter = ''; // all, ingreso, egreso
    public $destination_type = ''; // all, cash, bank
    public $cash_id = '';
    public $bank_account_id = '';

    #[On('render')]
    public function render()
    {
        $query = GlobalPayment::query()
            ->withRelationsForReport()
            ->latestPayments();

        // Búsqueda por texto
        if (!empty($this->search)) {
            $query->where(function ($q) {
                // Buscar por descripción del GlobalPayment
                $q->where('description', 'like', '%' . $this->search . '%')
                    // O buscar en datos del payment relacionado
                    ->orWhereHas('payment', function ($paymentQ) {
                        $paymentQ->where('numero', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_operacion', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filtro por tipo de movimiento
        if ($this->tipo_filter === 'ingreso') {
            $query->ingresos();
        } elseif ($this->tipo_filter === 'egreso') {
            $query->egresos();
        }

        // Filtro por tipo de destino
        if ($this->destination_type === 'cash') {
            $query->whereCashDestination();
        } elseif ($this->destination_type === 'bank') {
        }

        // Filtro por caja específica
        if ($this->cash_id) {
            $query->byCash($this->cash_id);
        }

        // Filtro por cuenta bancaria específica
        if ($this->bank_account_id) {
            $query->byDestinationType(BankAccount::class)
                ->where('destination_id', $this->bank_account_id);
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereDateBetween($this->from, $this->to);
        }

        // Usar MovementCollection para cálculos optimizados con calculateResiduary
        $paginator = $query->paginate(15);

        // Pasar filtros a la request para calculateResiduary
        request()->merge([
            'search' => $this->search,
            'tipo_filter' => $this->tipo_filter,
            'destination_type' => $this->destination_type,
            'cash_id' => $this->cash_id,
            'bank_account_id' => $this->bank_account_id,
            'from' => $this->from,
            'to' => $this->to,
            'per_page' => 15,
        ]);

        // MovementCollection procesa y calcula saldos acumulados
        $movementCollection = new MovementCollection($paginator);
        $processedData = $movementCollection->toArray(request());

        // Mantener paginación pero con datos procesados
        $movimientos = $paginator->setCollection(collect($processedData));

        // Calcular totales
        $totales = $this->calcularTotales($query);

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

    public function export()
    {
        return Excel::download(
            new MovimientosExport(
                $this->from,
                $this->to,
                $this->tipo_filter,
                $this->destination_type,
                $this->cash_id,
                $this->bank_account_id,
                $this->search
            ),
            'movimientos_' . date('Y-m-d_His') . '.xlsx'
        );
    }
}
