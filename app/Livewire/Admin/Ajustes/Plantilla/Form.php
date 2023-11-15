<?php

namespace App\Livewire\Admin\Ajustes\Plantilla;

use App\Models\Empresa;
use App\Models\plantilla;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{

    use WithFileUploads;

    public plantilla $plantilla;
    public $sunat;
    public $direccion;
    public $series;
    public $ruc, $razon_social, $telefono;

    public function mount()
    {
        $this->sunat = $this->plantilla->sunat;
        $this->ruc = $this->plantilla->ruc;
        $this->razon_social = $this->plantilla->razon_social;
        $this->telefono = $this->plantilla->telefono;
        $this->direccion = $this->plantilla->direccion;
        $this->series = $this->plantilla->series;
    }

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.form');
    }

    public function save()
    {

        $this->validate([
            'ruc' => 'required',
            'razon_social' => 'required',
            'direccion.*' => 'required',
            'telefono' => 'required',
        ], [
            'ruc.required' => 'Campo ruc es requerido',
            'razon_social.required' => 'Campo Razon Social es requerido',
            'direccion.*.required' => 'Campo Dirección es requerido',
            'telefono.required' => 'Campo Dirección es requerido',

        ]);

        $this->plantilla->ruc = $this->ruc;
        $this->plantilla->razon_social = $this->razon_social;
        $this->plantilla->direccion = $this->direccion;
        $this->plantilla->telefono = $this->telefono;
        $this->plantilla->save();
        $this->dispatch('save', ['mensaje' => 'Datos Actualizados Correctamente.']);
    }

    public function updatedSeries($value, $field)
    {

        $this->validate([
            'series.' . $field => 'required',

        ], [
            'series.' . $field . '.required' => 'El campo ' . $field . ' es requerido',
        ]);
    }

    public function saveSeries()
    {

        $this->validate([
            'series.factura' => 'required',
            'series.boleta' => 'required',
            'series.recibo' => 'required',
            'series.nota_credito' => 'required',
            'series.nota_debito' => 'required',
            'series.cotizacion' => 'required',

        ], [
            'series.factura.required' => 'El campo factura es requerido',
            'series.boleta.required' => 'El campo boleta es requerido',
            'series.recibo.required' => 'El campo recibo es requerido',
            'series.nota_credito.required' => 'El campo nota credito es requerido',
            'series.nota_debito.required' => 'El campo nota debito es requerido',
            'series.cotizacion.required' => 'El campo cotizacion es requerido',
        ]);

        $this->plantilla->series = $this->series;
        $this->plantilla->save();
        $this->dispatch('save', ['mensaje' => 'Series Actualizadas Correctamente.']);
    }


    public function updatedSunat($value, $field)
    {

        $this->validate([
            'sunat.' . $field => 'required',

        ], [
            'sunat.' . $field . '.required' => 'El campo ' . $field . ' es requerido',
        ]);
    }
    public function saveSunat()
    {

        $this->validate([
            'series.usuario_sol_sunat' => 'required',
            'series.clave_sol_sunat' => 'required',
            'series.clave_certificado_cdt' => 'required',


        ], [
            'series.usuario_sol_sunat.required' => 'El campo usuario sunat es requerido',
            'series.clave_sol_sunat.required' => 'El campo clave sunat es requerido',
            'series.clave_certificado_cdt.required' => 'El campo certificado es requerido',

        ]);

        $this->plantilla->sunat = $this->sunat;
        $this->plantilla->save();
        $this->dispatch('save', ['mensaje' => 'Datos de SUNAT Actualizados Correctamente.']);
    }
}
