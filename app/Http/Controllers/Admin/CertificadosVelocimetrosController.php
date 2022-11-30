<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificadosVelocimentros;
use App\Models\CertificadosVelocimetros;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class CertificadosVelocimetrosController extends Controller
{

    public function index()
    {
        return view('admin.certificados.velocimetros.index');
    }

    public function show(CertificadosVelocimetros $certificado)
    {
        return view('admin.certificados.velocimetros.show', compact('certificado'));
    }


    public function setNextSequenceNumber()
    {
        $id = IdGenerator::generate(['table' => 'certificados_velocimetros', 'field' => 'numero', 'length' => 7, 'prefix' => date('y') . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return trim($id);
    }

    public function destroy(CertificadosVelocimetros $certificado)
    {
        $certificado->delete();
        return redirect()->route('admin.certificados.velocimetros.index')->with('eliminar', 'El Certificado se elimino con exito');
    }
}
