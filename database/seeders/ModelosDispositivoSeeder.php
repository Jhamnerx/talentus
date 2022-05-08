<?php

namespace Database\Seeders;

use App\Models\Imagen;
use App\Models\ModelosDispositivo;
use Illuminate\Database\Seeder;

class ModelosDispositivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelosDispositivo::create([
            'modelo' => 'FMB920',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
        ]);
        ModelosDispositivo::create([
            'modelo' => 'FMC130-4G',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
        ]);
        ModelosDispositivo::create([
            'modelo' => 'TK-318',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
        ]);
        ModelosDispositivo::create([
            'modelo' => 'FMU130-3G',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
        ]);


        $modelos = ModelosDispositivo::all();

        foreach ($modelos as $modelo) {
            Imagen::create([
                'url' => 'modelos_dispositivos/' . $modelo->modelo,
                'imageable_id' => $modelo->id,
                'imageable_type' => ModelosDispositivo::class,
            ]);
        }
    }
}
