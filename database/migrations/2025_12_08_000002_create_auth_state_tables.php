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
        // Auth state keys table - Compatible con mysql-baileys
        Schema::create('auth_states', function (Blueprint $table) {
            $table->string('session', 50); // session name
            $table->string('id', 100); // key identifier (creds, app-state-sync-key-*, etc.)
            $table->longText('value')->nullable(); // JSON data with BufferJSON support

            // Indices para optimización
            $table->unique(['session', 'id'], 'idxunique');
            $table->index('session', 'idxsession');
            $table->index('id', 'idxid');
        });

        // LID to PN mapping table
        Schema::create('lid_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('lid')->unique();
            $table->string('pn')->unique();
            $table->timestamps();

            $table->index(['lid', 'pn']);
        });

        // Message store for getMessage function
        Schema::create('message_store', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();
            $table->string('remote_jid', 150)->index();
            $table->string('message_id', 150)->index();
            $table->boolean('from_me')->default(false);
            $table->longText('message_data'); // JSON message object
            $table->timestamps();

            // Composite index sin unique para evitar error de longitud
            $table->index(['session_id', 'remote_jid', 'message_id', 'from_me'], 'msg_store_composite_idx');
        });

        // Group metadata cache
        Schema::create('group_metadata_cache', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('group_jid')->index();
            $table->text('metadata'); // JSON metadata
            $table->timestamp('cached_at');
            $table->timestamps();

            $table->unique(['session_id', 'group_jid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_states');
        Schema::dropIfExists('lid_mappings');
        Schema::dropIfExists('message_store');
        Schema::dropIfExists('group_metadata_cache');
    }
};
