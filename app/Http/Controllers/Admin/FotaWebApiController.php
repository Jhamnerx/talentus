<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class FotaWebApiController extends Controller
{


    public function getDevice($imei)
    {

        $token = env('TOKEN_FOTAWEB', '1956|T7pj3AZZQbblLCOShdPbFcNGJmekLsOpvlW6bJP1');

        $client = new Client(['base_uri' => 'https://api.teltonika.lt', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://api.teltonika.lt/devices/' . $imei,
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', 'https://api.teltonika.lt/devices/' . $imei, $parameters);

        if ($res->getStatusCode() == 200) {

            return $response = json_decode($res->getBody()->getContents());
        } else {

            return false;
        }
    }

    public function getDevices()
    {

        $token = env('TOKEN_FOTAWEB', '1956|T7pj3AZZQbblLCOShdPbFcNGJmekLsOpvlW6bJP1');

        $client = new Client(['base_uri' => 'https://api.teltonika.lt', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://api.teltonika.lt/devices',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', 'https://api.teltonika.lt/devices', $parameters);

        if ($res->getStatusCode() == 200) {

            return $response = json_decode($res->getBody()->getContents());
        } else {

            return false;
        }
    }
}
