<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notificaciones_cobro', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable()->after('fecha_vencimiento')
                ->comment('Inicio del período facturado (snapshot del detalle al crear la notificación)');
            $table->date('fecha_fin')->nullable()->after('fecha_inicio')
                ->comment('Fin del período facturado (snapshot del detalle al crear la notificación)');
        });
    }

    public function down(): void
    {
        Schema::table('notificaciones_cobro', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'fecha_fin']);
        });
    }
};
