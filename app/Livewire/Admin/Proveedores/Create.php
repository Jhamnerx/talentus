<?php

namespace App\Livewire\Admin\Proveedores;

use Livewire\Component;
use App\Models\Proveedores;
use Livewire\Attributes\On;
use App\Http\Requests\ProveedoresRequest;

class Create extends Component
{
    public $showModal = false;

    public $numero_documento, $razon_social, $email, $telefono, $web_site, $direccion;

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


    public function save()
    {

        $request = new ProveedoresRequest();
        $this->validate($request->rules(), $request->messages());

        Proveedores::create([
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
        $this->numero_documento = '';
        $this->razon_social = '';
        $this->email = '';
        $this->telefono = '';
        $this->web_site = '';
        $this->direccion = '';

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
