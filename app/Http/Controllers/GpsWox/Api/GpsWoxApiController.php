<?php

namespace App\Http\Controllers\GpsWox\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GpsWoxApiController extends Controller
{
    protected $client;
    public $baseUri  = 'https://plataforma.talentustechnology.com/api/';
    public $apiHash = '$2y$10$Cju1OG.5wPtYMK9/wO1NKezifGuKPmpydOiKTnQ4uItj6h/c9vDJi';
    //public $apiHash = '$2y$10$E/DVaHmycEsXBCI6Uw3BDu/sSXyPPIg1X8vaFYzZ72TjG9uah/ZhC';


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
        ]);
    }

    public function getDeviceByPlateNumber(Request $request)
    {
        // Validamos que el parámetro 'plate_number' esté presente
        if (!$request->has('plate_number') || empty($request->query('plate_number'))) {
            return response()->json(['error' => 'Plate number is required'], 400);
        }

        // Construimos los parámetros de consulta
        $queryParams = [
            'plate_number' => $request->query('plate_number'),
            'user_api_hash' => $this->apiHash,
        ];

        // Realizamos la solicitud GET
        $response = $this->client->request('GET', $this->baseUri . 'get_device_by_plate_number', [
            'query' => $queryParams,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        // Retornamos el cuerpo de la respuesta
        return json_decode($response->getBody(), true);
    }

    public function getDevices(Request $request)
    {

        // Construimos los parámetros de consulta
        $queryParams = [
            'page' => $request->query('page', 1),
            'limit' => $request->query('perPage', 10),
            'user_api_hash' => $this->apiHash,

        ];


        // Añadimos 'plate_number' solo si está presente en la petición
        if ($request->has('plate_number') && !empty($request->query('plate_number'))) {
            $queryParams['plate_number'] = $request->query('plate_number');
        }

        // Añadimos 'sim_number' solo si está presente en la petición
        if ($request->has('sim_number') && !empty($request->query('sim_number'))) {
            $queryParams['sim_number'] = $request->query('sim_number');
        }

        if ($request->has('s') && !empty($request->query('s'))) {
            $queryParams['s'] = $request->query('s');
        }


        // Realizamos la solicitud GET
        $response = $this->client->request('GET', $this->baseUri . 'get_devices', [
            'query' => $queryParams,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        // Retornamos el cuerpo de la respuesta
        return json_decode($response->getBody(), true);
    }
}
