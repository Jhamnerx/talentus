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
        Schema::create('expense_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('compras')->onDelete('cascade');
            $table->date('date_of_payment');
            $table->foreignId('expense_method_type_id')->constrained('expense_method_types');
            $table->boolean('has_card')->default(false);
            $table->unsignedBigInteger('card_brand_id')->nullable();
            $table->string('reference')->nullable()->comment('Número de referencia/operación');
            $table->decimal('payment', 12, 2);
            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index('expense_id');
            $table->index('date_of_payment');
            $table->index('expense_method_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_payments');
    }
};
