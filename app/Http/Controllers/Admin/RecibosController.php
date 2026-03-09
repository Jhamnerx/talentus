<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibos;

class RecibosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-recibos', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-recibos', ['only' => ['create']]);
        $this->middleware('permission:editar-recibos', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.ventas.recibos.index');
    }

    public function create($notificacion_ids = null)
    {
        $notificacion_ids = $notificacion_ids ? json_decode($notificacion_ids, true) : [];
        return view('admin.ventas.recibos.create', compact('notificacion_ids'));
    }


    public function edit(Recibos $recibo)
    {
        return view('admin.ventas.recibos.edit', compact('recibo'));
    }
}
