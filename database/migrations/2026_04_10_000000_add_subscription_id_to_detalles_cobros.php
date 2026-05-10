<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id')->nullable()->after('plan_id');

            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions')
                ->nullOnDelete();
        });

        // Backfill: vincular detalles existentes a la suscripción 'gps-tracking' de su vehículo.
        // Situación antes de esta migración: todos los detalles de un mismo vehículo comparten
        // una sola suscripción con slug 'gps-tracking'. Los dejamos apuntando a esa suscripción;
        // los detalles nuevos (post-migración) recibirán suscripciones propias (slug 'detalle-{id}').
        DB::statement("
            UPDATE detalles_cobros AS dc
            INNER JOIN subscriptions AS s
                ON  s.subscriber_type = 'App\\\\Models\\\\Vehiculos'
                AND s.subscriber_id   = dc.vehiculo_id
                AND s.slug            = 'gps-tracking'
                AND s.deleted_at      IS NULL
            SET dc.subscription_id = s.id
            WHERE dc.deleted_at       IS NULL
              AND dc.vehiculo_id      IS NOT NULL
              AND dc.subscription_id  IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->dropColumn('subscription_id');
        });
    }
};
