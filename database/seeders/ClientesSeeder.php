<?php

namespace Database\Seeders;

use App\Models\Clientes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->whereRaw('LENGTH(numero_documento) = 8')->update(
            ['tipo_documento_id' => '1']
        );

        DB::table('clientes')->whereRaw('LENGTH(numero_documento) = 11')->update(
            ['tipo_documento_id' => '6']
        );

        Clientes::create(
            [
                'tipo_documento_id' => '6',
                'numero_documento' => '20496172168',
                'razon_social' => 'TALENTUS TECHNOLOGY E.I.R.L',
                'direccion' => 'JR. SANTA MARIA NRO. 221 BAR. MOLLEPAMPA CAJAMARCA - CAJAMARCA - CAJAMARCA',
                'telefono' => '9877654321',
                'empresa_id' => '1',
                'is_active' => '1',
                'email' => 'gerencia@talentustechnology.com'
            ]
        );
    }
}
