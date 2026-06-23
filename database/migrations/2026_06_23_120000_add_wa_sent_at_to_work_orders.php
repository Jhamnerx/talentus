<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Momento en que se envió el wa_message_id actual.
            // Sirve para saber si aún estamos dentro de la ventana de edición de WhatsApp.
            $table->timestamp('wa_sent_at')->nullable()->after('wa_group_id')
                ->comment('Cuándo se envió el wa_message_id actual (ventana de edición WA)');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('wa_sent_at');
        });
    }
};
