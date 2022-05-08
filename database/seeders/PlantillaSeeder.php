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
            'razon_social' => 'Talentus Technology',
            'ruc' => '20496172168',
            'impuesto' => '18',
            'img_logo' => 'plantilla/img_logo.png',
            'img_icono' => 'plantilla/img_icono.png',
            'img_login' => 'plantilla/img_login.png',
            'img_contrato' => 'plantilla/img_contrato.png',
            'img_acta' => 'plantilla/img_acta.png',
            'img_certificado' => 'plantilla/img_certificado.png',
            'img_firma' => 'plantilla/img_firma.png',
            'empresas_id' => '1',

        ]);
    }
}
