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

    public static function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'tareas', 'field' => 'token', 'length' => 12, 'prefix' => 'TASK' . date('y') . '-', 'reset_on_prefix_change' => true, 'show_prefix' => true]);
        return $id;
    }
}
