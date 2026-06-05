<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->tinyInteger('calificacion_cliente')->nullable()
                ->after('observaciones_inicial')
                ->comment('Calificación del cliente 1-5 estrellas');
            $table->text('comentario_cliente')->nullable()->after('calificacion_cliente');
            $table->timestamp('calificado_at')->nullable()->after('comentario_cliente');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['calificacion_cliente', 'comentario_cliente', 'calificado_at']);
        });
    }
};
