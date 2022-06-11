<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mensaje;


class MensajeController extends Controller
{
    public  function show(Mensaje $mensaje)
    {
        return view('mensajes.show', compact('mensaje'));
    }


}
