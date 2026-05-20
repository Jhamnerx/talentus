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
        Schema::create('message_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('number');
            $table->string('type');
            $table->text('message')->collation('utf8mb4_unicode_ci');
            $table->json('payload');
            $table->enum('status', ['success', 'failed']);
            $table->enum('send_by', ['api', 'web']);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->index(['device_id', 'created_at']);
            $table->index('number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_histories');
    }
};
