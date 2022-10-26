<?php

namespace Database\Seeders;

use App\Models\plantilla;
use Illuminate\Database\Seeder;

class PlantillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        plantilla::create([
            'razon_social' => 'TALENTUS TECHNOLOGY E.I.R.L',
            'ruc' => '20496172168',
            'impuesto' => '18',
            'img_documentos' => 'plantilla/talentus/img_documentos.png',
            'fondo_contrato' => 'plantilla/talentus/fondo_contrato.png',
            'img_firma' => 'plantilla/talentus/img_firma.png',
            'logo' => 'plantilla/talentus/logo.png',
            'fav_icon' => 'plantilla/talentus/logo.png',
            'banner' => 'plantilla/talentus/banner.png',
            'direccion' => [
                "ubigeo" => "060101",
                "direccion" => "JR. SANTA MARIA NRO. 221 BAR. MOLLEPAMPA CAJAMARCA - CAJAMARCA - CAJAMARCA",
                "region" => "CAJAMARCA",
                "provincia" =>
                "CAJAMARCA",
                "distrito" => "CAJAMARCA"
            ],
            'telefono' => '9877654321',
            'sunat' => [
                "usuario_sol_sunat" => "MODDATOS",
                "clave_sol_sunat" => "MODDATOS",
                "clave_certificado_cdt" => "MODDATOS",
            ],
            'correo' => 'administracion@talentustechnology.com',
            'series' => [
                'factura' => 'F001',
                'boleta' => 'B001',
                'recibo' => 'R001',
                'nota_credito' => 'FF001',
                'nota_debito' => 'FF001',
                'cotizacion' => 'PRE',
            ],
            'empresa_id' => '1',

        ]);

        plantilla::create([
            'razon_social' => 'KATARY SERVICIOS GENERALES S.A.C',
            'ruc' => '20605873783 ',
            'impuesto' => '18',
            'img_documentos' => 'plantilla/katary/img_documentos.png',
            'fondo_contrato' => 'plantilla/katary/fondo_contrato.png',
            'img_firma' => 'plantilla/katary/img_firma.png',
            'logo' => 'plantilla/katary/logo.png',
            'fav_icon' => 'plantilla/katary/logo.png',
            'banner' => 'plantilla/katary/banner.png',
            'direccion' => [
                "ubigeo" => "060101",
                "direccion" => "JR. SANTA MARIA NRO. 221 BAR. MOLLEPAMPA CAJAMARCA - CAJAMARCA - CAJAMARCA",
                "region" => "CAJAMARCA",
                "provincia" =>
                "CAJAMARCA",
                "distrito" => "CAJAMARCA"
            ],
            'telefono' => '9877654321',
            'sunat' => [
                "usuario_sol_sunat" => "MODDATOS",
                "clave_sol_sunat" => "MODDATOS",
                "clave_certificado_cdt" => "MODDATOS",
            ],
            'correo' => 'administracion@talentustechnology.com',
            'series' => [
                'factura' => 'F001',
                'boleta' => 'B001',
                'recibo' => 'R001',
                'nota_credito' => 'FF001',
                'nota_debito' => 'FF001',
                'cotizacion' => 'PRE',
            ],
            'empresa_id' => '2',
        ]);
    }
}
