<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\plantilla;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $plantilla = plantilla::where('empresas_id', session('empresa'));
        return view('admin.index', compact('plantilla'));
    }
}
