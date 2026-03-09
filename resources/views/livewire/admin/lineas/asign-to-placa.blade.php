<x-form.modal.card title="🚗 ASIGNAR LÍNEA A VEHÍCULO" wire:model.live="openModal" align="center" max-width="4xl">
    <!-- Info de la línea -->
    <div
        class="mb-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-gray-600 dark:text-gray-400">📱 Línea:</span>
                <span
                    class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $linea ? $linea->numero : '' }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-gray-600 dark:text-gray-400">💳 SIM Card:</span>
                <span
                    class="text-base font-medium text-indigo-600 dark:text-indigo-400">{{ $linea ? $linea->sim_card->sim_card : '' }}</span>
            </div>
        </div>
    </div>


    @if ($asignado)
        <!-- Advertencia de vehículo asignado -->
        <div class="mb-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-300 dark:border-amber-700">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-amber-800 dark:text-amber-200 font-medium">
                    Esta línea ya está asignada a un vehículo. Debes removerla primero.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto mb-4">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700 border-t border-b border-slate-200 dark:border-slate-600">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">PLACA</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">CLIENTE</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">ACCIÓN</div>
                        </th>
                    </tr>
                </thead>

                <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">

                    <tr class="bg-white dark:bg-slate-800">
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left font-medium text-sky-500 dark:text-sky-400">
                                🚗 {{ $linea->sim_card->vehiculos->placa }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left text-gray-900 dark:text-gray-100">
                                {{ $linea->sim_card->vehiculos->cliente ? $linea->sim_card->vehiculos->cliente->razon_social : '' }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex gap-2">
                                @if ($confirm)
                                    <x-form.button wire:click.prevent="confirmation()" icon="exclamation-circle" warning
                                        label="Confirmar" />
                                @else
                                    <x-form.button wire:click.prevent="removeLinea()" icon="x-mark" negative
                                        label="Remover Línea" />
                                @endif
                            </div>
                        </td>
                    </tr>
                    @if ($confirm)
                        <tr class="bg-rose-50 dark:bg-rose-900/20">
                            <td colspan="3" class="px-4 py-3">
                                <div class="space-y-1">
                                    <p class="text-sm font-semibold text-rose-600 dark:text-rose-400">
                                        ⚠️ Confirma la acción haciendo click nuevamente en el botón
                                    </p>
                                    <p class="text-xs text-rose-700 dark:text-rose-300">
                                        Se guardará el historial de la línea en el vehículo y se desvinculará.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    @else
        <!-- Selector de vehículo -->
        <div class="space-y-2">
            <x-form.select id="vehiculo_id" name="vehiculo_id" label="🚗 Selecciona un vehículo"
                wire:model.live="vehiculo_id" placeholder="Busca por placa..." :async-data="[
                    'api' => route('api.vehiculos.index'),
                ]" option-label="placa"
                option-value="id" />
            <p class="text-xs text-gray-500 dark:text-gray-400">
                La línea se vinculará al vehículo seleccionado
            </p>
        </div>
    @endif
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" class="{{ $asignado ? 'hidden' : '' }}" wire:click="asign" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
    <script></script>
@endpush
