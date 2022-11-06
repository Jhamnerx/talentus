<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Unit;
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
            'nombre' => 'talentus',
        ]);
        Empresa::create([
            'nombre' => 'katary',
        ]);


        $empresas = Empresa::all();








        $units  = [
            [
                'codigo' => "4A",
                'name' => "BOBINAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "BJ",
                'name' => "BALDE",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "BLL",
                'name' => "BARRILES",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "BG",
                'name' => "BOLSA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "BO",
                'name' => "BOTELLAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "BX",
                'name' => "CAJA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CT",
                'name' => "CARTONES",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CMK",
                'name' => "CENTIMETRO CUADRADO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CMQ",
                'name' => "CENTIMETRO CUBICO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CMT",
                'name' => "CENTIMETRO LINEAL",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CEN",
                'name' => "CIENTO DE UNIDADES",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CY",
                'name' => "CILINDRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CJ",
                'name' => "CONOS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "DZN",
                'name' => "DOCENA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "DZP",
                'name' => "DOCENA POR 10**6",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "BE",
                'name' => "FARDO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "GLI",
                'name' => "GALON INGLES (4,545956L)",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "GRM",
                'name' => "GRAMO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "GRO",
                'name' => "GRUESA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "HLT",
                'name' => "HECTOLITRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "LEF",
                'name' => "HOJA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "SET",
                'name' => "JUEGO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "KGM",
                'name' => "KILOGRAMO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "KTM",
                'name' => "KILOMETRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "KWH",
                'name' => "KILOVATIO HORA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "KT",
                'name' => "KIT",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "CA",
                'name' => "LATAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "LBR",
                'name' => "LIBRAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "LTR",
                'name' => "LITRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MWH",
                'name' => "MEGAWATT HORA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MTR",
                'name' => "METRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MTK",
                'name' => "METRO CUADRADO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MTQ",
                'name' => "METRO CUBICO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MGM",
                'name' => "MILIGRAMOS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MLT",
                'name' => "MILILITRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MMT",
                'name' => "MILIMETRO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MMK",
                'name' => "MILIMETRO CUADRADO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MMQ",
                'name' => "MILIMETRO CUBICO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "MIL",
                'name' => "MILLARES",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "UM",
                'name' => "MILLON DE UNIDADES",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "ONZ",
                'name' => "ONZAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "PF",
                'name' => "PALETAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "PK",
                'name' => "PAQUETE",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "PR",
                'name' => "PAR",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "FOT",
                'name' => "PIES",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "FTK",
                'name' => "PIES CUADRADOS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "FTQ",
                'name' => "PIES CUBICOS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "C62",
                'name' => "PIEZAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "PG",
                'name' => "PLACAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "ST",
                'name' => "PLIEGO",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "INH",
                'name' => "PULGADAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "RM",
                'name' => "RESMA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "DR",
                'name' => "TAMBOR",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "STN",
                'name' => "TONELADA CORTA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "LTN",
                'name' => "TONELADA LARGA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "TNE",
                'name' => "TONELADAS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "TU",
                'name' => "TUBOS",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "NIU",
                'name' => "UNIDAD (BIENES)",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "ZZ",
                'name' => "UNIDAD (SERVICIOS)",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "GLL",
                'name' => "US GALON (3,7843 L)",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "YRD",
                'name' => "YARDA",
                // 'empresa_id' => $empresa->id
            ],
            [
                'codigo' => "YDK",
                'name' => "YARDA CUADRADA",
                // 'empresa_id' => $empresa->id

            ]
        ];

        Unit::create($units);
    }
}
