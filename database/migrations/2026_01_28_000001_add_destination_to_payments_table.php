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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('destination_type')->nullable()->after('payment_method_id');
            $table->unsignedBigInteger('destination_id')->nullable()->after('destination_type');

            $table->index(['destination_type', 'destination_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['destination_type', 'destination_id']);
            $table->dropColumn(['destination_type', 'destination_id']);
        });
    }
};
