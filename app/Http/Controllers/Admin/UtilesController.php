<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Faker\Generator;
use GuzzleHttp\Client;
use App\Models\Clientes;
use Illuminate\Container\Container;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Client\Request;

class UtilesController extends Controller
{

    public static function tipoCambio()
    {
        $cambio = Cache::get('cambio');

        if ($cambio) {

            return $cambio;
        } else {

            try {

                $token = config('app.token_sunat');

                $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

                $parameters = [
                    'http_errors' => false,
                    'connect_timeout' => 5,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Referer' => 'https://api.apis.net.pe/v2/sunat/tipo-cambio',
                        'User-Agent' => 'laravel/guzzle',
                        'Accept' => 'application/json',
                    ],
                ];

                $res = $client->request('GET', '/v2/sunat/tipo-cambio', $parameters);

                $response = json_decode($res->getBody()->getContents(), true);

                if (array_key_exists('message', $response)) {

                    if ($response['message'] == 'Not found') {
                        sleep(5);
                        $res = $client->request('GET', '/v2/sunat/tipo-cambio?date=' . Carbon::now()->yesterday()->format('Y-m-d'), $parameters);

                        $response = json_decode($res->getBody()->getContents(), true);
                    }
                }

                if (array_key_exists('precioVenta', $response)) {

                    Cache::put(
                        'cambio',
                        $response["precioVenta"],
                        now()->addHours(6)
                    );
                    Cache::put(
                        'precioVenta',
                        $response["precioVenta"],
                        now()->addHours(6)
                    );
                    Cache::store()->put(
                        'precioCompra',
                        $response["precioCompra"],
                        now()->addHours(6)
                    );
                    return $response["precioVenta"];
                } else {

                    return $response['message'];
                }
            } catch (\Exception $e) {


                return $e->getMessage();
            }
        }
    }

    public function consultaEmpresa($numero)
    {
        // Datos
        $token = config('app.token_sunat');

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
        $token = config('app.token_sunat');
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


    public function consultaDni($numero)
    {
        $token = config('app.token_sunat');
        $client = new Client(['base_uri' => 'https://api.factiliza.com', 'verify' => false]);
        // Iniciar llamada a API
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://api.factiliza.com',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        // Datos de persona según padron reducido
        $res = $client->request('GET', '/pe/v1/dni/info/' . $numero, $parameters);
        return json_decode($res->getBody()->getContents());
    }
}
