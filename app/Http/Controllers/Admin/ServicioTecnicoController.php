<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ServicioTecnico;
use App\Http\Controllers\Controller;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class ServicioTecnicoController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:tecnico.tareas.index', ['only' => ['index']]);
    }


    public function index()
    {
        return view('admin.tecnico.tareas.index');
    }
    public function tecnicos()
    {
        return view('admin.tecnico.index');
    }
    public static function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'tareas', 'field' => 'token', 'length' => 12, 'prefix' => 'TASK' . date('y') . '-', 'reset_on_prefix_change' => true, 'show_prefix' => true]);
        return $id;
    }
}
