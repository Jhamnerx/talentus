<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlatPremiumController extends Controller
{
    public function index()
    {
        return view('plataformas.premium');
    }
}
