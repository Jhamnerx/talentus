<?php

namespace App\Livewire\Admin\Proveedores;

use Livewire\Component;
use App\Models\Proveedores;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use App\Services\FactilizaService;
use App\Http\Requests\ProveedoresRequest;

class Create extends Component
{
    use WireUiActions;

    public $showModal = false;

    public $tipo_documento_id = 6, $numero_documento, $razon_social, $email, $telefono, $web_site, $direccion;

    public $errorConsulta;

    public function render()
    {
        return view('livewire.admin.proveedores.create');
    }

    #[On('open-modal-create')]
    public function openModal()
    {
        $this->showModal = true;
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

    public function save()
    {

        $request = new ProveedoresRequest();
        $this->validate($request->rules(), $request->messages());

        Proveedores::create([
            'tipo_documento_id' => $this->tipo_documento_id,
            'numero_documento' => $this->numero_documento,
            'razon_social' => $this->razon_social,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'web_site' => $this->web_site,
            'direccion' => $this->direccion,
        ]);

        $this->afterSave();
    }

    public function afterSave()
    {
        $this->tipo_documento_id = 6;
        $this->numero_documento = '';
        $this->razon_social = '';
        $this->email = '';
        $this->telefono = '';
        $this->web_site = '';
        $this->direccion = '';
        $this->errorConsulta = '';

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'Proveedor guardado',
            mensaje: 'El proveedor se guardo con exito'
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}
