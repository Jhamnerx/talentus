<?php

namespace App\Http\Controllers\GpsWox\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GpsWoxApiController extends Controller
{
    protected $client;
    public $baseUri  = 'https://plataforma.talentustechnology.com/api/';
    public $apiHash = '$2y$10$WX7epAyKfPDORgti1T68Ie7RGfFA5yWGGlQvmLOQNlUDkRmRa/SZ2';
    //public $apiHash = '$2y$10$E/DVaHmycEsXBCI6Uw3BDu/sSXyPPIg1X8vaFYzZ72TjG9uah/ZhC';


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
        ]);
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
