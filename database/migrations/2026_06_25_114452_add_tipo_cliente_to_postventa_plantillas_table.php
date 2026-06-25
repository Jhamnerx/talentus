<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('postventa_plantillas', function (Blueprint $table) {
            $table->enum('tipo_cliente', ['nuevo', 'recurrente', 'ambos'])
                ->default('ambos')
                ->after('sector_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postventa_plantillas', function (Blueprint $table) {
            $table->dropColumn('tipo_cliente');
        });
    }
};
