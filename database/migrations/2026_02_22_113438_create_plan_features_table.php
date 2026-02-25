<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('laravel-subscriptions.tables.features'), function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(config('laravel-subscriptions.models.plan'));
            $table->json('name');
            $table->string('slug');
            $table->json('description')->nullable();
            $table->string('value');
            $table->unsignedSmallInteger('resettable_period')->default(0);
            $table->string('resettable_interval')->default('month');
            $table->unsignedMediumInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Índice único para plan_id + slug
            $table->unique(['plan_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('laravel-subscriptions.tables.features'));
    }
};
