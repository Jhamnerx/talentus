<x-form.modal.card
    title="{{ $cobro?->vehiculo?->placa ? 'Períodos · ' . $cobro->vehiculo->placa : 'Historial de períodos' }}"
    wire:model="modalOpen"
    blur
    width="6xl">

    @if (!$cobro)
        <p class="text-sm text-gray-400 italic text-center py-6">Cargando...</p>
    @elseif (!$periodos || $periodos->isEmpty())
        <p class="text-sm text-gray-400 dark:text-gray-500 italic text-center py-6">
            Sin períodos registrados para este cobro.
        </p>
    @else
        {{-- Info del cobro --}}
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ $cobro->clientes?->razon_social ?? '—' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $cobro->plan?->name ?? '—' }}
                    @if ($cobro->vehiculo)
                        &middot; {{ $cobro->vehiculo->marca }} {{ $cobro->vehiculo->modelo }}
                    @endif
                </p>
            </div>
        </div>

        {{-- Grid de períodos --}}
        <div class="flex flex-wrap gap-3">
            @foreach ($periodos as $periodo)
                @php
                    $periodoDoc = $periodo->venta ?? $periodo->recibo;
                    $periodoDocLabel = $periodo->venta
                        ? ($periodo->venta->serie_correlativo ?? '—')
                        : ($periodo->recibo?->serie_numero ?? '—');
                    $borderColor = match ($periodo->estado) {
                        'PAGADO'     => 'border-emerald-300 dark:border-emerald-700',
                        'CANCELADO'  => 'border-gray-200 dark:border-gray-600',
                        'FACTURADO'  => 'border-blue-300 dark:border-blue-700',
                        default      => 'border-amber-300 dark:border-amber-700',
                    };
                    $bgColor = match ($periodo->estado) {
                        'PAGADO'     => 'bg-emerald-50 dark:bg-emerald-900/20',
                        'CANCELADO'  => 'bg-gray-50 dark:bg-gray-900/20',
                        'FACTURADO'  => 'bg-blue-50 dark:bg-blue-900/20',
                        default      => 'bg-amber-50 dark:bg-amber-900/10',
                    };
                    $badge = match ($periodo->estado) {
                        'PAGADO'     => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                        'CANCELADO'  => 'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-400',
                        'FACTURADO'  => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                        default      => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300',
                    };
                @endphp
                <div class="border-2 {{ $borderColor }} {{ $bgColor }} rounded-xl px-4 py-3 text-sm space-y-2 min-w-52 flex-1 max-w-[220px] shadow-xs">
                    {{-- Fechas + badge estado --}}
                    <div class="flex items-start justify-between gap-2">
                        <span class="font-semibold text-gray-800 dark:text-gray-100 leading-snug text-xs">
                            {{ $periodo->fecha_inicio?->format('d/m/Y') }}<br>
                            <span class="font-normal text-gray-400">→</span>
                            {{ $periodo->fecha_fin?->format('d/m/Y') }}
                        </span>
                        <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $badge }}">
                            {{ $periodo->estado }}
                        </span>
                    </div>
                    {{-- Tipo + período --}}
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $periodo->tipo }} &middot; {{ $periodo->periodo }}
                    </div>
                    {{-- Monto --}}
                    <div class="font-bold text-gray-900 dark:text-gray-100 text-sm">
                        {{ $periodo->divisa === 'USD' ? 'USD' : 'S/.' }}
                        {{ number_format($periodo->monto, 2) }}
                    </div>
                    {{-- Documento vinculado --}}
                    @if ($periodoDoc)
                        <div class="flex items-center gap-1.5 text-blue-600 dark:text-blue-400 pt-1.5 border-t border-blue-100 dark:border-blue-900/40">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-xs font-semibold">{{ $periodoDocLabel }}</span>
                        </div>
                    @elseif ($periodo->estado === 'PENDIENTE')
                        <button wire:click="generarDocumento({{ $periodo->id }})"
                            class="w-full flex items-center justify-center gap-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 pt-1.5 border-t border-indigo-100 dark:border-indigo-900/40 transition">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Generar doc
                        </button>
                    @else
                        <div class="text-xs text-gray-400 dark:text-gray-500 pt-1.5 border-t border-gray-100 dark:border-gray-700/50">
                            Sin documento
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if ($periodos->hasPages())
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                {{ $periodos->links() }}
            </div>
        @endif
    @endif

    <x-slot name="footer">
        <div class="flex justify-end">
            <x-form.button flat label="Cerrar" wire:click="$set('modalOpen', false)" />
        </div>
    </x-slot>
</x-form.modal.card>
