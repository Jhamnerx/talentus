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

    public $nombre, $clientes_id, $numero_documento, $cargo, $telefono, $email, $birthday, $is_gerente, $descripcion;


    public function mount()
    {

        $this->birthday = Carbon::now();
    }

    public function render()
    {
        return view('livewire.admin.clientes.contactos.save');
    }

    #[On('open-modal-save')]
    public function openModal()
    {
        $this->modalSave = true;
    }
    public function closeModal()
    {
        $this->modalSave = false;
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
