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
        return view('cliente.faq');
    }
    public function contacto()
    {
        return view('cliente.contacto');
    }
    public function review()
    {
        return view('cliente.review');
    }

    public function submitContacto(Request $request) {}
    public function manualesPlataforma()
    {
        return view('cliente.manuales.plataforma');
    }
}
