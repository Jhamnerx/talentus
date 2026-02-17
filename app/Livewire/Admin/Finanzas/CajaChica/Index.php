<?php

namespace App\Livewire\Admin\Finanzas\CajaChica;

use App\Models\Cash;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';
    public $from = '';
    public $to = '';
    public $estado_filter = '';

    #[On('render')]
    public function render()
    {
        $query = Cash::with(['user'])
            ->withCount([
                'globalDestination as movimientos_count' => function ($q) {}
            ])
            ->where(function ($q) {
                if ($this->search) {
                    $q->where('reference_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                }
            });

        if ($this->estado_filter !== '') {
            $query->where('estado', $this->estado_filter);
        }

        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha_apertura', [$this->from, $this->to]);
        }

        $cajas = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.finanzas.caja-chica.index', compact('cajas'));
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

    public function create()
    {
        $this->dispatch('create-cash');
    }

    public function edit($id)
    {
        $this->dispatch('edit-cash', id: $id);
    }

    public function confirmDelete($id)
    {
        $cash = Cash::findOrFail($id);

        $this->dialog()->confirm([
            'title'       => '¿Está seguro?',
            'description' => "Esta acción eliminará permanentemente la caja del {$cash->fecha_apertura}",
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Sí, eliminar',
                'method' => 'delete',
                'params' => $id,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ],
        ]);
    }

    public function delete($id)
    {
        try {
            $cash = Cash::findOrFail($id);

            // Verificar si tiene movimientos en global_payments
            if ($cash->globalDestination()->exists()) {
                $this->notification()->error(
                    'No se puede eliminar',
                    'La caja tiene movimientos de pagos registrados. No es posible eliminarla.'
                );
                return;
            }

            // Verificar si tiene documentos relacionados (sistema antiguo)
            if ($cash->cashDocuments()->exists()) {
                $this->notification()->error(
                    'No se puede eliminar',
                    'La caja tiene documentos asociados. No es posible eliminarla.'
                );
                return;
            }

            $cash->delete();

            $this->notification()->success('¡Éxito!', 'Caja eliminada correctamente');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error al eliminar la caja: ' . $e->getMessage());
        }
    }

    public function closeCash($id)
    {
        $cash = Cash::findOrFail($id);

        $this->dialog()->confirm([
            'title'       => '¿Cerrar caja?',
            'description' => "Se cerrará la caja del {$cash->fecha_apertura} con saldo actual de {$cash->moneda} " . number_format($cash->saldo_actual, 2),
            'icon'        => 'warning',
            'accept'      => [
                'label'  => 'Sí, cerrar',
                'method' => 'performCloseCash',
                'params' => $id,
            ],
            'reject' => [
                'label'  => 'Cancelar',
            ],
        ]);
    }

    public function performCloseCash($id)
    {
        try {
            $cash = Cash::findOrFail($id);

            if ($cash->estado == 0) {
                $this->notification()->error('Error', 'La caja ya está cerrada');
                return;
            }

            $cash->cerrar();

            $this->notification()->success(
                '¡Caja cerrada!',
                "Saldo final: {$cash->moneda} " . number_format($cash->saldo_actual, 2)
            );
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error al cerrar la caja: ' . $e->getMessage());
        }
    }
}
