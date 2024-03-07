<?php

namespace App\Livewire\Admin\Ajustes\Plantilla;

use App\Http\Controllers\Admin\UtilesController;
use Livewire\Component;
use App\Models\plantilla;

class DatosEmpresa extends Component
{
    public plantilla $plantilla;
    public $direccion, $pais;
    public $ruc, $razon_social, $nombre_comercial, $telefono, $igv, $icbper, $modo;
    public $sunat;
    public $mail_config;
    public $cdt;

    public function mount()
    {
        $this->ruc = $this->plantilla->ruc;
        $this->razon_social = $this->plantilla->razon_social;
        $this->nombre_comercial = $this->plantilla->nombre_comercial;
        $this->telefono = $this->plantilla->telefono;
        $this->direccion = $this->plantilla->direccion;
        $this->igv = $this->plantilla->igvbnormal;
        $this->icbper = $this->plantilla->icbper;
        $this->modo = $this->plantilla->modo = "produccion" ? true : false;
        $this->pais = $this->plantilla->pais;
        $this->sunat = $this->plantilla->sunat_datos;
        $this->mail_config = $this->plantilla->mail_config;
    }

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.datos-empresa');
    }
    public function test()
    {
        dd($this->cdt);
    }


    public function saveInfo()
    {

        $data = $this->validate([
            'ruc' => 'required|max:11',
            'razon_social' => 'required',
            'nombre_comercial' => 'required',
            'telefono' => 'required',
            'igv' => 'required',
            'icbper' => 'required',
            'modo' => 'required',
        ]);


        $this->plantilla->update([
            'ruc' => $data["ruc"],
            'razon_social' => $data["razon_social"],
            'nombre_comercial' => $data["nombre_comercial"],
            'telefono' => $data["telefono"],
            'igv' => $data["igv"],
            'icbper' => $data["icbper"],
            'modo' => $data["modo"] ? 'produccion' : 'local',
        ]);

        $this->afterSave();
    }

    public function saveDireccion()
    {

        $data = $this->validate([
            'direccion.ubigeo' => 'required',
            'direccion.direccion' => 'required',
            'direccion.departamento' => 'required',
            'direccion.provincia' => 'required',
            'direccion.distrito' => 'required',

        ]);

        $this->plantilla->update([
            'direccion' => [
                'ubigeo' => $data['direccion']['ubigeo'],
                'direccion' => $data['direccion']['direccion'],
                'departamento' => $data['direccion']['departamento'],
                'provincia' => $data['direccion']['provincia'],
                'distrito' => $data['direccion']['distrito'],
            ]
        ]);

        $this->afterSave();
    }

    public function saveSunat()
    {

        $data = $this->validate([
            'sunat.usuario_sol_sunat' => 'required',
            'sunat.clave_sol_sunat' => 'required',
            'sunat.clave_certificado_cdt' => 'nullable',
        ]);


        $this->plantilla->update([
            'sunat_datos' => [
                'usuario_sol_sunat' => $data['sunat']['usuario_sol_sunat'],
                'clave_sol_sunat' => $data['sunat']['clave_sol_sunat'],
                'clave_certificado_cdt' => $data['sunat']['clave_certificado_cdt'],
            ]
        ]);

        $this->afterSave();
    }

    public function saveMail()
    {
        $data = $this->validate([
            'mail_config.correo_ventas' => 'required|email',
            'mail_config.servidor' => 'required',
            'mail_config.password' => 'required',
            'mail_config.puerto' => 'required',
            'mail_config.seguridad' => 'required',
            'mail_config.tipo_envio' => 'required',
        ]);

        $this->plantilla->update([
            'mail_config' => $data['mail_config'],
        ]);

        $util = new UtilesController();
        $util->setEnvironmentValue('MAIL_HOST', $data['mail_config']['servidor']);
        $util->setEnvironmentValue('MAIL_PORT', $data['mail_config']['puerto']);
        $util->setEnvironmentValue('MAIL_PASSWORD', $data['mail_config']['password']);
        $util->setEnvironmentValue('MAIL_USERNAME', $data['mail_config']['correo_ventas']);
        $util->setEnvironmentValue('MAIL_ENCRYPTION', $data['mail_config']['seguridad']);
        $util->setEnvironmentValue('MAIL_MAILER', $data['mail_config']['tipo_envio']);

        $this->afterSave();
    }


    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'INFORMACION ACTUALIZADA',
            mensaje: 'se actualizo la informacion'
        );
    }
}
