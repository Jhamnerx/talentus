<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $existentes = DB::table('motivo_traslado')->pluck('codigo')->toArray();

        $motivos = [
            ['codigo' => '08', 'descripcion' => 'IMPORTACIÓN'],
            ['codigo' => '09', 'descripcion' => 'EXPORTACIÓN'],
        ];

        foreach ($motivos as $motivo) {
            if (!in_array($motivo['codigo'], $existentes)) {
                DB::table('motivo_traslado')->insert($motivo);
            }
        }
    }

    public function down(): void
    {
        DB::table('motivo_traslado')->whereIn('codigo', ['08', '09'])->delete();
    }
};
