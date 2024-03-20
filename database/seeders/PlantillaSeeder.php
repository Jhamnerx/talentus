<?php

namespace Database\Seeders;

use App\Models\plantilla;
use App\Scopes\EmpresaScope;
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
        // dd(plantilla::where('id', 1)->withoutGlobalScopes()->first());
        plantilla::where('empresa_id', 1)
            ->where('id', 1)
            ->withoutGlobalScopes()
            ->update(
                [
                    'tipo_documento' => '6',
                    'razon_social' => 'TALENTUS TECHNOLOGY E.I.R.L',
                    'nombre_comercial' => 'TALENTUS TECHNOLOGY E.I.R.L',
                    'ruc' => '20496172168',
                    'img_documentos' => 'talentus/imagenes/img_documento.png',
                    'fondo_contrato' => 'talentus/imagenes/fondo_contrato.png',
                    'img_firma' => 'talentus/imagenes/img_firma.png',
                    'logo' => 'talentus/imagenes/logo.png',
                    'fav_icon' => 'talentus/imagenes/fav_icon.png',
                    'banner' => 'talentus/imagenes/banner.png',
                    'direccion' => [
                        "ubigeo" => "060101",
                        "direccion" => "JR. SANTA MARIA NRO. 221 BAR. MOLLEPAMPA CAJAMARCA - CAJAMARCA - CAJAMARCA",
                        "departamento" => "CAJAMARCA",
                        "provincia" =>
                        "CAJAMARCA",
                        "distrito" => "CAJAMARCA"
                    ],
                    'telefono' => '9877654321',
                    'pais' => 'PE',
                    'modo' => 'local', #producccion
                    'sunat_datos' => [
                        "usuario_sol_sunat" => "MODDATOS",
                        "clave_sol_sunat" => "MODDATOS",
                        "clave_certificado_cdt" => "admin",
                        'guia_cliente_id' => 'test-85e5b0ae-255c-4891-a595-0b98c65c9854',
                        'guia_secret' => 'test-Hty/M6QshYvPgItX2P0+Kw==',
                    ],
                    'correo' => 'administracion@talentustechnology.com',
                    'mail_config' => [
                        'correo_ventas' => 'ventas@email.com',
                        'correo_soporte' => 'ventas@email.com',
                        'servidor' => 'mboxhosting.com',
                        'password' => '1105gviG',
                        'puerto' => '587',
                        'seguridad' => 'tls',
                        'tipo_envio' => 'smtp',
                    ],
                    'bienes_selva' => false,
                    'servicios_selva' => false,
                    'igv' => 18,
                    'icbper' => 0.50,
                    'ruta_xml' => 'xml/',
                    'ruta_cdr' => 'cdr/',
                    'ruta_cert' => 'certificado/cert',
                    'empresa_id' => '1',
                    'terminos' => '{}',
                ]
            );


        plantilla::where('empresa_id', 2)
            ->where('id', 2)
            ->withoutGlobalScopes()
            ->update(
                [
                    'razon_social' => 'KATARY SERVICIOS GENERALES S.A.C',
                    'ruc' => '20605873783',
                    'img_documentos' => 'talentus/imagenes/img_documento.png',
                    'fondo_contrato' => 'talentus/imagenes/fondo_contrato.png',
                    'img_firma' => 'talentus/imagenes/img_firma.png',
                    'logo' => 'katary/imagenes/logo.png',
                    'fav_icon' => 'katary/imagenes/fav_icon.png',
                    'banner' => 'katary/imagenes/banner.png',
                    'direccion' => [
                        "ubigeo" => "060101",
                        "direccion" => "JR. SANTA MARIA NRO. 221 BAR. MOLLEPAMPA CAJAMARCA - CAJAMARCA - CAJAMARCA",
                        "departamento" => "CAJAMARCA",
                        "provincia" =>
                        "CAJAMARCA",
                        "distrito" => "CAJAMARCA"
                    ],
                    'telefono' => '9877654321',
                    'pais' => 'PE',
                    'modo' => 'local', #producccion
                    'sunat_datos' => [
                        "usuario_sol_sunat" => "MODDATOS",
                        "clave_sol_sunat" => "MODDATOS",
                        "clave_certificado_cdt" => "admin",
                        'guia_cliente_id' => 'test-85e5b0ae-255c-4891-a595-0b98c65c9854',
                        'guia_secret' => 'test-Hty/M6QshYvPgItX2P0+Kw==',
                    ],
                    'correo' => 'administracion@katary.com',
                    'mail_config' => [
                        'correo_ventas' => 'ventas@email.com',
                        'correo_soporte' => 'ventas@email.com',
                        'servidor' => 'mboxhosting.com',
                        'password' => '1105gviG',
                        'puerto' => '587',
                        'seguridad' => 'tls',
                        'tipo_envio' => 'smtp',
                    ],
                    'bienes_selva' => false,
                    'servicios_selva' => false,
                    'igv' => 18,
                    'icbper' => 0.50,
                    'ruta_xml' => 'xml/',
                    'ruta_cdr' => 'cdr/',
                    'ruta_cert' => 'certificado/cert',
                    'empresa_id' => '2',
                    'terminos' => '{}',
                ]
            );
    }
}
