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
        Schema::table('clientes', function (Blueprint $table) {
            $table->text('ubigeo')->nullable()->after('is_active');
            $table->string('tipo_documento_id')->nullable()->after('is_active');
            $table->foreign('tipo_documento_id')->references('codigo')->on('tipo_documentos')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('ultima_compra')->nullable()->after('is_active');
            $table->string('compras')->default('0')->after('is_active');
            $table->boolean('estado')->default(true)->after('is_active');
            $table->foreignId('user_id')->after('is_active')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
};
