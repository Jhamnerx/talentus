<?php

namespace App\Livewire\Admin\Tecnico\Notificaciones;

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

            try {
                $contacto = Contactos::findOrFail($this->selected);

                $whatsApp = new WhatsAppApi();

                if ($contacto->telefono) {

                    $respuesta = $whatsApp->sendConfirmationClient($this->tarea, $contacto);

                    $this->mensajeRespuesta($respuesta, $this->tarea);
                } else {

                    $this->dispatch('not-number');
                }
            } catch (\Throwable $th) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR AL GUARDAR',
                    mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
                );
            }
        }
    }

    public function mensajeRespuesta($respuesta, Tareas $tarea): bool
    {

        if ($respuesta->httpStatusCode() == 200) {

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'MENSAJE ENVIADO',
                mensaje: 'Se envio correctamente el mensaje al contacto',
            );
            $tarea->sent_message = true;
            $tarea->save();
            return true;
        } else {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ENVIAR MENSAJE',
                mensaje: 'Ocurrio el sgte error: ' . $respuesta->responseData()['error']['message'],
            );
            return false;
        }
    }
}
