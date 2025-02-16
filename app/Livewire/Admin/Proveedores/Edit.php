<?php

namespace App\Livewire\Admin\Proveedores;

use App\Models\Proveedores;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{

    public $showModal = false;
    public $numero_documento, $razon_social, $email, $telefono, $web_site, $direccion;

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
        $this->numero_documento = $proveedor->numero_documento;
        $this->razon_social = $proveedor->razon_social;
        $this->email = $proveedor->email;
        $this->telefono = $proveedor->telefono;
        $this->web_site = $proveedor->web_site;
        $this->direccion = $proveedor->direccion;
    }

    public function closeModal()
    {
        $this->showModal = false;
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
