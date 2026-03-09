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
        Schema::create('cash_document_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_id');
            $table->unsignedBigInteger('payment_id'); // Tabla payments global
            $table->unsignedBigInteger('cash_document_id')->nullable();
            $table->unsignedBigInteger('cash_document_credit_id')->nullable();


            // Foreign keys
            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('cash_document_id')->references('id')->on('cash_documents')->onDelete('cascade');
            $table->foreign('cash_document_credit_id')->references('id')->on('cash_document_credits')->onDelete('cascade');

            // Indexes
            $table->index('cash_id');
            $table->index('payment_id');
            $table->index('cash_document_credit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_document_payments');
    }
};
