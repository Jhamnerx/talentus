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
    }
}
