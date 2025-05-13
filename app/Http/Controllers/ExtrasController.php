<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExtrasController extends Controller
{

    public function __invoke(Tareas $tarea)
    {

        $tarea->withoutGlobalScopes();

        return view('app.extras.confirmacion', compact('tarea'));
    }
}
