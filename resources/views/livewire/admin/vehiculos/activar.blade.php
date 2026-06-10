<x-form.modal.card title="Activar Vehículo" wire:model.live="modalActivar" width="2xl">
    <div class="space-y-5">

        {{-- Cabecera --}}
        <div class="flex gap-3 items-start">
            <div
                class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/20">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Confirma la línea y dispositivos que se asignarán a
                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $vehiculo?->placa }}</span>
                    al reactivarlo.
                </p>
                @if ($vehiculo?->old_numero || $vehiculo?->old_sim_card || $vehiculo?->old_imei)
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                        Datos anteriores &mdash;
                        @if ($vehiculo->old_numero)
                            Línea: <b>{{ $vehiculo->old_numero }}</b>
                        @endif
                        @if ($vehiculo->old_sim_card)
                            &nbsp;| SIM: <b>{{ $vehiculo->old_sim_card }}</b>
                        @endif
                        @if ($vehiculo->old_imei)
                            &nbsp;| IMEI: <b>{{ $vehiculo->old_imei }}</b>
                        @endif
                    </p>
                @endif
            </div>
        </div>

        {{-- Aviso sin cobro --}}
        @if (!$tieneDetalleCobro)
            <div
                class="flex gap-2 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-3">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-400">Sin registro de cobro</p>
                    <p class="text-xs text-amber-600 dark:text-amber-500 mt-0.5">
                        Este vehículo no tiene un detalle de cobro asociado. Añade uno en
                        <strong>Cobros</strong> para generar notificaciones de facturación.
                    </p>
                </div>
            </div>
        @endif

        <hr class="border-gray-200 dark:border-gray-700">

        {{-- Línea / SIM --}}
        <div>
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Línea &amp; SIM Card</h4>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 sm:col-span-6">
                    <x-form.select autocomplete="off" label="Línea telefónica" placeholder="Número de línea..."
                        wire:model.live="numero" option-description="option_description" :async-data="route('api.lineas.index')" option-label="numero"
                        option-value="numero" />
                </div>
                <div class="col-span-12 sm:col-span-3">
                    <x-form.input wire:model="operador" label="Operador" readonly />
                </div>
                <div class="col-span-12 sm:col-span-3">
                    <x-form.input wire:model="sim_card" label="SIM Card" readonly />
                </div>
            </div>
        </div>

        {{-- Aviso número ocupado --}}
        @if ($numeroOcupadoPorPlaca)
            <div
                class="flex gap-2 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 p-3">
                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">Línea no disponible</p>
                    <p class="text-xs text-rose-600 dark:text-rose-500 mt-0.5">
                        El número <strong>{{ $numero }}</strong> ya está asignado al vehículo
                        <strong>{{ $numeroOcupadoPorPlaca }}</strong>.
                        Debes suspender ese vehículo primero para poder reutilizar esta línea.
                    </p>
                </div>
            </div>
        @endif

        <hr class="border-gray-200 dark:border-gray-700">
        <div>
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Dispositivos GPS</h4>

            <div class="mb-3">
                <x-form.select autocomplete="off" label="Agregar dispositivo por IMEI" placeholder="Buscar IMEI..."
                    wire:model.live="dispositivo_imei" option-description="option_description" :async-data="route('api.dispositivos.index')"
                    option-label="imei" option-value="imei" />
            </div>

            @if (count($dispositivos) > 0)
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">IMEI</th>
                                <th class="px-4 py-2">Modelo</th>
                                <th class="px-4 py-2 text-center">Principal</th>
                                <th class="px-4 py-2 text-center">Quitar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($dispositivos as $index => $disp)
                                <tr
                                    class="bg-white dark:bg-gray-800 {{ $dispositivo_principal === $index ? 'ring-1 ring-inset ring-emerald-400' : '' }}">
                                    <td class="px-4 py-2 font-mono text-xs">{{ $disp['imei'] }}</td>
                                    <td class="px-4 py-2">{{ $disp['modelo'] }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <input type="radio" name="dispositivo_principal"
                                            wire:click="marcarComoPrincipal({{ $index }})"
                                            {{ $dispositivo_principal === $index ? 'checked' : '' }}
                                            class="accent-emerald-500">
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <button type="button" wire:click="quitarDispositivo({{ $index }})"
                                            class="text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div
                    class="text-center py-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-sm text-gray-400 dark:text-gray-500">
                    No se han seleccionado dispositivos (opcional)
                </div>
            @endif
        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-2">
            <x-form.button flat label="Cancelar" x-on:click="close" />
            <x-form.button positive label="Confirmar y Activar" wire:click="activar" />
        </div>
    </x-slot>
</x-form.modal.card>
