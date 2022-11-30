<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecibosRequest;
use App\Models\Recibos;
use App\Models\plantilla;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class RecibosController extends Controller
{
    public function index()
    {
        return view('admin.ventas.recibos.index');
    }

    public function create()
    {
        $numero = $this->setNextSequenceNumber();
        return view('admin.ventas.recibos.create', compact('numero'));
    }

    public static function setNextSequenceNumber()
    {
        $plantilla = plantilla::first();
        $id = IdGenerator::generate(['table' => 'recibos', 'field' => 'serie_numero', 'length' => 9, 'prefix' => $plantilla->series["recibo"] . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true, 'show_prefix' => false]);
        return $id;
    }

    public function store(RecibosRequest $request)
    {
        $factura = Recibos::create($request->all());

        Recibos::createItems($factura, $request->items);

        return redirect()->route('admin.ventas.recibos.index')->with('store', 'El Recibo se guardo con exito');
    }

    public function show(Recibos $recibo)
    {
        return view('admin.ventas.recibos.show', compact('recibo'));
    }

    public function edit(Recibos $recibo)
    {
        return view('admin.ventas.recibos.edit', compact('recibo'));
    }

    public function update(RecibosRequest $request, Recibos $recibo)
    {
        $recibo->update($request->all());
        $recibo->detalles()->delete();

        Recibos::createItems($recibo, $request->items);

        return redirect()->route('admin.ventas.recibos.index')->with('update', 'El recibo se actualizo con exito');
    }
}
