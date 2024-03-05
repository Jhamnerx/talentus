<?php

namespace App\Livewire\Admin\Clientes\Contactos;

use Livewire\Component;
use App\Models\Contactos;
use App\Http\Requests\ContactosRequest;
use Livewire\Attributes\On;

class Edit extends Component
{

    public Contactos $contacto;


    public $modalEdit = false;

    public $nombre, $clientes_id, $numero_documento, $cargo, $telefono, $email, $birthday, $is_gerente = false, $descripcion;


    public function render()
    {
        return view('livewire.admin.clientes.contactos.edit');
    }

    #[On('open-modal-edit')]
    public function openModal(Contactos $contacto)
    {
        $this->nombre = $contacto->nombre;
        $this->clientes_id = $contacto->clientes_id;
        $this->numero_documento = $contacto->numero_documento;
        $this->cargo = $contacto->cargo;
        $this->telefono = $contacto->telefono;
        $this->email = $contacto->email;
        $this->birthday = $contacto->birthday;
        $this->is_gerente = $contacto->is_gerente;
        $this->descripcion = $contacto->descripcion;
        $this->contacto = $contacto;
        $this->modalEdit = true;
    }
    public function resetProperties()
    {
        $this->nombre = null;
        $this->clientes_id = null;
        $this->numero_documento = null;
        $this->cargo = null;
        $this->telefono = null;
        $this->email = null;
        $this->birthday = null;
        $this->is_gerente = null;
        $this->descripcion = null;
    }


    public function closeModal()
    {
        $this->modalEdit = false;
        $this->resetProperties(); // Llamada al método para restablecer las propiedades
    }


    public function save()
    {
        $request = new ContactosRequest();
        $datos = $this->validate($request->rules($this->contacto->id), $request->messages());

        try {

            $this->contacto->update($datos);
            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public function afterSave()
    {
        $this->closeModal();
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'CONTACTO ACTUALIZADO',
            mensaje: 'Se actualizo correctamente el contacto'
        );

        $this->dispatch('update-table');
    }
}
