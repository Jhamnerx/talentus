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
        Schema::table('plans', function (Blueprint $table) {
            $table->decimal('price', 15, 4)->default('0.0000')->change();
            $table->decimal('signup_fee', 15, 4)->default('0.0000')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->default('0.00')->change();
            $table->decimal('signup_fee', 8, 2)->default('0.00')->change();
        });
    }
};
