<?php

namespace App\Http\Livewire\App\Solicitudes;

use App\Http\Controllers\Admin\SolicitudesController;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Solicitudes;
use App\Models\Admin\Mensaje;

class CreateForm extends Component
{

    public $numero, $tipo_solicitud, $nombre, $email, $detalle, $servicio_solicitado = "SERVICIO DE MONITOREO", $placa, $fecha_inicial, $fecha_final, $telefono_envio, $email_envio;


    protected $rules = [
        'tipo_solicitud' => 'required',
        'numero' => 'required',
        'nombre' => 'required',
        'email' => 'exclude_if:tipo_solicitud,reporte|required_if:tipo_solicitud,servicio|email:rfc',
        'servicio_solicitado' => 'required_if:tipo_solicitud,servicio',
        'detalle' => 'nullable',

        'placa' => 'required_if:tipo_solicitud,reporte|exclude_if:tipo_solicitud,servicio|exists:vehiculos,placa',
        'fecha_inicial' => 'required_if:tipo_solicitud,reporte|exclude_if:tipo_solicitud,servicio|date',
        'fecha_final' => 'required_if:tipo_solicitud,reporte|exclude_if:tipo_solicitud,servicio|date',
        'telefono_envio' => 'required_if:tipo_solicitud,reporte|exclude_if:tipo_solicitud,servicio|required_if:email_envio,null',
        'email_envio' => 'required_if:tipo_solicitud,reporte|exclude_if:tipo_solicitud,servicio|email:rfc||required_if:telefono_envio,null',

    ];

    protected $messages = [

        'tipo_solicitud.required' => 'Error al obtener el tipo de solicitud',
        'numero.required' => 'Error al obtener el número',
        'nombre.required' => 'Ingresa un nombre o razon social',
        'email.required_if' => 'Ingresa un email para comunicarnos',
        'email.email' => 'Ingresa un correo valido',
        'servicio_solicitado.required_if' => 'Selecciona el servicio a solicitar',


        'placa.required_if' => 'Ingresa una placa',
        'placa.exists' => 'Placa no encontrada en nuestro sistema',
        'fecha_inicial.required_if' => 'Ingresa una fecha inicial',
        'fecha_inicial.date' => 'Ingresa una fecha valida 1999-02-31',
        'fecha_final.date' => 'Ingresa una fecha valida 1999-02-31',
        'fecha_final.required_if' => 'Ingresa una fecha final',
        'telefono_envio.required_if' => 'ingresa un telefono',
        'email_envio.required_if' => 'ingresa un email'
    ];

    public function mount($tipo_solicitud)
    {
        $ctr = new SolicitudesController();
        $this->numero = $ctr->setNextSequenceNumber();
        $this->tipo_solicitud = $tipo_solicitud;
        $this->fecha_inicial = Carbon::now()->subDays(10)->format('Y-m-d');
        $this->fecha_final = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.app.solicitudes.create-form');
    }


    public function guardarSolicitud()
    {
        //dd($this->email_envio);
        $this->validate();
        $data = $this->validate();

        $Solicitud = Solicitudes::create($data);
        $data = array(
            'url' => "admin.solicitudes.index",
            'asunto' => 'RECIBISTE UNA SOLICITUD #' . $this->numero,
            'body' => 'se ha recibido una solicitud de ' . $this->tipo_solicitud,
            'accion' => 'solicitud_rec',
        );

        $mensaje = new Mensaje();
        $mensaje->sendMessage($data);
        $this->dispatchBrowserEvent('solicitud-send');
        $this->reset();
        return redirect()->route('web.home');
    }
}
