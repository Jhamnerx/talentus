<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\UtilesController;
use App\Models\Ciudades;
use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Facturas;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\ModelosDispositivo;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\SimCard;
use App\Models\Ubigeos;
use App\Models\User;
use App\Models\Vehiculos;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Arr;

class SearchController extends Controller
{

    public function sunat(Request $request)
    {

        $term = $request->get('numero');
        $tipo = $request->get('tipo');
        // return $term;
        $util = new UtilesController;
        if ($tipo == 'DNI') {
            $resultado = $util->consultaPersona($term);
        } else {
            $resultado = $util->consultaEmpresa($term);
        }



        return $resultado;
    }

    public function placa(Request $request)
    {

        $util = new UtilesController;

        $placa = $request->get('placa');

        $resultado = $util->consultaPaca($placa);

        return $resultado;
    }
}
