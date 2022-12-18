<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ServicioTecnico;
use App\Http\Controllers\Controller;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class ServicioTecnicoController extends Controller
{

    public function index()
    {
        return view('admin.tecnico.tareas.index');
    }

    public function tipo()
    {
        return view('admin.tecnico.tareas.tipo');
    }

    public function tecnicos()
    {
        return view('admin.tecnico.index');
    }

    public static function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'tareas', 'field' => 'token', 'length' => 12, 'prefix' => 'TASK' . date('y') . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true, 'show_prefix' => true]);
        return $id;
    }
}
