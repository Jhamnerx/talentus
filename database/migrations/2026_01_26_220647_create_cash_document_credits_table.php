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
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->timestamps();

            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
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
