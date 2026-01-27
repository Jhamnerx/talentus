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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->string('description');
            $table->string('number');
            $table->string('cci')->nullable();
            $table->string('currency_type_id')->default('PEN'); // PEN o USD
            $table->boolean('status')->default(true);
            $table->decimal('initial_balance', 12, 2)->default(0.00);
            $table->boolean('show_in_documents')->default(true);
            $table->unsignedInteger('establishment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
