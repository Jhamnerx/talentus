<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PlanesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.cobros.index', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.planes.index');
    }
}
