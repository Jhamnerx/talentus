{{-- ── Resumen comercial ─────────────────────────────────────────── --}}
<div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Resumen comercial</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total facturado</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">S/ {{ number_format($resumenComercial['total_facturado'], 2) }}</p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total pagado</p>
            <p class="text-base font-semibold text-emerald-600">S/ {{ number_format($resumenComercial['total_pagado'], 2) }}</p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Deuda pendiente</p>
            <p class="text-base font-semibold {{ $resumenComercial['deuda_pendiente'] > 0 ? 'text-rose-600' : 'text-gray-800 dark:text-gray-100' }}">
                S/ {{ number_format($resumenComercial['deuda_pendiente'], 2) }}
            </p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Ticket promedio</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">S/ {{ number_format($resumenComercial['ticket_promedio'], 2) }}</p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Última compra</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                {{ $resumenComercial['ultima_venta']?->fecha_emision?->format('d/m/Y') ?? '—' }}
            </p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Cobros activos</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ $resumenComercial['cobros_activos'] }}</p>
        </div>
    </div>
</div>

{{-- ── Timeline ───────────────────────────────────────────────────── --}}
<div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Actividad reciente</h2>
    @if ($timeline->isNotEmpty())
        <ol class="relative border-l border-gray-200 dark:border-gray-800 ml-2 space-y-4">
            @foreach ($timeline as $event)
                <li wire:key="activity-{{ $event->id }}" class="relative ml-4">
                    <div class="absolute w-2 h-2 bg-emerald-500 rounded-full -left-1 mt-1.5"></div>
                    <time class="text-xs text-gray-400">{{ $event->created_at->format('d/m/Y H:i') }}</time>
                    <p class="text-sm text-gray-700 dark:text-gray-200">
                        {{ $event->description }}
                        <span class="text-gray-400">— {{ class_basename($event->subject_type) }}</span>
                    </p>
                </li>
            @endforeach
        </ol>
    @else
        <p class="text-sm text-gray-400">Sin actividad registrada.</p>
    @endif
</div>
