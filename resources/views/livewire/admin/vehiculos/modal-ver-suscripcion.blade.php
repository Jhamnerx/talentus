<x-form.modal.card title="📋 Suscripciones del Vehículo" wire:model.live="open" max-width="lg">

    @if ($open && $vehiculo)
        {{-- Cabecera del vehículo --}}
        <div class="mb-5 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-sky-100 dark:bg-sky-900/40 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8m0-11h2.586a1 1 0 01.707.293l3.414 3.414A1 1 0 0121 10v6l-2 1h-6" />
                    </svg>
                </div>
                <div>
                    <p class="text-base font-bold text-sky-600 dark:text-sky-400">{{ $vehiculo->placa }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                        @if ($vehiculo->cliente)
                            — <span
                                class="font-medium text-gray-700 dark:text-gray-300">{{ $vehiculo->cliente->razon_social }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @php
            $subscriptions = $vehiculo->planSubscriptions->sortByDesc('ends_at');
        @endphp

        @if ($subscriptions->isEmpty())
            <div class="text-center py-8">
                <svg class="mx-auto w-12 h-12 text-amber-400 mb-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sin suscripciones registradas</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Este vehículo no tiene ningún plan asignado.
                </p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($subscriptions as $sub)
                    @php
                        $activa = is_null($sub->canceled_at) && \Carbon\Carbon::parse($sub->ends_at)->isFuture();
                        $cancelada = !is_null($sub->canceled_at);
                        $vencida = !$activa && !$cancelada;

                        $badgeClass = match (true) {
                            $activa => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                            $cancelada => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                            default => 'bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400',
                        };
                        $badgeLabel = match (true) {
                            $activa => '✅ Activa',
                            $cancelada => '🚫 Cancelada',
                            default => '❌ Vencida',
                        };

                        $planNombre = null;
                        if ($sub->plan) {
                            $planNombre = is_array($sub->plan->name)
                                ? $sub->plan->name['es'] ?? ($sub->plan->name['en'] ?? 'Plan')
                                : $sub->plan->name;
                        }
                    @endphp

                    <div
                        class="rounded-lg border {{ $activa ? 'border-emerald-200 dark:border-emerald-700/50' : 'border-gray-200 dark:border-gray-700/60' }} p-3">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $planNombre ?? ($sub->name ?? 'Plan #' . $sub->plan_id) }}
                                </p>
                                @if ($sub->plan && $sub->plan->price)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        S/. {{ number_format($sub->plan->price, 2) }}
                                    </p>
                                @endif
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $badgeClass }} shrink-0">
                                {{ $badgeLabel }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs">
                            <div>
                                <span class="text-gray-400 dark:text-gray-500">Inicio:</span>
                                <span class="ml-1 text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $sub->starts_at ? \Carbon\Carbon::parse($sub->starts_at)->format('d/m/Y') : '—' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-gray-500">Vencimiento:</span>
                                <span
                                    class="ml-1 {{ $vencida ? 'text-red-500 font-semibold' : 'text-gray-700 dark:text-gray-300 font-medium' }}">
                                    {{ $sub->ends_at ? \Carbon\Carbon::parse($sub->ends_at)->format('d/m/Y') : '—' }}
                                </span>
                            </div>
                            @if ($sub->canceled_at)
                                <div class="col-span-2">
                                    <span class="text-gray-400 dark:text-gray-500">Cancelada:</span>
                                    <span class="ml-1 text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($sub->canceled_at)->format('d/m/Y') }}
                                    </span>
                                </div>
                            @endif
                            @if ($activa && $sub->ends_at)
                                <div class="col-span-2 mt-0.5">
                                    @php
                                        $diasRestantes = (int) \Carbon\Carbon::now()
                                            ->startOfDay()
                                            ->diffInDays(\Carbon\Carbon::parse($sub->ends_at)->startOfDay(), false);
                                    @endphp
                                    @if ($diasRestantes <= 7)
                                        <span class="text-amber-600 dark:text-amber-400 font-medium">
                                            ⚠️ Vence en {{ $diasRestantes }} día{{ $diasRestantes != 1 ? 's' : '' }}
                                        </span>
                                    @else
                                        <span class="text-emerald-600 dark:text-emerald-400">
                                            {{ $diasRestantes }} días restantes
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <x-slot name="footer">
        <div class="flex justify-end">
            <x-form.button flat label="Cerrar" wire:click="cerrar" />
        </div>
    </x-slot>

</x-form.modal.card>
