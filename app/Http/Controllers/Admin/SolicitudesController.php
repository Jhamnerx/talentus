<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class SolicitudesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin.solicitudes.index', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.solicitudes.index');
    }
    public function review()
    {
        return view('admin.reviews.index');
    }
}
