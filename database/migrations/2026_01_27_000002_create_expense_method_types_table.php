<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_method_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->boolean('has_card')->default(false)->comment('Indica si requiere tarjeta');
        });

        // Insertar registros iniciales
        DB::table('expense_method_types')->insert([
            ['id' => 1, 'description' => 'CAJA GENERAL', 'has_card' => false],
            ['id' => 2, 'description' => 'Tarjeta de crédito', 'has_card' => true],
            ['id' => 3, 'description' => 'Tarjeta de débito', 'has_card' => true],
            ['id' => 4, 'description' => 'Transferencia bancaria', 'has_card' => false],
            ['id' => 5, 'description' => 'Cheque', 'has_card' => false],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_method_types');
    }
};
