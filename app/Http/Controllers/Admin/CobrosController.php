<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cobros;
use Illuminate\Http\Request;

class CobrosController extends Controller
{

    public function index()
    {
        return view('admin.cobros.index');
    }


    public function create()
    {
        return view('admin.cobros.create');
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Cobros $cobro)
    {
        return view('admin.cobros.show', compact('cobro'));
    }


    public function edit(Cobros $cobro)
    {
        return view('admin.cobros.edit', compact('cobro'));
    }


    public function update(Request $request, Cobros $cobros)
    {
        //
    }


    public function destroy(Cobros $cobros)
    {
        //
    }
}
