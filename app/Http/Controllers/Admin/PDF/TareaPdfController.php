<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Tareas;
use Illuminate\Http\Request;

class TareaPdfController extends Controller
{
    public function __invoke(Tareas $tarea)
    {

        return $tarea->getPDFData();
    }
}
