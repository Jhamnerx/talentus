<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactosRequest;
use App\Models\Contactos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactosController extends Controller
{

    public function index()
    {

        $date = Carbon::createFromDate(1970, 19, 12)->age;

        return view('admin.clientes.contactos.index');
    }


    public function create()
    {
        return view('admin.clientes.contactos.create');
    }


    public function store(ContactosRequest $request)
    {


        Contactos::create($request->all());
        return redirect()->route('admin.clientes.contactos.index')->with('store', 'El contacto se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function show(Contactos $contactos)
    {
        return view('admin.clientes.contactos.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function edit(Contactos $contacto)
    {
        return view('admin.clientes.contactos.edit', compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function update(ContactosRequest $request, Contactos $contacto)
    {
        $contacto->update($request->all());
        return redirect()->route('admin.clientes.contactos.index')->with('update', 'El contacto se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contactos $contactos)
    {
        //
    }
}
