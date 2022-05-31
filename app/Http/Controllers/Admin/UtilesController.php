<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UtilesController extends Controller
{
    public static function tipoCambio()
    {

        // $data = json_decode(file_get_contents('https://api.apis.net.pe/v1/tipo-cambio-sunat'), true);

        // return $data["venta"];
        $token = config('TOKEN_API_SUNAT');

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

        return $response["venta"];
    }

    public function consultaEmpresa($numero)
    {
        // Datos
        $token = config('TOKEN_API_SUNAT');

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
        $token = config('TOKEN_API_SUNAT');
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
        $res = $client->request('GET', '/v1/ruc', $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        return $response;
    }
}
