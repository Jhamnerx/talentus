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


    public function store(ContactosRequest $request)
    {

        Contactos::create($request->all());
        return redirect()->route('admin.clientes.contactos.index')->with('store', 'El contacto se guardo con exito');
    }

    public function show(Contactos $contactos)
    {
        return view('admin.clientes.contactos.show');
    }
    public function edit(Contactos $contacto)
    {
        return view('admin.clientes.contactos.edit', compact('contacto'));
    }

    public function update(ContactosRequest $request, Contactos $contacto)
    {
        $contacto->update($request->all());
        return redirect()->route('admin.clientes.contactos.index')->with('update', 'El contacto se actualizo con exito');
    }
}
