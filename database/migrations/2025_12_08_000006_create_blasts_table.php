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
        Schema::create('blasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('sender');
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('receiver');
            $table->json('message');
            $table->enum('type', ['text', 'button', 'image', 'template', 'list']);
            $table->enum('status', ['failed', 'success', 'pending'])->default('pending');
            $table->timestamps();

            $table->index(['campaign_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blasts');
    }
};
