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
        Schema::create('cash_document_credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_id');
            $table->unsignedBigInteger('cash_id_processed')->nullable();
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->string('status', 15)->default('PENDING'); // PENDING, PROCESSED
            $table->timestamps();

            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
            $table->foreign('cash_id_processed')->references('id')->on('cash')->onDelete('set null');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_document_credits');
    }
};
