<?php

namespace App\Http\Controllers\Admin;

use ResponseException;
use App\Http\Controllers\Controller;
use App\Models\Tareas;
use Exception;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\WebHook;
use Netflie\WhatsAppCloudApi\Message\Template\Component;

class WhatsAppApi extends Controller
{


    public $token;
    public $number_id;

    public function __construct()
    {
        $this->token = config('WHATSAPP_CLOUD_API_TOKEN');
        $this->number_id = config('WHATSAPP_CLOUD_API_FROM_PHONE_NUMBER');
    }

    public function sendMessage()
    {

        try {
            $api = new WhatsAppCloudApi([
                'from_phone_number_id' => $this->number_id,
                'access_token' => $this->token,
            ]);

            $res = $api->sendTextMessage('51961482121', 'Hey there! I\'m using WhatsApp Cloud API. Visit https://www.netflie.es');

            return $res;
        } catch (Exception $th) {
            return $th;
        }
    }

    public function notifyTecnico(Tareas $tarea)
    {

        $api = new WhatsAppCloudApi([
            'from_phone_number_id' => $this->number_id,
            'access_token' => $this->token,
        ]);

        try {
            $component_header = [];

            $component_body = [
                [
                    'type' => 'text',
                    'text' => $tarea->tipo_tarea->nombre,
                ],
                [
                    'type' => 'text',
                    'text' => $tarea->vehiculo->placa,
                ],
                [
                    'type' => 'text',
                    'text' => $tarea->fecha_hora->format('d/m/Y') . " " . $tarea->fecha_hora->format('h:i A'),
                ],
            ];

            $component_buttons = [];

            $components = new Component($component_header, $component_body, $component_buttons);
            $result = $api->sendTemplate($tarea->tecnico->telefonos, 'notificacion_tarea_creada', 'es', $components); // Language is optional

            return $result;
        } catch (\Exception $e) {

            return $e;
        }
    }

    // BUTTON TYPES MPM, QUICK_REPLY, URL
    public function sendConfirmationClient(Tareas $tarea)
    {

        $api = new WhatsAppCloudApi([
            'from_phone_number_id' => $this->number_id,
            'access_token' => $this->token,
        ]);


        try {
            $component_header = [];

            $component_body = [
                [
                    'type' => 'text',
                    'text' => $tarea->tipo_tarea->nombre,
                ],
                [
                    'type' => 'text',
                    'text' => $tarea->vehiculo->placa,
                ],
                [
                    'type' => 'text',
                    'text' => $tarea->cliente->razon_social,
                ],
                [
                    'type' => 'text',
                    'text' => $tarea->fecha_hora->format('d/m/Y') . " " . $tarea->fecha_hora->format('h:i A'),
                ],
            ];

            $component_buttons = [
                [
                    'type' => 'button',
                    'sub_type' => 'URL',
                    'index' => 0,
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => $tarea->uuid,
                        ]
                    ]
                ]
            ];

            $components = new Component($component_header, $component_body, $component_buttons);
            $result = $api->sendTemplate($tarea->cliente->telefono, 'confirmacion_cliente_tarea', 'es', $components); // Language is optional

            return $result;
        } catch (\Exception $e) {

            return $e;
        }
    }

    public function verify()
    {
        $webhook = new WebHook();

        echo $webhook->verify($_GET, $this->token);
    }
}
