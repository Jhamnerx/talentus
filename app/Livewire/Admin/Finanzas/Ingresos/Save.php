<?php

namespace App\Livewire\Admin\Finanzas\Ingresos;

use App\Models\CashDocument;
use App\Models\Clientes;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class Save extends Component
{
    use WireUiActions;

    public $incomeId;
    public $tipo_comprobante = 'INGRESOS VARIOS';
    public $fecha_emision;
    public $cliente_id;
    public $cliente_nombre;
    public $cliente_documento;
    public $metodo_ingreso = 'EFECTIVO';
    public $destino;
    public $referencia;
    public $motivo;
    public $monto = 0;
    public $moneda = 'PEN';
    public $showModal = false;

    public $clientes = [];

    protected function rules()
    {
        return [
            'tipo_comprobante' => 'required|in:INGRESOS FINANCIEROS,INGRESOS VARIOS',
            'fecha_emision' => 'required|date',
            'cliente_nombre' => 'nullable|string|max:255',
            'cliente_documento' => 'nullable|string|max:20',
            'metodo_ingreso' => 'required|string|max:100',
            'destino' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'motivo' => 'required|string|max:500',
            'monto' => 'required|numeric|min:0.01',
            'moneda' => 'required|in:PEN,USD',
        ];
    }

    protected $messages = [
        'tipo_comprobante.required' => 'El tipo de comprobante es obligatorio',
        'fecha_emision.required' => 'La fecha de emisión es obligatoria',
        'metodo_ingreso.required' => 'El método de ingreso es obligatorio',
        'motivo.required' => 'El motivo es obligatorio',
        'monto.required' => 'El monto es obligatorio',
        'monto.min' => 'El monto debe ser mayor a 0',
    ];

    public function mount()
    {
        $this->fecha_emision = now()->format('Y-m-d');
        $this->clientes = Clientes::select('id', 'razon_social', 'numero_documento')->orderBy('razon_social')->get();
    }

    public function render()
    {
        return view('livewire.admin.finanzas.ingresos.save');
    }

    #[On('create-income')]
    public function create()
    {
        $this->reset([
            'incomeId',
            'tipo_comprobante',
            'cliente_id',
            'cliente_nombre',
            'cliente_documento',
            'metodo_ingreso',
            'destino',
            'referencia',
            'motivo',
            'monto',
            'moneda'
        ]);
        $this->fecha_emision = now()->format('Y-m-d');
        $this->tipo_comprobante = 'INGRESOS VARIOS';
        $this->metodo_ingreso = 'EFECTIVO';
        $this->showModal = true;
    }

    #[On('edit-income')]
    public function edit($id)
    {
        $income = CashDocument::findOrFail($id);

        $this->incomeId = $income->id;
        $this->tipo_comprobante = $income->tipo_comprobante;
        $this->fecha_emision = $income->fecha_emision->format('Y-m-d');
        $this->cliente_id = $income->cliente_id;
        $this->cliente_nombre = $income->cliente_nombre;
        $this->cliente_documento = $income->cliente_documento;
        $this->metodo_ingreso = $income->metodo_ingreso;
        $this->destino = $income->destino;
        $this->referencia = $income->referencia;
        $this->motivo = $income->motivo;
        $this->monto = $income->monto;
        $this->moneda = $income->moneda;

        $this->showModal = true;
    }

    public function updatedClienteId($value)
    {
        if ($value) {
            $cliente = Clientes::find($value);
            if ($cliente) {
                $this->cliente_nombre = $cliente->razon_social;
                $this->cliente_documento = $cliente->numero_documento;
            }
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'tipo_comprobante' => $this->tipo_comprobante,
                'fecha_emision' => $this->fecha_emision,
                'cliente_id' => $this->cliente_id,
                'cliente_nombre' => $this->cliente_nombre,
                'cliente_documento' => $this->cliente_documento,
                'metodo_ingreso' => $this->metodo_ingreso,
                'destino' => $this->destino,
                'referencia' => $this->referencia,
                'motivo' => $this->motivo,
                'monto' => $this->monto,
                'moneda' => $this->moneda,
                'estado' => 'COMPLETADO',
            ];

            if ($this->incomeId) {
                $income = CashDocument::findOrFail($this->incomeId);
                $income->update($data);
                $message = 'Ingreso actualizado correctamente';
            } else {
                // Generar número
                $lastDoc = CashDocument::latest('id')->first();
                $data['numero'] = 'ING-' . str_pad(($lastDoc ? $lastDoc->id + 1 : 1), 6, '0', STR_PAD_LEFT);

                CashDocument::create($data);
                $message = 'Ingreso registrado correctamente';
            }

            $this->notification()->success('¡Éxito!', $message);
            $this->showModal = false;
            $this->dispatch('render');
            $this->reset(['incomeId', 'motivo', 'monto']);
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Ocurrió un error al guardar el ingreso: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    #[On('delete-income')]
    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title' => '¿Está seguro?',
            'description' => 'Esta acción eliminará el ingreso permanentemente',
            'acceptLabel' => 'Sí, eliminar',
            'method' => 'delete',
            'params' => $id,
        ]);
    }

    public function delete($id)
    {
        try {
            $income = CashDocument::findOrFail($id);
            $income->delete();

            $this->notification()->success('¡Éxito!', 'Ingreso eliminado correctamente');
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'No se puede eliminar el ingreso');
        }
    }
}
