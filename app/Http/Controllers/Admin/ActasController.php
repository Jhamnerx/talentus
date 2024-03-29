<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actas;
use App\Models\Ciudades;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class ActasController extends Controller
{

    public function index()
    {
        $ciudades = Ciudades::active(true)->get();
        return view('admin.certificados.actas.index', compact('ciudades'));
    }

    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'actas', 'field' => 'numero', 'length' => 7, 'prefix' => date('y') . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return trim($id);
    }
}
