<?php

namespace App\Livewire\Admin\Clientes;

use Livewire\Component;
use App\Models\Clientes;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Http\Requests\ClientesRequest;
use App\Http\Controllers\Admin\UtilesController;

class Edit extends Component
{
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

    public function updatedNumeroDocumento($numero)
    {

        $this->consultarCliente($numero);
    }


    public function consultarCliente($numero)
    {
        $util = new UtilesController;

        if ($this->tipo_documento_id == 1 && strlen($numero) ==  8) {

            $resultado = $util->consultaPersona($numero);

            if ($resultado) {
                if (!array_key_exists('error', $resultado)) {

                    if ($resultado["nombre"]) {
                        $this->reset('errorConsulta');
                        $this->razon_social = $resultado["nombre"];
                        $this->direccion = $resultado["direccion"] . "" . $resultado["provincia"] . " - " . $resultado["departamento"];
                    } else {
                        $this->errorConsulta = "No se encuentra el nombre";
                    }
                } else {
                    $this->errorConsulta = "Hay un error en el documento";
                }
            } else {
                $this->errorConsulta = "No se encuentra el documento";
            }
        }

        if ($this->tipo_documento_id == 6 && strlen($numero) ==  11) {

            $resultado = $util->consultaEmpresa($numero);

            if ($resultado) {
                if (!array_key_exists('error', $resultado)) {

                    if ($resultado["nombre"]) {
                        $this->reset('errorConsulta');
                        $this->razon_social = $resultado["nombre"];
                        $this->direccion = $resultado["direccion"] . "" . $resultado["provincia"] . " - " . $resultado["departamento"];
                    } else {
                        $this->errorConsulta = "No se encuentra el nombre";
                    }
                } else {
                    $this->errorConsulta = "Hay un error en el documento";
                }
            } else {
                $this->errorConsulta = "No se encuentra el documento";
            }
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
