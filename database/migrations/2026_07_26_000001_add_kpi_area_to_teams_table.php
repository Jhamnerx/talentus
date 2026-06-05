<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // Slug que vincula el equipo a un área KPI del MOF
            // Valores: comercial | operaciones | administracion | postventa | monitoreo | gerencia
            $table->string('kpi_area')->nullable()->after('name')->index();
        });

        // Poblar KPIs, WIGs y equipos de área para todas las empresas
        // (debe correr después de crear kpi_area en teams)
        (new \Database\Seeders\KpiSeeder())->run();
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropIndex(['kpi_area']);
            $table->dropColumn('kpi_area');
        });
    }
};
