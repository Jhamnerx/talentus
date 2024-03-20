<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactosRequest;
use App\Models\Contactos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-contacto', ['only' => ['index']]);
    }

    public function index()
    {
        $date = Carbon::createFromDate(1970, 19, 12)->age;
        return view('admin.clientes.contactos.index');
    }
}
