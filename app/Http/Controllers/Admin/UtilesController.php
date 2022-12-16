<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class UtilesController extends Controller
{
    public static function tipoCambio()
    {

        $cambio = Cache::get('cambio');

        if ($cambio) {

            return $cambio;
        } else {

            try {

                $token = env('TOKEN_API_SUNAT');

                $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

                $parameters = [
                    'http_errors' => false,
                    'connect_timeout' => 5,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Referer' => 'https://apis.net.pe/api-sunat-tipo-de-cambio',
                        'User-Agent' => 'laravel/guzzle',
                        'Accept' => 'application/json',
                    ],
                ];

                $res = $client->request('GET', '/v1/tipo-cambio-sunat', $parameters);
                $response = json_decode($res->getBody()->getContents(), true);

                Cache::put(
                    'cambio',
                    $response["venta"],
                    now()->addMinutes(1)
                );

                return $response["venta"];
            } catch (\Exception $e) {

                return $e->getMessage();
            }
        }
    }

    public function consultaEmpresa($numero)
    {
        // Datos
        $token = env('TOKEN_API_SUNAT');

        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $numero]
        ];

        $res = $client->request('GET', '/v1/ruc', $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        return $response;
    }

    public function consultaPersona($numero)
    {
        //datos
        $token = env('TOKEN_API_SUNAT');
        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
        // Iniciar llamada a API
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-dni',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $numero]
        ];
        // Datos de persona según padron reducido
        $res = $client->request('GET', '/v1/dni', $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        return $response;
    }
    public function consultaPaca($placa = "BCY-729")
    {
        $username = 'Jhamner';
        $regNumber = 'placa';
        $xmlData =
            file_get_contents("https://www.regcheck.org.uk/api/reg.asmx/CheckPeru?RegistrationNumber=BCY729&username=Jhamner");
        $xml = simplexml_load_string($xmlData);
        $strJson = $xml->vehicleJson;
        $json = json_decode($strJson);
        //print_r($json->Description);


        return $json;
    }

    public static function getLabels($months = 1)
    {
        $labels = [];
        for ($i = 0; $i < $months; $i++) {

            array_push(
                $labels,
                Carbon::now()->startOfMonth()->subMonth($i)->format('m-d-Y')
            );
        }

        return $labels;
    }

    public static function whatsAppSendMessageInstalation($data)
    {
        $token = "EAAJ0miN9XeoBAMZC9RgTvuChpLkxTrtu5TKzpZBvSNoxRzA83BmSC35bd3YfgCFzFKqCynQ7MNSI4xraO1ZBxGd4BUjfMQDotmUV9wiDZAJyiZBt8DSPiDEK0n9lPw5rOoB3hEuITpO6qrCHRzTpD6tjfC7cTZBV82iZAev3dCnwgqu0U9QZCzNJoRLbmWBEqeWoZAQZAnDIxgblZA3aEa2SFcW";
        $client = new Client();
        $parameters = [];

        $res = $client->request('POST', 'https://graph.facebook.com/v15.0/109743508654475/messages', [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ],
            'body' => '
                    {
                    "messaging_product": "whatsapp",
                    "recipient_type": "individual",
                    "to": "51987816560",
                    "type": "template",
                    "template": {
                        "name": "confirmacion_servicio_tecnico",
                        "language": {
                        "code": "es"
                        },
                        "components": [
                        {
                            "type": "body",
                            "parameters": [
                            {
                                "type": "TEXT",
                                "text": "FMU-130"
                            },
                            {
                                "type": "TEXT",
                                "text": "ABC-780"
                            },
                            {
                                "type": "TEXT",
                                "text": "15-12-2022"
                            }
                            ]
                        },
                        {
                            "type": "button",
                            "sub_type": "url",
                            "index": "0",
                            "parameters": [
                            {
                                "type": "TEXT",
                                "text": "TASK22-00001"
                            }
                            ]
                        }
                        ]
                    }
                }
            '
        ]);
        $response = json_decode($res->getBody()->getContents(), true);
        return $response;
    }
}
