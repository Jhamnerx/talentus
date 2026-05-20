<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('ciudad_id')->nullable()->after('fcm_token');
            $table->string('wa_group_id')->nullable()->after('ciudad_id')
                ->comment('ID del grupo de WhatsApp del técnico (ej: 120363xxxxx@g.us)');

            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ciudad_id']);
            $table->dropColumn(['ciudad_id', 'wa_group_id']);
        });
    }
};
