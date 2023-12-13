<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units  = [
            [
                'codigo' => "4A",
                'descripcion' => "BOBINAS",
                'estado' => true,

            ],
            [
                'codigo' => "BJ",
                'descripcion' => "BALDE",

            ],
            [
                'codigo' => "BLL",
                'descripcion' => "BARRILES",

            ],
            [
                'codigo' => "BG",
                'descripcion' => "BOLSA",
                'estado' => true,

            ],
            [
                'codigo' => "BO",
                'descripcion' => "BOTELLAS",

            ],
            [
                'codigo' => "BX",
                'descripcion' => "CAJA",
                'estado' => true,

            ],
            [
                'codigo' => "CT",
                'descripcion' => "CARTONES",

            ],
            [
                'codigo' => "CMK",
                'descripcion' => "CENTIMETRO CUADRADO",

            ],
            [
                'codigo' => "CMQ",
                'descripcion' => "CENTIMETRO CUBICO",

            ],
            [
                'codigo' => "CMT",
                'descripcion' => "CENTIMETRO LINEAL",

            ],
            [
                'codigo' => "CEN",
                'descripcion' => "CIENTO DE UNIDADES",

            ],
            [
                'codigo' => "CY",
                'descripcion' => "CILINDRO",

            ],
            [
                'codigo' => "CJ",
                'descripcion' => "CONOS",

            ],
            [
                'codigo' => "DZN",
                'descripcion' => "DOCENA",

            ],
            [
                'codigo' => "DZP",
                'descripcion' => "DOCENA POR 10**6",

            ],
            [
                'codigo' => "BE",
                'descripcion' => "FARDO",

            ],
            [
                'codigo' => "GLI",
                'descripcion' => "GALON INGLES (4,545956L)",

            ],
            [
                'codigo' => "GRM",
                'descripcion' => "GRAMO",

            ],
            [
                'codigo' => "GRO",
                'descripcion' => "GRUESA",

            ],
            [
                'codigo' => "HLT",
                'descripcion' => "HECTOLITRO",

            ],
            [
                'codigo' => "LEF",
                'descripcion' => "HOJA",

            ],
            [
                'codigo' => "SET",
                'descripcion' => "JUEGO",

            ],
            [
                'codigo' => "KGM",
                'descripcion' => "KILOGRAMO",

            ],
            [
                'codigo' => "KTM",
                'descripcion' => "KILOMETRO",

            ],
            [
                'codigo' => "KWH",
                'descripcion' => "KILOVATIO HORA",

            ],
            [
                'codigo' => "KT",
                'descripcion' => "KIT",

            ],
            [
                'codigo' => "CA",
                'descripcion' => "LATAS",

            ],
            [
                'codigo' => "LBR",
                'descripcion' => "LIBRAS",

            ],
            [
                'codigo' => "LTR",
                'descripcion' => "LITRO",

            ],
            [
                'codigo' => "MWH",
                'descripcion' => "MEGAWATT HORA",

            ],
            [
                'codigo' => "MTR",
                'descripcion' => "METRO",

            ],
            [
                'codigo' => "MTK",
                'descripcion' => "METRO CUADRADO",

            ],
            [
                'codigo' => "MTQ",
                'descripcion' => "METRO CUBICO",

            ],
            [
                'codigo' => "MGM",
                'descripcion' => "MILIGRAMOS",

            ],
            [
                'codigo' => "MLT",
                'descripcion' => "MILILITRO",

            ],
            [
                'codigo' => "MMT",
                'descripcion' => "MILIMETRO",

            ],
            [
                'codigo' => "MMK",
                'descripcion' => "MILIMETRO CUADRADO",

            ],
            [
                'codigo' => "MMQ",
                'descripcion' => "MILIMETRO CUBICO",

            ],
            [
                'codigo' => "MIL",
                'descripcion' => "MILLARES",

            ],
            [
                'codigo' => "UM",
                'descripcion' => "MILLON DE UNIDADES",

            ],
            [
                'codigo' => "ONZ",
                'descripcion' => "ONZAS",

            ],
            [
                'codigo' => "PF",
                'descripcion' => "PALETAS",

            ],
            [
                'codigo' => "PK",
                'descripcion' => "PAQUETE",

            ],
            [
                'codigo' => "PR",
                'descripcion' => "PAR",

            ],
            [
                'codigo' => "FOT",
                'descripcion' => "PIES",

            ],
            [
                'codigo' => "FTK",
                'descripcion' => "PIES CUADRADOS",

            ],
            [
                'codigo' => "FTQ",
                'descripcion' => "PIES CUBICOS",

            ],
            [
                'codigo' => "C62",
                'descripcion' => "PIEZAS",

            ],
            [
                'codigo' => "PG",
                'descripcion' => "PLACAS",

            ],
            [
                'codigo' => "ST",
                'descripcion' => "PLIEGO",

            ],
            [
                'codigo' => "INH",
                'descripcion' => "PULGADAS",

            ],
            [
                'codigo' => "RM",
                'descripcion' => "RESMA",

            ],
            [
                'codigo' => "DR",
                'descripcion' => "TAMBOR",

            ],
            [
                'codigo' => "STN",
                'descripcion' => "TONELADA CORTA",

            ],
            [
                'codigo' => "LTN",
                'descripcion' => "TONELADA LARGA",

            ],
            [
                'codigo' => "TNE",
                'descripcion' => "TONELADAS",

            ],
            [
                'codigo' => "TU",
                'descripcion' => "TUBOS",

            ],
            [
                'codigo' => "NIU",
                'descripcion' => "UNIDAD (BIENES)",
                'estado' => true,

            ],
            [
                'codigo' => "ZZ",
                'descripcion' => "UNIDAD (SERVICIOS)",

            ],
            [
                'codigo' => "GLL",
                'descripcion' => "US GALON (3,7843 L)",

            ],
            [
                'codigo' => "YRD",
                'descripcion' => "YARDA",

            ],
            [
                'codigo' => "YDK",
                'descripcion' => "YARDA CUADRADA",


            ]
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
