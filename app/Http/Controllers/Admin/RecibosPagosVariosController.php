<?php

namespace App\Http\Controllers\Admin;

use App\Models\plantilla;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RecibosPagosVarios;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class RecibosPagosVariosController extends Controller
{

    public function index()
    {
        return view('admin.gerencia.recibos.index');
    }

    public function create()
    {
        $numero = $this->setNextSequenceNumber();
        return view('admin.gerencia.recibos.create', compact('numero'));
    }

    public static function setNextSequenceNumber()
    {
        $plantilla = plantilla::first();
        $id = IdGenerator::generate(['table' => 'recibos_pagos', 'field' => 'serie_numero', 'length' => 8, 'prefix' =>  'RB-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true, 'show_prefix' => false]);
        return $id;
    }

    public function edit(RecibosPagosVarios $recibo)
    {
        return view('admin.gerencia.recibos.edit', compact('recibo'));
    }
}
