<?php

namespace App\Livewire\Admin\Finanzas\CajaChica;

use App\Models\Cash;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;

class Save extends Component
{
    use WireUiActions;

    public $cashId;
    public $saldo_inicial = 0;
    public $moneda = 'PEN';
    public $fecha_apertura;
    public $showModal = false;

    protected function rules()
    {
        return [
            'saldo_inicial' => 'required|numeric|min:0',
            'moneda' => 'required|in:PEN,USD',
            'fecha_apertura' => 'required|date',
        ];
    }

    protected $messages = [
        'saldo_inicial.required' => 'El saldo inicial es obligatorio',
        'saldo_inicial.min' => 'El saldo inicial debe ser mayor o igual a 0',
        'moneda.required' => 'La moneda es obligatoria',
        'fecha_apertura.required' => 'La fecha de apertura es obligatoria',
    ];

    public function mount()
    {
        $this->fecha_apertura = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.finanzas.caja-chica.save');
    }

    #[On('create-cash')]
    public function create()
    {
        $this->reset(['cashId', 'saldo_inicial', 'moneda']);
        $this->fecha_apertura = now()->format('Y-m-d');
        $this->showModal = true;
    }

    #[On('edit-cash')]
    public function edit($id)
    {
        $cash = Cash::findOrFail($id);

        $this->cashId = $cash->id;
        $this->saldo_inicial = $cash->saldo_inicial;
        $this->moneda = $cash->moneda;
        $this->fecha_apertura = $cash->fecha_apertura->format('Y-m-d');

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->cashId) {
                // Editar (solo si está abierta)
                $cash = Cash::findOrFail($this->cashId);

                if ($cash->estado == 0) {
                    $this->notification()->error('Error', 'No se puede editar una caja cerrada');
                    return;
                }

                $cash->update([
                    'saldo_inicial' => $this->saldo_inicial,
                    'moneda' => $this->moneda,
                    'fecha_apertura' => $this->fecha_apertura,
                ]);

                $message = 'Caja actualizada correctamente';
            } else {
                // Validar que no exista una caja abierta en general (para todo el negocio)
                $existingOpenCash = Cash::where('estado', true)->first();

                if ($existingOpenCash) {
                    $userName = $existingOpenCash->user ? $existingOpenCash->user->name : 'Usuario desconocido';
                    $this->notification()->error(
                        'Caja general ya abierta',
                        'Ya existe una caja abierta del ' .
                            $existingOpenCash->fecha_apertura->format('d/m/Y') .
                            ' (aperturada por ' . $userName . '). Por favor cierre esa caja antes de abrir una nueva.'
                    );
                    return;
                }

                // Crear caja general - user_id solo para tracking de quién la abrió
                $cash = Cash::create([
                    'saldo_inicial' => $this->saldo_inicial,
                    'saldo_actual' => $this->saldo_inicial,
                    'moneda' => $this->moneda,
                    'fecha_apertura' => $this->fecha_apertura,
                    'estado' => 1,
                    'user_id' => Auth::user()->id, // Solo para tracking
                ]);

                $message = 'Caja general aperturada correctamente';
            }

            $this->notification()->success('¡Éxito!', $message);
            $this->showModal = false;
            $this->dispatch('render');
            $this->reset(['cashId', 'saldo_inicial', 'moneda']);
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error al guardar la caja: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['cashId', 'saldo_inicial', 'moneda']);
        $this->resetValidation();
    }

    #[On('delete-cash')]
    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title' => '¿Está seguro?',
            'description' => 'Esta acción eliminará la caja permanentemente',
            'acceptLabel' => 'Sí, eliminar',
            'method' => 'delete',
            'params' => $id,
        ]);
    }

    public function delete($id)
    {
        try {
            $cash = Cash::findOrFail($id);
            $cash->delete();

            $this->notification()->success('¡Éxito!', 'Caja eliminada correctamente');
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'No se puede eliminar la caja');
        }
    }

    #[On('close-cash')]
    public function closeCash($id)
    {
        $this->dialog()->confirm([
            'title' => '¿Cerrar caja?',
            'description' => 'Esta acción cerrará la caja y no podrá ser modificada',
            'acceptLabel' => 'Sí, cerrar',
            'method' => 'performCloseCash',
            'params' => $id,
        ]);
    }

    public function performCloseCash($id)
    {
        try {
            $cash = Cash::findOrFail($id);

            // Validar que la caja esté abierta
            if ($cash->estado == 0) {
                $this->notification()->error('Error', 'La caja ya está cerrada');
                return;
            }

            // Usar método cerrar() del modelo que calcula automáticamente
            $cash->cerrar();

            $this->notification()->success(
                '¡Caja cerrada!',
                "Saldo final: {$cash->moneda} " . number_format($cash->saldo_actual, 2)
            );
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error al cerrar la caja: ' . $e->getMessage());
        }
    }
}
