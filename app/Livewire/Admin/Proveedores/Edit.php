<?php

namespace App\Livewire\Admin\Proveedores;

use App\Models\Proveedores;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use App\Services\FactilizaService;

class Edit extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $tipo_documento_id, $numero_documento, $razon_social, $email, $telefono, $web_site, $direccion;

    public $errorConsulta;

    public Proveedores $proveedor;

    public function render()
    {
        return view('livewire.admin.proveedores.edit');
    }

    #[On('open-modal-edit')]
    public function openModal(Proveedores $proveedor)
    {
        $this->showModal = true;
        $this->proveedor = $proveedor;
        $this->tipo_documento_id = $proveedor->tipo_documento_id ?? 6;
        $this->numero_documento = $proveedor->numero_documento;
        $this->razon_social = $proveedor->razon_social;
        $this->email = $proveedor->email;
        $this->telefono = $proveedor->telefono;
        $this->web_site = $proveedor->web_site;
        $this->direccion = $proveedor->direccion;
        $this->reset('errorConsulta');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function buscarDocumento()
    {
        $this->reset('errorConsulta');
        $numero = trim($this->numero_documento);

        // Validar que solo contenga números
        if (!ctype_digit($numero)) {
            $this->errorConsulta = 'El número de documento solo debe contener dígitos';
            return;
        }

        // Validar formato según tipo de documento
        if ($this->tipo_documento_id == 1) {
            if (strlen($numero) != 8) {
                $this->errorConsulta = 'El DNI debe tener exactamente 8 dígitos';
                return;
            }
            $this->consultarDni($numero);
        } elseif ($this->tipo_documento_id == 6) {
            if (strlen($numero) != 11) {
                $this->errorConsulta = 'El RUC debe tener exactamente 11 dígitos';
                return;
            }
            $this->consultarRuc($numero);
        } else {
            $this->errorConsulta = 'Tipo de documento no válido para búsqueda automática';
        }
    }

    protected function consultarDni($numero)
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombres'] ?? false) {
                $this->razon_social = $resultado['nombre_completo'];
                $this->direccion = $resultado['direccion_completa'] ?? '';
                $this->notification()->success('DNI encontrado', 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este DNI';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el DNI';
        }
    }

    protected function consultarRuc($numero)
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarRuc($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombre_o_razon_social'] ?? false) {
                $this->razon_social = $resultado['nombre_o_razon_social'];
                $this->direccion = $resultado['direccion_completa'] ?? '';
                $this->notification()->success('RUC encontrado', 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este RUC';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el RUC';
        }
    }

    public function afterUpdate()
    {

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'Proveedor actualizado',
            mensaje: 'El proveedor se guardo con exito'
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function save()
    {
        $this->validate([
            'numero_documento' => 'required',
            'razon_social' => 'required',
        ]);

        $this->proveedor->update([
            'tipo_documento_id' => $this->tipo_documento_id,
            'numero_documento' => $this->numero_documento,
            'razon_social' => $this->razon_social,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'web_site' => $this->web_site,
            'direccion' => $this->direccion,
        ]);

        $this->afterUpdate();
    }
}
