<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_brands', function (Blueprint $table) {
            $table->string('id', 2)->primary(); // Código de 2 caracteres
            $table->string('description', 100);
            $table->boolean('active')->default(true);
        });

        // Insertar marcas de tarjetas principales
        DB::table('card_brands')->insert([
            ['id' => '01', 'description' => 'Visa', 'active' => true],
            ['id' => '02', 'description' => 'Mastercard', 'active' => true],
            ['id' => '03', 'description' => 'American Express', 'active' => true],
            ['id' => '04', 'description' => 'Diners Club', 'active' => true],
            ['id' => '05', 'description' => 'Discover', 'active' => true],
            ['id' => '06', 'description' => 'UnionPay', 'active' => true],
            ['id' => '07', 'description' => 'JCB', 'active' => true],
            ['id' => '08', 'description' => 'Oh! (Banco de Crédito BCP)', 'active' => true],
            ['id' => '09', 'description' => 'Ripley', 'active' => true],
            ['id' => '10', 'description' => 'Cencosud', 'active' => true],
            ['id' => '99', 'description' => 'Otros', 'active' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_brands');
    }
};
