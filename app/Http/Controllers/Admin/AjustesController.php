<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ajustes;
use App\Models\plantilla;
use Illuminate\Http\Request;

class AjustesController extends Controller
{

    public function cuenta()
    {
        return view('admin.ajustes.cuenta');
    }
    public function notificaciones()
    {
        return view('admin.ajustes.notificaciones');
    }
    public function ciudades()
    {
        return view('admin.ajustes.ciudades');
    }
    public function roles()
    {
        return view('admin.ajustes.roles');
    }
    public function series()
    {
        return view('admin.ajustes.series');
    }

    public function plantilla()
    {
        $plantilla = plantilla::first();

        return view('admin.ajustes.plantilla', compact('plantilla'));
    }
    public function sunat()
    {
        $plantilla = plantilla::first();

        return view('admin.ajustes.sunat', compact('plantilla'));
    }
}
