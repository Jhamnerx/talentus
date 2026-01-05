<?php

namespace App\Livewire\Admin\Contactos;

use App\Models\Contacto;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Ver extends Component
{
    use WireUiActions;

    public $contactoId;
    public $contacto;
    public $showModal = false;

    protected $listeners = ['verContacto', 'toggleLeido'];

    public function verContacto($contactoId)
    {
        $this->contactoId = $contactoId;
        $this->contacto = Contacto::find($contactoId);

        if ($this->contacto) {
            // Marcar como leído automáticamente al ver
            if (!$this->contacto->leido) {
                $this->contacto->marcarComoLeido();
            }
            $this->showModal = true;
        }
    }

    public function toggleLeido($contactoId)
    {
        $contacto = Contacto::find($contactoId);

        if ($contacto) {
            if ($contacto->leido) {
                $contacto->update([
                    'leido' => false,
                    'fecha_leido' => null,
                ]);
                $this->notification()->success('Contacto marcado como no leído');
            } else {
                $contacto->marcarComoLeido();
                $this->notification()->success('Contacto marcado como leído');
            }

            $this->dispatch('updateTable');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->contacto = null;
    }

    public function render()
    {
        return view('livewire.admin.contactos.ver');
    }
}
