<?php

namespace App\Livewire\Admin\Clientes\Contactos;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Contactos;
use Livewire\Attributes\On;
use App\Http\Requests\ContactosRequest;

class Save extends Component
{
    public $modalSave = false;

    public $nombre, $clientes_id, $numero_documento, $cargo, $telefono, $email, $birthday, $is_gerente = false, $descripcion;


    public function render()
    {
        return view('livewire.admin.clientes.contactos.save');
    }

    #[On('open-modal-save')]
    public function openModal()
    {

        // $this->birthday = Carbon::now();
        $this->birthday = Carbon::now()->format('Y-m-d');
        $this->modalSave = true;
    }

    public function closeModal()
    {
        $this->modalSave = false;
        $this->resetProperties();
    }


    public function save()
    {
        $request = new ContactosRequest();
        $datos = $this->validate($request->rules(), $request->messages());

        try {

            Contactos::create($datos);
            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL GUARDAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
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

    public function afterSave()
    {
        $this->closeModal();
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'CONTACTO REGISTRADO',
            mensaje: 'Se registro correctamente el contacto'
        );

        $this->dispatch('update-table');
    }
}
