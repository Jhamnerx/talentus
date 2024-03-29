<?php

use App\Models\PaymentMethods;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {

            $table->id();
            $table->string('serie')->nullable();
            $table->string('numero')->nullable();
            $table->string('serie_numero')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');

            $table->string('divisa')->default('PEN');
            //$table->string('tipo_pago');
            $table->enum('estado', ['BORRADOR', 'COMPLETADO'])->default('BORRADOR');
            $table->enum('pago_estado', ['UNPAID', 'PAID'])->default('UNPAID');


            $table->unsignedBigInteger('forma_pago')->nullable();
            $table->date('fecha_pago')->nullable();

            $table->decimal('sub_total', 10, 2);
            $table->decimal('impuesto', 10, 2)->nullable();
            $table->decimal('total', 10, 2);

            $table->enum('tipo_venta', ['CONTADO', 'CREDITO'])->default('CONTADO');
            $table->decimal('adelanto', 15, 2)->nullable();
            $table->integer('numero_cuotas')->nullable();
            $table->integer('vence_cuotas')->nullable();
            $table->text('detalle_cuotas')->nullable();


            $table->boolean('is_active')->default(true);
            $table->string('nota')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('descuento', 15, 2)->nullable();
            $table->unsignedBigInteger('descuento_val')->nullable();

            $table->boolean('sent')->default(false);
            $table->boolean('viewed')->default(false);
            $table->string('unique_hash')->nullable();

            $table->unsignedBigInteger('presupuestos_id')->nullable();
            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('presupuestos_id')->references('id')->on('presupuestos')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('forma_pago')->references('id')->on('payment_methods')->onDelete('set null');




            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
