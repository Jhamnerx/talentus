<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SincronizacionGpswoxNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $resumen;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $resumen)
    {
        $this->resumen = $resumen;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $totalActualizados = count($this->resumen['actualizados']);
        $totalNoEnLocal = count($this->resumen['no_en_local']);
        $totalNoEnGpswox = count($this->resumen['no_en_gpswox']);

        $mail = (new MailMessage)
            ->subject('Sincronización GPSWox Completada')
            ->greeting('¡Sincronización Finalizada!')
            ->line("Se ha completado la sincronización con GPSWox.")
            ->line('')
            ->line('**📊 Resumen:**')
            ->line("• Total dispositivos GPSWox (activos): **{$this->resumen['total_gpswox']}**")
            ->line("• Total vehículos locales: **{$this->resumen['total_local']}**")
            ->line("• Vehículos sin cambios: **{$this->resumen['sin_cambios']}**")
            ->line('');

        // Vehículos actualizados
        if ($totalActualizados > 0) {
            $mail->line("### ✅ Vehículos Actualizados ({$totalActualizados})");
            foreach (array_slice($this->resumen['actualizados'], 0, 10) as $actualizado) {
                $cambios = [];
                if (isset($actualizado['cambios']['imei'])) {
                    $cambios[] = "IMEI: {$actualizado['cambios']['imei']['anterior']} → {$actualizado['cambios']['imei']['nuevo']}";
                }
                if (isset($actualizado['cambios']['sim'])) {
                    $cambios[] = "SIM: {$actualizado['cambios']['sim']['anterior']} → {$actualizado['cambios']['sim']['nuevo']}";
                }
                $mail->line("• **{$actualizado['placa']}**: " . implode(', ', $cambios));
            }
            if ($totalActualizados > 10) {
                $mail->line("_... y " . ($totalActualizados - 10) . " más_");
            }
            $mail->line('');
        }

        // Vehículos no en local
        if ($totalNoEnLocal > 0) {
            $mail->line("### ⚠️ Dispositivos en GPSWox no encontrados localmente ({$totalNoEnLocal})");
            foreach (array_slice($this->resumen['no_en_local'], 0, 10) as $noLocal) {
                $mail->line("• **{$noLocal['placa']}** - IMEI: {$noLocal['imei']} | SIM: {$noLocal['sim']}");
            }
            if ($totalNoEnLocal > 10) {
                $mail->line("_... y " . ($totalNoEnLocal - 10) . " más_");
            }
            $mail->line('');
        }

        // Vehículos no en GPSWox
        if ($totalNoEnGpswox > 0) {
            $mail->line("### 🚫 Vehículos locales no encontrados en GPSWox ({$totalNoEnGpswox})");
            foreach (array_slice($this->resumen['no_en_gpswox'], 0, 10) as $noGpswox) {
                $mail->line("• **{$noGpswox['placa']}** (ID: {$noGpswox['id']})");
            }
            if ($totalNoEnGpswox > 10) {
                $mail->line("_... y " . ($totalNoEnGpswox - 10) . " más_");
            }
        }

        $mail->action('Ver Vehículos', url('/admin/vehiculos'))
            ->line('Gracias por usar nuestro sistema.');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $totalActualizados = count($this->resumen['actualizados']);
        $totalNoEnLocal = count($this->resumen['no_en_local']);
        $totalNoEnGpswox = count($this->resumen['no_en_gpswox']);

        $mensaje = "Sincronización GPSWox completada";
        
        if ($totalActualizados > 0) {
            $mensaje .= ": {$totalActualizados} actualizados";
        }
        if ($totalNoEnLocal > 0) {
            $mensaje .= ", {$totalNoEnLocal} no en local";
        }
        if ($totalNoEnGpswox > 0) {
            $mensaje .= ", {$totalNoEnGpswox} no en GPSWox";
        }

        return [
            'titulo' => 'Sincronización GPSWox',
            'mensaje' => $mensaje,
            'icono' => 'sync',
            'tipo' => 'info',
            'resumen' => $this->resumen,
            'url' => '/admin/vehiculos',
