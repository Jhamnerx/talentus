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
        Schema::create('autoreplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('device');
            $table->string('keyword');
            $table->enum('type_keyword', ['Equal', 'Contain'])->default('Equal');
            $table->enum('type', ['text', 'image']);
            $table->json('reply');
            $table->enum('reply_when', ['Group', 'Personal', 'All'])->default('All');
            $table->boolean('status')->default(true);
            $table->boolean('is_quoted')->default(false);
            $table->timestamps();


            $table->index('device');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autoreplies');
    }
};
