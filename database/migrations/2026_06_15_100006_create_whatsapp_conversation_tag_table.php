<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_conversation_tag', function (Blueprint $table) {
            $table->foreignId('whatsapp_conversation_id')->constrained('whatsapp_conversations')->cascadeOnDelete();
            $table->foreignId('whatsapp_tag_id')->constrained('whatsapp_tags')->cascadeOnDelete();
            $table->primary(['whatsapp_conversation_id', 'whatsapp_tag_id'], 'wa_conv_tag_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_conversation_tag');
    }
};
