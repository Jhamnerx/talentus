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
            'img_documentos' => 'talentus/imagenes/img_documento.png',
            'fondo_contrato' => 'talentus/imagenes/fondo_contrato.png',
            'img_firma' => 'talentus/imagenes/img_firma.png',
            'logo' => 'talentus/imagenes/logo.png',
            'fav_icon' => 'talentus/imagenes/fav_icon.png',
            'banner' => 'talentus/imagenes/banner.png',
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
            'img_documentos' => 'talentus/imagenes/img_documento.png',
            'fondo_contrato' => 'talentus/imagenes/fondo_contrato.png',
            'img_firma' => 'talentus/imagenes/img_firma.png',
            'logo' => 'talentus/imagenes/logo.png',
            'fav_icon' => 'talentus/imagenes/fav_icon.png',
            'banner' => 'talentus/imagenes/banner.png',
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
