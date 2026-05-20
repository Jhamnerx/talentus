<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('verification_hash', 64)->nullable()->unique()->after('bloqueado');
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->nullable()->after('verification_hash');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->text('verification_notes')->nullable()->after('verified_at');
        });

        // Generar hash para órdenes existentes
        \DB::table('work_orders')->whereNull('verification_hash')->orderBy('id')->each(function ($row) {
            \DB::table('work_orders')->where('id', $row->id)->update([
                'verification_hash' => Str::random(32),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['verification_hash', 'verification_status', 'verified_at', 'verification_notes']);
        });
    }
};
