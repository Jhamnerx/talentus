<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Añadir operador_id a lineas
        Schema::table('lineas', function (Blueprint $table) {
            $table->unsignedBigInteger('operador_id')->nullable()->after('operador');
            $table->foreign('operador_id')->references('id')->on('operadores')->nullOnDelete();
        });

        // 2. Añadir operador_id a sim_card
        Schema::table('sim_card', function (Blueprint $table) {
            $table->unsignedBigInteger('operador_id')->nullable()->after('operador');
            $table->foreign('operador_id')->references('id')->on('operadores')->nullOnDelete();
        });

        // 3. Migrar datos: buscar operador por nombre (case-insensitive)
        DB::statement("
            UPDATE lineas l
            JOIN operadores o ON UPPER(o.name) = UPPER(l.operador)
            SET l.operador_id = o.id
            WHERE l.operador IS NOT NULL AND l.operador != ''
        ");

        DB::statement("
            UPDATE sim_card s
            JOIN operadores o ON UPPER(o.name) = UPPER(s.operador)
            SET s.operador_id = o.id
            WHERE s.operador IS NOT NULL AND s.operador != ''
        ");

        // 4. Eliminar columna operador de lineas
        Schema::table('lineas', function (Blueprint $table) {
            $table->dropColumn('operador');
        });

        // 5. Eliminar columna operador de sim_card
        Schema::table('sim_card', function (Blueprint $table) {
            $table->dropColumn('operador');
        });
    }

    public function down(): void
    {
        Schema::table('lineas', function (Blueprint $table) {
            $table->dropForeign(['operador_id']);
            $table->dropColumn('operador_id');
            $table->string('operador')->nullable()->after('numero');
        });

        Schema::table('sim_card', function (Blueprint $table) {
            $table->dropForeign(['operador_id']);
            $table->dropColumn('operador_id');
            $table->string('operador')->nullable()->after('sim_card');
        });
    }
};
