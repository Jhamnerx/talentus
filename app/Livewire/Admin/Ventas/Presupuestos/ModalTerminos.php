<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class ModalTerminos extends Component
{

    public $modalTerminos = false;

    public Collection $terminos;

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.modal-terminos');
    }

    public function add()
    {
        $this->terminos->push(
            "",
        );
    }
    public function eliminar($key)
    {
        unset($this->terminos[$key]);
    }

    #[On('open-modal-terminos')]
    public function openModal($terminos)
    {
        $this->modalTerminos = true;
        $this->terminos = collect($terminos);
    }

    public function save()
    {

        try {
            $this->dispatch('terminos-save', terminos: $this->terminos);
            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'TERMINOS AÑADIDOS',
                mensaje: 'Se añadieron los terminos'
            );

            $this->close();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'OCURRIO UN ERROR',
                mensaje: 'Error' . $th->getMessage() . "."
            );
        }
    }
    public function close()
    {
        $this->modalTerminos = false;
    }
}
