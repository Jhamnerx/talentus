<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('cliente.index');
    }
    public function faq()
    {
        return view('cliente.index');
    }
    public function contacto()
    {
        return view('cliente.index');
    }
}
