<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilesController extends Controller
{
    public static function tipoCambio()
    {

        $data = json_decode(file_get_contents('https://api.apis.net.pe/v1/tipo-cambio-sunat'), true);

        return $data["compra"];
    }
}
