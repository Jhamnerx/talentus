<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PlanesController extends Controller
{
    public function __construct() {}

    public function index()
    {
        return view('admin.planes.index');
    }
}
