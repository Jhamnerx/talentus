<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // ID del mensaje de WhatsApp devuelto por el servidor Node
            // Ej: "3EB0B0D42F4A8E42EA08E7"
            $table->string('wa_message_id', 60)->nullable()->after('metadata')
                ->comment('ID del mensaje WA enviado al grupo del técnico');

            // JID del grupo al que se envió (para futuros mensajes de seguimiento)
            $table->string('wa_group_id', 100)->nullable()->after('wa_message_id')
                ->comment('JID del grupo WA del técnico al momento del envío');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['wa_message_id', 'wa_group_id']);
        });
    }
};
