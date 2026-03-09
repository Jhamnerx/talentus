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
        Schema::create('ticket_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('actor_id')->nullable(); // user_id, null si es sistema
            $table->string('type', 50); // created, status_changed, priority_changed, assigned_changed, team_changed, message_added, internal_note, attachment_added, reopened, closed, resolved
            $table->json('payload'); // {before: ..., after: ..., ...}
            $table->timestamp('created_at')->index();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('actor_id')->references('id')->on('users')->onDelete('set null');

            $table->index('ticket_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_events');
    }
};
