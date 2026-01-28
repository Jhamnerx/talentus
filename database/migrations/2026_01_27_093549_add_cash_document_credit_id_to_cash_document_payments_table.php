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
        Schema::table('cash_document_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('cash_document_credit_id')->nullable()->after('cash_document_id');

            $table->foreign('cash_document_credit_id')->references('id')->on('cash_document_credits')->onDelete('cascade');
            $table->index('cash_document_credit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_document_payments', function (Blueprint $table) {
            $table->dropForeign(['cash_document_credit_id']);
            $table->dropColumn('cash_document_credit_id');
        });
    }
};
