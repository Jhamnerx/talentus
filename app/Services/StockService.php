<?php

namespace App\Services;

use App\Models\Comprobantes;
use App\Models\Dispositivos;
use App\Models\Productos;
use App\Models\Recibos;
use App\Models\Ventas;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Fuente única de verdad para el control de stock de productos enlazados a
 * dispositivos GPS (vía modelo_id) y para las reversiones de ventas/recibos/notas.
 *
 * Reglas:
 *  - Un dispositivo de la empresa (of_client = false) cuenta como +1 de stock del
 *    producto con su mismo modelo_id al ingresar al catálogo.
 *  - Sale del stock (-1) al venderse, al eliminarse, o al instalarse en un vehículo
 *    (sincronización desde GPSWox / Fota).
 *  - Al anular una venta, eliminar un recibo o emitir una nota de crédito de
 *    devolución, el stock y los dispositivos vuelven a STOCK.
 */
class StockService
{
    /**
     * Motivos SUNAT de nota de crédito que devuelven mercadería al inventario.
     *
     * @var array<int, string>
     */
    public const MOTIVOS_NOTA_DEVUELVEN_STOCK = ['01', '06', '07'];

    /**
     * Suma stock cuando ingresa un dispositivo de la empresa al catálogo.
     */
    public function registrarIngresoDispositivo(Dispositivos $dispositivo): void
    {
        if ($dispositivo->of_client) {
            return;
        }

        $this->ajustarStockProducto($dispositivo, 1);
    }

    /**
     * Resta stock cuando un dispositivo de la empresa que estaba disponible
     * desaparece del catálogo (eliminación).
     */
    public function registrarSalidaDispositivo(Dispositivos $dispositivo): void
    {
        if ($dispositivo->of_client || $dispositivo->estado !== Dispositivos::STOCK) {
            return;
        }

        $this->ajustarStockProducto($dispositivo, -1);
    }

    /**
     * Marca un dispositivo como VENDIDO y descuenta su stock al instalarse en un
     * vehículo (sincronización desde GPSWox / Fota).
     *
     * Idempotente: no hace nada si ya estaba vendido o es del cliente.
     *
     * @return bool true si realizó el descuento.
     */
    public function marcarVendidoPorInstalacion(Dispositivos $dispositivo): bool
    {
        if ($dispositivo->of_client || $dispositivo->estado !== Dispositivos::STOCK) {
            return false;
        }

        $dispositivo->update(['estado' => Dispositivos::VENDIDO]);
        $this->ajustarStockProducto($dispositivo, -1);

        Log::info("[Stock] Dispositivo #{$dispositivo->id} marcado VENDIDO por instalación en vehículo.");

        return true;
    }

    /**
     * Marca dispositivos como VENDIDO por una venta/recibo.
     *
     * El stock del producto ya lo descuenta `createItems` por la cantidad de línea;
     * aquí solo se cambia el estado (de STOCK a VENDIDO).
     *
     * @param  iterable<int, mixed>  $dispositivoIds
     */
    public function marcarVendidos(iterable $dispositivoIds): void
    {
        $ids = collect($dispositivoIds)->filter()->unique()->values();

        if ($ids->isEmpty()) {
            return;
        }

        Dispositivos::withoutGlobalScope(EmpresaScope::class)
            ->whereIn('id', $ids)
            ->where('estado', Dispositivos::STOCK)
            ->update(['estado' => Dispositivos::VENDIDO]);
    }

    /**
     * Devuelve dispositivos a STOCK (cambio de estado únicamente, sin tocar el stock
     * del producto). Útil al editar un comprobante y quitar dispositivos.
     *
     * @param  iterable<int, mixed>  $dispositivoIds
     */
    public function devolverADisponible(iterable $dispositivoIds): void
    {
        $ids = collect($dispositivoIds)->filter()->unique()->values();

        if ($ids->isEmpty()) {
            return;
        }

        Dispositivos::withoutGlobalScope(EmpresaScope::class)
            ->whereIn('id', $ids)
            ->where('estado', Dispositivos::VENDIDO)
            ->update(['estado' => Dispositivos::STOCK]);
    }

    /**
     * Revierte una venta: dispositivos vendidos vuelven a STOCK y se restaura el
     * stock de los productos físicos vendidos.
     */
    public function revertirVenta(Ventas $venta): void
    {
        DB::transaction(function () use ($venta) {
            $detalles = $venta->ventaDetalles;
            $this->revertirDispositivos($detalles->pluck('imeis'));
            $this->restaurarStockProductos($detalles);
        });
    }

    /**
     * Revierte un recibo: dispositivos vendidos vuelven a STOCK y se restaura el
     * stock de los productos físicos.
     */
    public function revertirRecibo(Recibos $recibo): void
    {
        DB::transaction(function () use ($recibo) {
            $detalles = $recibo->detalles;
            $this->revertirDispositivos($detalles->pluck('imeis'));
            $this->restaurarStockProductos($detalles);
        });
    }

    /**
     * Revierte el stock de la venta referenciada por una nota de crédito de
     * devolución. La nota no almacena detalle por línea, por lo que se revierte
     * la venta original completa.
     */
    public function revertirNotaCredito(Comprobantes $nota): void
    {
        $venta = $nota->venta;

        if ($venta) {
            $this->revertirVenta($venta);
        }
    }

    /**
     * Indica si el motivo (sustento) de una nota de crédito devuelve mercadería.
     */
    public function motivoDevuelveStock(?string $sustentoId): bool
    {
        return in_array($sustentoId, self::MOTIVOS_NOTA_DEVUELVEN_STOCK, true);
    }

    /**
     * Devuelve a STOCK los dispositivos cuyos IDs estén en las listas de imeis dadas.
     *
     * @param  Collection<int, mixed>  $listasImeis  Colección de arrays de IDs de dispositivos.
     */
    protected function revertirDispositivos(Collection $listasImeis): void
    {
        $ids = $listasImeis
            ->flatMap(fn($imeis) => is_array($imeis) ? $imeis : [])
            ->filter()
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return;
        }

        Dispositivos::withoutGlobalScope(EmpresaScope::class)
            ->whereIn('id', $ids)
            ->where('estado', Dispositivos::VENDIDO)
            ->update(['estado' => Dispositivos::STOCK]);
    }

    /**
     * Incrementa el stock de los productos físicos de un conjunto de detalles.
     *
     * @param  Collection<int, mixed>  $detalles  Detalles de venta o recibo (con producto_id y cantidad).
     */
    protected function restaurarStockProductos(Collection $detalles): void
    {
        foreach ($detalles as $detalle) {
            if (!$detalle->producto_id) {
                continue;
            }

            Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('id', $detalle->producto_id)
                ->where('tipo', 'producto')
                ->increment('stock', $detalle->cantidad);
        }
    }

    /**
     * Ajusta el stock del producto enlazado al modelo del dispositivo.
     */
    protected function ajustarStockProducto(Dispositivos $dispositivo, int $delta): void
    {
        if (!$dispositivo->modelo_id) {
            return;
        }

        $producto = Productos::withoutGlobalScope(EmpresaScope::class)
            ->where('modelo_id', $dispositivo->modelo_id)
            ->where('empresa_id', $dispositivo->empresa_id)
            ->where('tipo', 'producto')
            ->first();

        if (!$producto) {
            Log::warning("[Stock] No hay producto para modelo #{$dispositivo->modelo_id} (dispositivo #{$dispositivo->id}); stock no ajustado.");
            return;
        }

        if ($delta >= 0) {
            $producto->increment('stock', $delta);
        } else {
            $producto->decrement('stock', abs($delta));
        }
    }
}
