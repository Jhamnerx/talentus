<?php

namespace Tests\Unit\Models;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrder;
use Tests\TestCase;

/**
 * Tests en memoria (sin BD): solo ejercitan la lógica de puedeEditarMensaje().
 * No usan RefreshDatabase, por lo que son seguros de ejecutar.
 */
class WorkOrderPuedeEditarMensajeTest extends TestCase
{
    private function orden(array $attrs): WorkOrder
    {
        $orden = new WorkOrder();
        $orden->wa_message_id = 'MSG123';
        $orden->wa_group_id   = '123-456@g.us';
        $orden->estado        = WorkOrderStatus::PENDIENTE;
        $orden->wa_sent_at    = now();

        foreach ($attrs as $key => $value) {
            $orden->{$key} = $value;
        }

        return $orden;
    }

    public function test_editable_dentro_de_la_ventana_y_estado_editable(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['wa_sent_at' => now()->subMinutes(5)]);

        $this->assertTrue($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_paso_la_ventana(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['wa_sent_at' => now()->subMinutes(20)]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_en_el_limite_exacto_de_la_ventana(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['wa_sent_at' => now()->subMinutes(14)]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_wa_sent_at_es_null(): void
    {
        $orden = $this->orden(['wa_sent_at' => null]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_no_hay_wa_message_id(): void
    {
        $orden = $this->orden(['wa_message_id' => null]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_estado_finalizado(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['estado' => WorkOrderStatus::FINALIZADO, 'wa_sent_at' => now()]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_estado_cancelado(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['estado' => WorkOrderStatus::CANCELADO, 'wa_sent_at' => now()]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_editable_en_proceso_dentro_de_la_ventana(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['estado' => WorkOrderStatus::EN_PROCESO, 'wa_sent_at' => now()->subMinutes(3)]);

        $this->assertTrue($orden->puedeEditarMensaje());
    }
}
