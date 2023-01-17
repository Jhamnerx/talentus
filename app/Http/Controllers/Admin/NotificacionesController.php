<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        return view('admin.notificaciones.index', compact('user'));
    }

    public function importes()
    {


        return view('admin.notificaciones.importes');
    }
}
