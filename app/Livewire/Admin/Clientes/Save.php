<?php

namespace App\Livewire\Admin\Clientes;

use App\Http\Controllers\Admin\UtilesController;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class Save extends Component
{

    public $modalSave = false;

    public $tipo_documento_id = 1, $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion;

    public $errorConsulta;


    public function render()
    {
        return view('livewire.admin.clientes.save');
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
        $data = $this->validate($request->rules(), $request->messages());

        try {
            $cliente = Clientes::create($data);
            $this->afterSave($cliente);
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
            title: 'CLIENTE GUARDADO',
            mensaje: 'El cliente ' . $cliente->razon_social . ' fue registrado correctamente'
        );

        $this->dispatch('update-table');
        $this->resetProp();
    }

    public function resetProp()
    {

        $this->reset('tipo_documento_id', 'numero_documento', 'razon_social', 'telefono', 'email', 'web_site', 'direccion');
    }

    public function updated($value)
    {
        $request = new ClientesRequest();
        $this->validateOnly($value, $request->rules(), $request->messages());
    }

    public function closeModal()
    {
        $this->modalSave = false;
    }

    #[On(['open-modal-save-cliente', 'open-modal-save'])]
    public function openModalSaveCliente($busqueda = null)
    {
        $this->razon_social = $busqueda;
        $this->modalSave = true;
    }
}
