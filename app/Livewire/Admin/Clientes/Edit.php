<?php

namespace App\Livewire\Admin\Clientes;

use Livewire\Component;
use App\Models\Clientes;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\UtilesController;

class Edit extends Component
{
    public $modalEdit = false;
    public $tipo_documento_id = 1, $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion;

    public $errorConsulta;
    public Clientes $cliente;

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
            'tipo_documento_id' => 'required',
            'razon_social' => 'required',
            'direccion' => 'nullable',
            'web_site' => 'nullable',
            'telefono' => 'nullable|digits_between:6,9|numeric',
            'email' => 'email|nullable',
            'numero_documento' => [
                'required',
                'min:6',
                'numeric',
                Rule::unique('clientes', 'numero_documento')->where(
                    fn ($query) =>
                    $query->where('empresa_id', session('empresa'))
                        ->where('is_active', 1)
                )->ignore($this->cliente->id)
            ],
        ];
    }

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
        $data = $this->validate();

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

    public function updated($value)
    {
        $this->validateOnly($value, $this->rules());
    }

    public function closeModal()
    {
        $this->modalEdit = false;
    }
}
