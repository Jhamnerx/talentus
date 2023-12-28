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

class UtilesController extends Controller
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    public $faker;

    public static function tipoCambio()
    {

        $cambio = Cache::get('cambio');

        if ($cambio) {

            return $cambio;
        } else {

            try {

                $token = env('TOKEN_API_CONSULTA_SUNAT');

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

                $res = $client->request('GET', '/v2/sunat/tipo-cambio', $parameters);
                $response = json_decode($res->getBody()->getContents(), true);


                if (array_key_exists('precioVenta', $response)) {

                    Cache::put(
                        'cambio',
                        $response["precioVenta"],
                        now()->addHours(4)
                    );
                    Cache::put(
                        'precioVenta',
                        $response["precioVenta"],
                        now()->addHours(4)
                    );
                    Cache::put(
                        'precioCompra',
                        $response["precioCompra"],
                        now()->addHours(4)
                    );
                    return $response["precioVenta"];
                }
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
    public function __construct()
    {

        $this->faker = $this->withFaker();
    }
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    public function test()
    {
        $values = array();

        for ($i = 1; $i < 493; $i++) {

            $values[] = $i;
        }

        return $values;
        //return $this->faker->unique()->randomElement($values);
    }


    public function sunatConsulta()
    {
        $token = "123456";
        $client = new Client();

        $res = $client->request('POST', 'http://18.228.170.95:8010/api/v1/invoice/pdf?token=123456', [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/pdf',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ],
            'body' => '
                {
                    "ublVersion": "2.1",
                    "tipoOperacion": "0101",
                    "tipoDoc": "03",
                    "serie": "B001",
                    "correlativo": "8",
                    "fechaEmision": "2021-02-06T12:34:00-05:00",
                    "formaPago": {
                        "tipo": "Contado"
                    },
                    "client": {
                        "tipoDoc": "1",
                        "numDoc": "01016578",
                        "rznSocial": "V\u00edctor Hugo Herera  Castillo"
                    },
                    "company": {
                        "ruc": "20316643061",
                        "razonSocial": "ASOCIACI\u00d3N PARA EL SERVICIO MORTUORIO DE LA TERCERA EDAD",
                        "nombreComercial": "ASOMORTES",
                        "address": {
                            "ubigueo": "200606",
                            "codigoPais": "PE",
                            "departamento": "Piura",
                            "provincia": "Sullana",
                            "distrito": "Sullana",
                            "urbanizacion": "-",
                            "direccion": "Calle San Mart\u00edn N\u00b0 224 - 238"
                        }
                    },
                    "tipoMoneda": "PEN",
                    "mtoOperGravadas": "20",
                    "mtoIGV": "0",
                    "totalImpuestos": "0",
                    "valorVenta": "20",
                    "subTotal": "20",
                    "mtoImpVenta": "20",
                    "details": [
                        {
                            "unidad": "NIU",
                            "cantidad": "1",
                            "codProducto": "BGN",
                            "descripcion": "Cuota del mes de Diciembre del 2022",
                            "mtoValorUnitario": "20",
                            "mtoBaseIgv": "0",
                            "porcentajeIgv": "0",
                            "igv": "0",
                            "tipAfeIgv": "0",
                            "totalImpuestos": "0",
                            "mtoPrecioUnitario": "20",
                            "mtoValorVenta": "20"
                        }
                    ],
                    "legends": [
                        {
                            "code": "",
                            "value": ""
                        }
                    ]
                }
            '
        ]);

        return response()->stream(function () use ($res) {
            echo $res->getBody();
        }, 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function setEnvironmentValue($envKey, $envValue)
    {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = env($envKey);

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}
