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
        Schema::create('global_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->string('destination_type')->nullable(); // Cash::class, BankAccount::class
            $table->unsignedBigInteger('payment_id');
            $table->string('payment_type'); // Payment::class, otros tipos futuros
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();

            // Índices para optimizar búsquedas polimórficas
            $table->index(['destination_id', 'destination_type'], 'destination_index');
            $table->index(['payment_id', 'payment_type'], 'payment_index');
            $table->index(['empresa_id', 'created_at']);

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_payments');
    }
};
