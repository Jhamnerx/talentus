<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Http\Controllers\Controller;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class MantenimientoController extends Controller
{


    public function index()
    {
        return view('admin.vehiculos.mantenimiento.index');
    }

    public function show(Mantenimiento $mantenimiento)
    {
        return view('admin.vehculos.mantenimiento.show', compact('mantenimiento'));
    }


    public function setNextSequenceNumber()
    {
        $id = IdGenerator::generate(
            [
                'table' => 'mantenimientos',
                'field' => 'numero',
                'length' => 9,
                'prefix' => 'MT' . date('y') . '-',
                'where' => ['empresa_id' => session('empresa')],
                'reset_on_prefix_change' => true
            ]
        );
        return trim($id);
    }

    public function pdfInforme(Mantenimiento $mantenimiento)
    {
        return $mantenimiento->getPDFData();
    }
}
