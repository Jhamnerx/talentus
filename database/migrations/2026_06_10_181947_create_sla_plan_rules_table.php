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
        Schema::create('sla_plan_rules', function (Blueprint $table) {
            $table->id();
            $table->string('plan_type', 20); // basico | estandar | premium | mininter
            $table->string('priority', 20);  // urgent | high | medium | low
            $table->decimal('tr_hours', 8, 3);         // Tiempo de Respuesta (TR) en horas
            $table->decimal('ts_remote_hours', 8, 3);  // Tiempo de Restauración remoto (TS) en horas
            $table->boolean('tr_business_hours')->default(false);
            $table->boolean('ts_business_hours')->default(false);
            $table->timestamps();

            $table->unique(['plan_type', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sla_plan_rules');
    }
};
