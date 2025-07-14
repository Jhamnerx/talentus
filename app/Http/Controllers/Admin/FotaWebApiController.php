<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class FotaWebApiController extends Controller
{


    public function getDevice($imei)
    {

        $token = config('app.token_fota_web');
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

        $token = config('app.token_fota_web');

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
