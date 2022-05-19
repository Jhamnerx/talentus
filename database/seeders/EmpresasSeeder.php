<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::create([
            'nombre' => 'TALENTUS TECHNOLOGY E.I.R.L',
        ]);
        Empresa::create([
            'nombre' => 'KATARY SERVICIOS GENERALES S.A.C',
        ]);
    }
}
