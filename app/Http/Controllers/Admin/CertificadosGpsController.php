<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class CertificadosGpsController extends Controller
{

    public function index()
    {
        return view('admin.certificados.gps.index');
    }


    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'certificados', 'field' => 'numero', 'length' => 7, 'prefix' => date('y') . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return trim($id);
    }

    public function show(Certificados $certificado)
    {
        return view('admin.certificados.gps.show');
    }



    public function update(Request $request, Certificados $certificado)
    {
        //
    }


    public function destroy(Certificados $certificado)
    {
        $certificado->delete();
        return redirect()->route('admin.certificados.gps.index')->with('eliminar', 'El Certificado se elimino con exito');
    }
}
