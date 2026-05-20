<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('operadores', function (Blueprint $table) {
            // Identifica qué servicio de API usa este operador.
            // Valor para M2M Dataglobal: 'm2m_dataglobal'
            // Dejar null si el operador no usa ningún servicio externo.
            $table->string('api_slug')->nullable()->after('have_api');
        });
    }

    public function down(): void
    {
        Schema::table('operadores', function (Blueprint $table) {
            $table->dropColumn('api_slug');
        });
    }
};
