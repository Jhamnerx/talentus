<?php

namespace App\Livewire\Admin\Clientes;

use Livewire\Component;
use App\Models\Clientes;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Http\Requests\ClientesRequest;
use App\Services\FactilizaService;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;
    public $modalEdit = false;
    public $tipo_documento_id = 1, $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion;

    public $errorConsulta;
    public Clientes $cliente;

    public function render()
    {
        return view('livewire.admin.clientes.edit');
    }

    #[On('open-modal-edit')]
    public function openModal(Clientes $cliente)
    {
        $this->modalEdit = true;
        $this->cliente = $cliente;
        $this->tipo_documento_id = $cliente->tipo_documento_id;
        $this->numero_documento = $cliente->numero_documento;
        $this->razon_social = $cliente->razon_social;
        $this->telefono = $cliente->telefono;
        $this->email = $cliente->email;
        $this->web_site = $cliente->web_site;
        $this->direccion = $cliente->direccion;
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
        $request = new ClientesRequest();
        $data = $this->validate($request->rules($this->cliente), $request->messages());

        try {
            $this->cliente->update($data);
            $this->afterSave($this->cliente);
        } catch (\Throwable $th) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterSave($cliente)
    {
        $this->closeModal();
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'CLIENTE EDITADO',
            mensaje: 'El cliente ' . $cliente->razon_social . ' fue actulizado correctamente'
        );

        $this->dispatch('update-table');
        $this->resetProp();
    }

    public function resetProp()
    {

        $this->reset('tipo_documento_id', 'numero_documento', 'razon_social', 'telefono', 'email', 'web_site', 'direccion');
    }

    public function closeModal()
    {
        $this->modalEdit = false;
    }
}
