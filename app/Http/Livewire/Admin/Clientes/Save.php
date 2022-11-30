<?php

namespace App\Http\Livewire\Admin\Clientes;

use App\Http\Controllers\Admin\UtilesController;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Save extends Component
{

    public $modalSave = false;

    public $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion;

    protected $listeners = [
        'openModalSaveCliente'
    ];



    protected $messages =
    [
        'razon_social.required' => 'No dejes vacio este campo',
        'numero_documento.required' => 'Ingresa un documento',
        'numero_documento.digits_between' => 'Ingresa como minimo 8 caracteres',
        'numero_documento.numeric' => 'El numero documento debe ser un numero',
        'numero_documento.unique' => 'El cliente ya esta registrado',
        'telefono.digits_between' => 'Ingresa como maximo 9 caracteres numericos',
        'telefono.numeric' => 'El numero de telefono debe ser un numero',
        'email.email' => 'Debe tener formato de correo electronico',
    ];

    protected function rules()
    {
        return [
            'razon_social' => 'required',
            'telefono' => 'nullable|digits_between:6,9|numeric',
            'email' => 'email|nullable',
            'numero_documento' => [
                'required',
                'digits_between:8,11',
                'numeric',
                Rule::unique('clientes', 'numero_documento')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
            ],
        ];
    }

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

        $this->validate();

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
        $this->validateOnly($value, $this->rules());
    }

    public function closeModal()
    {
        $this->modalSave = false;
        $this->reset('numero_documento', 'razon_social', 'telefono', 'direccion', 'web_site');
    }

    public function openModalSaveCliente()
    {
        $this->modalSave = true;
    }
}
