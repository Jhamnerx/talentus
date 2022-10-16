<?php

namespace App\Http\Livewire\Admin\Clientes;

use App\Http\Controllers\Admin\UtilesController;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use Livewire\Component;

class Save extends Component
{

    public $modalSave = false;

    public $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion;

    protected $listeners = [
        'openModalSaveCliente'
    ];

    public function render()
    {
        return view('livewire.admin.clientes.save');
    }

    public function updatedNumeroDocumento($numero)
    {

        $util = new UtilesController;

        if (strlen($numero) >= 8 && strlen($numero) < 11) {

            $resultado = $util->consultaPersona($numero);

            if ($resultado["nombre"]) {
                $this->razon_social = $resultado["nombre"];
                $this->direccion = $resultado["direccion"] . "" . $resultado["provincia"] . " - " . $resultado["departamento"];
            };
        } elseif (strlen($numero) >= 11) {

            $resultado = $util->consultaEmpresa($numero);

            if ($resultado["nombre"]) {

                $this->razon_social = $resultado["nombre"];
                $this->direccion = $resultado["direccion"] . "" . $resultado["provincia"] . " - " . $resultado["departamento"];
            };
        }
    }


    public function saveCliente()
    {
        $request = new ClientesRequest();
        $this->validate($request->rules(), $request->messages());

        Clientes::create([
            'razon_social' => $this->razon_social,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'web_site' => $this->web_site,
        ]);

        $this->dispatchBrowserEvent('save-cliente', ['razon_social' => $this->razon_social]);

        $this->closeModal();
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

    public function openModalSaveCliente()
    {
        $this->modalSave = true;
    }
}
