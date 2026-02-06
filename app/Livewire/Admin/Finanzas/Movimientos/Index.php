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
use WireUi\Traits\WireUiActions;

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

    // Modal de reasignación
    public $showReassignModal = false;
    public $selectedMovement = null;
    public $reassign_destination_type = ''; // 'cash' o 'bank'
    public $reassign_cash_id = null;
    public $reassign_bank_account_id = null;

    #[On('render')]
    public function render()
    {
        $query = GlobalPayment::query()
            ->withRelationsForReport()
            ->latest('created_at'); // Ordenar por fecha más reciente primero

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
        if ($this->type_movement === 'INGRESO') {
            $query->whereHas('payment', function ($q) {
                $q->whereIn('paymentable_type', [
                    'App\\Models\\Ventas',
                    'App\\Models\\Recibos',
                    'App\\Models\\RecibosPagosVarios'
                ]);
            });
        } elseif ($this->type_movement === 'EGRESO') {
            $query->whereHas('payment', function ($q) {
                $q->whereNotIn('paymentable_type', [
                    'App\\Models\\Ventas',
                    'App\\Models\\Recibos',
                    'App\\Models\\RecibosPagosVarios'
                ])->orWhereNull('paymentable_type');
            });
        }

        // Filtro por tipo de destino
        if ($this->destination_type === 'AppModelsCash' || $this->destination_type === 'cash') {
            $query->whereCashDestination();
        } elseif ($this->destination_type === 'AppModelsBankAccount' || $this->destination_type === 'bank') {
            $query->whereBankDestination();
        } elseif ($this->destination_type === 'sin_destino') {
            // Filtrar movimientos sin destino asignado
            $query->whereNull('destination_id');
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
            'type_movement' => $this->type_movement,
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

    /**
     * Abrir modal para reasignar destino de un movimiento huérfano
     */
    public function openReassignModal($movementId)
    {
        $this->selectedMovement = GlobalPayment::with('payment')->find($movementId);

        if (!$this->selectedMovement) {
            $this->notification()->error('Error', 'Movimiento no encontrado');
            return;
        }

        $this->showReassignModal = true;
        $this->reassign_destination_type = '';
        $this->reassign_cash_id = null;
        $this->reassign_bank_account_id = null;
    }

    /**
     * Cerrar modal de reasignación
     */
    public function closeReassignModal()
    {
        $this->showReassignModal = false;
        $this->selectedMovement = null;
        $this->reassign_destination_type = '';
        $this->reassign_cash_id = null;
        $this->reassign_bank_account_id = null;
    }

    /**
     * Confirmar reasignación de destino
     */
    public function confirmReassign()
    {
        // Validar que se haya seleccionado tipo de destino
        if (empty($this->reassign_destination_type)) {
            $this->notification()->error('Error', 'Debe seleccionar el tipo de destino');
            return;
        }

        $destination = null;
        $destinationType = null;

        // Obtener el destino según el tipo seleccionado
        if ($this->reassign_destination_type === 'cash') {
            if (empty($this->reassign_cash_id)) {
                $this->notification()->error('Error', 'Debe seleccionar una caja');
                return;
            }
            $destination = Cash::find($this->reassign_cash_id);
            $destinationType = 'App\\Models\\Cash';
        } elseif ($this->reassign_destination_type === 'bank') {
            if (empty($this->reassign_bank_account_id)) {
                $this->notification()->error('Error', 'Debe seleccionar una cuenta bancaria');
                return;
            }
            $destination = BankAccount::find($this->reassign_bank_account_id);
            $destinationType = 'App\\Models\\BankAccount';
        }

        if (!$destination) {
            $this->notification()->error('Error', 'Destino no encontrado o inactivo');
            return;
        }

        try {
            // Actualizar el GlobalPayment con el nuevo destino
            $this->selectedMovement->update([
                'destination_id' => $destination->id,
                'destination_type' => $destinationType,
            ]);

            // Actualizar el saldo del destino si es caja
            if ($destination instanceof Cash) {
                if ($this->selectedMovement->type_movement === 'INGRESO') {
                    $destination->increment('saldo_actual', $this->selectedMovement->payment->monto);
                } else {
                    $destination->decrement('saldo_actual', $this->selectedMovement->payment->monto);
                }
            }

            $this->notification()->success('¡Éxito!', 'Movimiento reasignado correctamente');
            $this->closeReassignModal();
            $this->dispatch('render'); // Refrescar la lista
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Error al reasignar: ' . $e->getMessage());
        }
    }
}
