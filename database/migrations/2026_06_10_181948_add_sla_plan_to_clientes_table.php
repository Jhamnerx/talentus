<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Anulada: el SLA dejó de derivarse de un campo en clientes.
     * Ahora se resuelve desde el plan del vehículo/cliente (plans.sla_tier).
     * Se conserva el archivo para no romper el historial de migraciones ya ejecutadas.
     */
    public function up(): void
    {
        //
    }

    public function down(): void
    {
        //
    }
};
