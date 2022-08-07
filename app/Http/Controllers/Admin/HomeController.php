<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\plantilla;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $plantilla = plantilla::where('empresas_id', session('empresa'));
        
        if (!$request->session()->has('empresa')) {
            
            //$request->session('empresa', '1');
            $request->session()->put('empresa', 1);
            //return $request->session()->all();
        }
        //$request->session()->pull('empresa', '1');
        
       return view('admin.index', compact('plantilla'));


       
    }
}
