<x-form.modal.card title="Sincronizar Suscripción" wire:model.live="open" max-width="lg">

    @if ($open && $detalle)
        @php
            $vehiculo = $detalle->vehiculo;
            $subActual = $vehiculo?->planSubscription('gps-tracking');
        @endphp

        {{-- Tarjeta info del vehículo --}}
        @if ($vehiculo)
            <div
                class="mb-5 flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-3 dark:border-gray-600 dark:bg-gray-700/40">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/40">
                    <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m14.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        {{ $vehiculo->placa }}
                        @if ($vehiculo->marca || $vehiculo->modelo)
                            <span class="font-normal text-gray-500 dark:text-gray-400">
                                — {{ trim($vehiculo->marca . ' ' . $vehiculo->modelo) }}
                            </span>
                        @endif
                    </p>
                    @if ($subActual)
                        <p
                            class="mt-0.5 text-xs {{ $subActual->active() ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                            {{ $subActual->active() ? 'Suscripción activa' : 'Suscripción vencida' }}
                            @if ($subActual->ends_at)
                                — vence {{ \Carbon\Carbon::parse($subActual->ends_at)->format('d/m/Y') }}
                            @endif
                        </p>
                    @else
                        <p class="mt-0.5 text-xs text-amber-600 dark:text-amber-400">
                            Sin suscripción registrada
                        </p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Plan --}}
        <div class="mb-4">
            <x-form.select label="Plan *" placeholder="Seleccionar plan..." wire:model.live="planId" :options="$planes"
                option-label="label" option-value="id" :clearable="false" />
        </div>

        {{-- Fechas --}}
        <div class="mb-4 grid grid-cols-2 gap-4">
            <x-form.datetime.picker label="Fecha inicio" wire:model.live="startsAt" without-time
                display-format="DD/MM/YYYY" />
            <x-form.datetime.picker label="Fecha vencimiento *" wire:model.live="endsAt" without-time
                display-format="DD/MM/YYYY" />
        </div>

        <p class="text-xs text-gray-400 dark:text-gray-500">
            Las fechas se toman del detalle de cobro. Ajústalas manualmente si es necesario.
        </p>
    @endif

    <x-slot name="footer">
        <div class="flex justify-end gap-3">
            <x-form.button flat label="Cancelar" wire:click="cerrar" />
            <x-form.button primary label="Sincronizar" wire:click="confirmar" wire:loading.attr="disabled"
                wire:target="confirmar" spinner="confirmar" />
        </div>
    </x-slot>

</x-form.modal.card>
