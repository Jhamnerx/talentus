<x-form.modal.card title="🔄 Sincronizar Suscripción" wire:model.live="open" max-width="lg">

    @if ($open && $detalle)
        @php
            $vehiculo = $detalle->vehiculo;
            $subActual = $vehiculo?->planSubscription('gps-tracking');
        @endphp

        {{-- Info vehículo --}}
        @if ($vehiculo)
            <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    🚗 {{ $vehiculo->placa }}
                    @if ($vehiculo->marca || $vehiculo->modelo)
                        <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                            — {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                        </span>
                    @endif
                </div>
                @if ($subActual)
                    <div
                        class="text-xs mt-1 {{ $subActual->active() ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                        Suscripción actual:
                        {{ $subActual->active() ? '✅ Activa' : '❌ Vencida' }}
                        @if ($subActual->ends_at)
                            — vence {{ \Carbon\Carbon::parse($subActual->ends_at)->format('d/m/Y') }}
                        @endif
                    </div>
                @else
                    <div class="text-xs mt-1 text-amber-600 dark:text-amber-400">
                        ⚠️ Sin suscripción registrada
                    </div>
                @endif
            </div>
        @endif

        {{-- Selector de plan --}}
        <div class="mb-4">
            <x-form.native.select label="Plan *" wire:model.live="planId">
                <option value="">— Seleccionar plan —</option>
                @foreach ($planes as $plan)
                    <option value="{{ $plan['id'] }}">{{ $plan['label'] }}</option>
                @endforeach
            </x-form.native.select>
            @error('planId')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fechas + botón avanzar período --}}
        <div class="grid grid-cols-2 gap-4 mb-2">
            <div>
                <x-form.input type="date" label="Fecha inicio" wire:model.live="startsAt" />
                @error('startsAt')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-form.input type="date" label="Fecha vencimiento *" wire:model.live="endsAt" />
                @error('endsAt')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
            Las fechas se toman del detalle de cobro. Ajústalas manualmente si es necesario.
        </p>
    @endif

    <x-slot name="footer">
        <div class="flex justify-end gap-3">
            <x-form.button flat label="Cancelar" wire:click="cerrar" />
            <x-form.button primary label="Sincronizar" wire:click="confirmar" wire:loading.attr="disabled"
                wire:target="confirmar" />
        </div>
    </x-slot>
</x-form.modal.card>
