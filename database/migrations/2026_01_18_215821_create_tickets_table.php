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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->string('code', 20)->unique(); // TK-2026-000001
            $table->string('subject');
            $table->text('description');
            $table->string('status', 50)->index(); // enum: new, open, in_progress, waiting_customer, waiting_third_party, resolved, closed
            $table->string('priority', 20)->index(); // enum: low, medium, high, urgent
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('customer_id'); // FK a clientes
            $table->unsignedBigInteger('created_by'); // FK a users (quien creó)
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable(); // FK a users (agente asignado)
            $table->timestamp('last_activity_at')->nullable()->index();
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('ticket_categories')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');

            $table->index('customer_id');
            $table->index('team_id');
            $table->index('assigned_to');
            $table->index(['status', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
