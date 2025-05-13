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

                    $url = $this->sendWhatsappWebMessage();

                    $this->redirect($url);
                    // $respuesta = $whatsApp->sendConfirmationClient($this->tarea, $contacto);


                    // $this->mensajeRespuesta($respuesta, $this->tarea);
                } else {


                    $this->dispatch(
                        'notify-toast',
                        icon: 'error',
                        title: 'ERROR AL ENVIAR',
                        mensaje: 'El contacto no tiene un número de teléfono válido.',
                    );
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

    public function sendWhatsappWebMessage()
    {
        if ($this->selected) {
            try {
                $contacto = Contactos::findOrFail($this->selected);
                if ($contacto->telefono) {
                    $tipoTarea = $this->tarea->tipo_tarea->nombre ?? '';
                    $vehiculo = $this->tarea->vehiculo->placa ?? '';
                    $cliente = $this->tarea->cliente->razon_social ?? $this->tarea->cliente->nombre ?? '';
                    $fecha = ($this->tarea->fecha_hora ?? $this->tarea->fecha_programada)?->format('d/m/Y h:i A') ?? '';
                    $uuid = $this->tarea->uuid;

                    if ($uuid == null) {
                        $this->dispatch(
                            'notify-toast',
                            icon: 'error',
                            title: 'ERROR AL ENVIAR',
                            mensaje: 'El uuid de la tarea no es valido.',
                        );
                    }

                    $link = route('confirmacion.tarea', $this->tarea);
                    $mensaje = "SERVICIO TECNICO FINALIZADO\n🛠$tipoTarea.\nEn el vehículo de placa: $vehiculo.🚗.\nEstimado Cliente: $cliente\npor favor dar conformidad al servicio brindado el Dia: \n$fecha\n🌐 Para confirmar haz clic en el botón:\n$link";
                    $telefono = preg_replace('/[^0-9]/', '', $contacto->telefono);
                    $url = 'https://web.whatsapp.com/send?phone=51' . $telefono . '&text=' . urlencode($mensaje);
                    return $url;
                    // $this->dispatch('open-modal', 'modal-notificacion');
                    // $this->dispatch('notify-toast', icon: 'success', title: 'MENSAJE ENVIADO', mensaje: 'Se envio correctamente el mensaje al contacto');
                } else {
                    $this->dispatch('not-number');
                }
            } catch (\Throwable $th) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR AL ENVIAR',
                    mensaje: 'Ocurrió el sgte error: ' . $th->getMessage(),
                );
            }
        }
    }
}
