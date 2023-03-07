<?php

namespace App\Http\Livewire\Admin\Tecnico\Notificaciones;

use App\Models\Tareas;
use Livewire\Component;
use App\Http\Controllers\Admin\WhatsAppApi;
use App\Models\Contactos;

class ClienteContactos extends Component
{
    public $modalNotificacion = false;

    protected $listeners = [
        'send-notificacion-client' => 'openModal'
    ];

    public $selected;
    public Tareas $tarea;

    public function render()
    {
        return view('livewire.admin.tecnico.notificaciones.cliente-contactos');
    }


    public function openModal(Tareas $tarea)
    {
        $this->tarea = $tarea;

        $this->modalNotificacion = true;
    }

    public function closeModal()
    {
        $this->modalNotificacion = false;
        $this->selected = null;
    }

    public function setSelected($value)
    {
        $this->selected = $value;
    }
    public function setSelectedNull()
    {
        $this->selected = null;
    }

    public function sendConfirmationClient()
    {
        if ($this->selected) {

            $contacto = Contactos::findOrFail($this->selected);
            $whatsApp = new WhatsAppApi();

            if ($contacto->telefono) {

                $respuesta = $whatsApp->sendConfirmationClient($this->tarea, $contacto);
                $this->mensajeRespuesta($respuesta, $this->tarea);
            } else {

                $this->dispatchBrowserEvent('not-number');
            }
        }
    }

    public function mensajeRespuesta($respuesta, Tareas $tarea): bool
    {

        if ($respuesta->httpStatusCode() == 200) {

            $this->dispatchBrowserEvent('mensaje-enviado');
            $tarea->sent_message = true;
            $tarea->save();
            return true;
        } else {

            $this->dispatchBrowserEvent('error-mensaje-whatsapp', ['error' => $respuesta->responseData()['error']['message']]);
            return false;
        }
    }
}
