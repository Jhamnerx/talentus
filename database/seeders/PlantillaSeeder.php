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
            'img_firma' => 'plantilla/talentus/img_firma.png',
            'img_icono' => 'plantilla/talentus/icono.png',
            'img_login' => 'plantilla/talentus/img_login.png',
            'serie_factura' => 'F001',
            'serie_boleta' => 'B001',
            'serie_recibo' => 'R001',
            'empresa_id' => '1',

        ]);
        plantilla::create([
            'razon_social' => 'KATARY SERVICIOS GENERALES S.A.C',
            'ruc' => '20496172168',
            'impuesto' => '18',
            'img_documentos' => 'plantilla/katary/img_documentos.png',
            'img_firma' => 'plantilla/katary/img_firma.png',
            'img_icono' => 'plantilla/katary/icono.png',
            'img_login' => 'plantilla/katary/img_login.png',
            'serie_factura' => 'F001',
            'serie_boleta' => 'B001',
            'serie_recibo' => 'R001',
            'empresa_id' => '2',
        ]);
    }
}
