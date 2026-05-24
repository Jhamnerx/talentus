<?php

namespace App\Livewire\Admin\Dispatchers;

use App\Models\Dispatcher;
use App\Services\FactilizaService;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class SaveModal extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?Dispatcher $dispatcher = null;
    public string $tipo_doc = '6';
    public string $numero_doc = '';
    public string $razon_social = '';
    public string $address = '';
    public string $numero_mtc = '';
    public bool $is_active = true;
    public string $errorConsulta = '';

    protected function rules(): array
    {
        return [
            'tipo_doc'     => 'required',
            'numero_doc'   => 'required',
            'razon_social' => 'required',
            'address'      => 'nullable',
            'numero_mtc'   => 'nullable',
            'is_active'    => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.admin.dispatchers.save-modal');
    }

    #[On('open-modal-create-dispatcher')]
    public function openCreate(): void
    {
        $this->resetValidation();
        $this->reset(['dispatcher', 'tipo_doc', 'numero_doc', 'razon_social', 'address', 'numero_mtc', 'is_active', 'errorConsulta']);
        $this->is_active = true;
        $this->tipo_doc = '6';
        $this->modalOpen = true;
    }

    #[On('open-modal-edit-dispatcher')]
    public function openEdit(Dispatcher $dispatcher): void
    {
        $this->resetValidation();
        $this->dispatcher   = $dispatcher;
        $this->tipo_doc     = $dispatcher->tipo_doc;
        $this->numero_doc   = $dispatcher->numero_doc;
        $this->razon_social = $dispatcher->razon_social;
        $this->address      = $dispatcher->address ?? '';
        $this->numero_mtc   = $dispatcher->numero_mtc ?? '';
        $this->is_active    = (bool) $dispatcher->is_active;
        $this->errorConsulta = '';
        $this->modalOpen    = true;
    }

    public function buscarDocumento(): void
    {
        $this->errorConsulta = '';
        $numero = trim($this->numero_doc);

        if ($this->tipo_doc === '1') {
            if (strlen($numero) !== 8) {
                $this->errorConsulta = 'El DNI debe tener exactamente 8 dígitos';
                return;
            }
            $this->consultarDni($numero);
        } elseif ($this->tipo_doc === '6') {
            if (strlen($numero) !== 11) {
                $this->errorConsulta = 'El RUC debe tener exactamente 11 dígitos';
                return;
            }
            $this->consultarRuc($numero);
        }
    }

    protected function consultarRuc(string $numero): void
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarRuc($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombre_o_razon_social'] ?? false) {
                $this->razon_social = $resultado['nombre_o_razon_social'];
                $this->address      = $resultado['direccion_completa'] ?? '';
                $this->notification()->success(title: 'RUC encontrado', description: 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este RUC';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el RUC';
        }
    }

    protected function consultarDni(string $numero): void
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombres'] ?? false) {
                $this->razon_social = $resultado['nombre_completo'];
                $this->address      = $resultado['direccion_completa'] ?? '';
                $this->notification()->success(title: 'DNI encontrado', description: 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este DNI';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el DNI';
        }
    }

    public function save(): void
    {
        $datos = $this->validate();

        try {
            if ($this->dispatcher) {
                $this->dispatcher->update($datos);
                $msg = 'Transportista actualizado correctamente';
            } else {
                Dispatcher::create($datos);
                $msg = 'Transportista registrado correctamente';
            }
            $this->modalOpen = false;
            $this->notification()->success(title: 'TRANSPORTISTA', description: $msg);
            $this->dispatch('dispatcher-saved');
        } catch (\Throwable $th) {
            $this->notification()->error(title: 'ERROR', description: $th->getMessage());
        }
    }
}
