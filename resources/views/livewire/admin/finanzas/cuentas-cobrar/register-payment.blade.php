<x-form.modal.card
    title="{{ $document ? 'Pagos de ' . ($document->serie_correlativo ?? ($document->serie_numero ?? '')) : 'Pagos' }}"
    wire:model="modalPayment" blur width="7xl">

    @if ($document)
        <!-- Info del documento -->
        <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center text-sm">
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Cliente:</span>
                    <span
                        class="text-gray-900 dark:text-gray-100 ml-2">{{ $document->cliente->razon_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Total:</span>
                    <span class="text-gray-900 dark:text-gray-100 ml-2 font-bold">{{ $document->divisa }}
                        {{ number_format($document->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="">
            <table class="min-w-full">
                <thead>
                    <tr
                        class="text-xs font-semibold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700">
                        <th class="px-2 py-2 text-left w-36">Fecha</th>
                        <th class="px-2 py-2 text-left w-32">Método</th>
                        <th class="px-2 py-2 text-left w-40">Destino</th>
                        <th class="px-2 py-2 text-right w-28">Monto</th>
                        <th class="px-2 py-2 text-center w-24">Estado</th>
                        <th class="px-2 py-2 text-center w-20"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    {{-- Pagos existentes --}}
                    @foreach ($existing_payments as $payment)
                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-gray-800/30 border-b border-gray-100 dark:border-gray-800">
                            <td class="px-2 py-2 text-sm text-gray-900 dark:text-gray-100">
                                {{ $payment['fecha'] }}
                            </td>
                            <td class="px-2 py-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ $payment['metodo'] }}
                            </td>
                            <td class="px-2 py-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ $payment['destino'] }}
                            </td>
                            <td class="px-2 py-2 text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $payment['monto'] }}
                            </td>
                            <td class="px-2 py-2 text-center">
                                <span
                                    class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    ✓ Recibido
                                </span>
                            </td>
                            <td class="px-2 py-2 text-center">
                                <button wire:click="deletePayment({{ $payment['id'] }})"
                                    wire:confirm="¿Eliminar este pago?"
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    {{-- Fila para nuevo pago --}}
                    @if ($showNewPaymentRow)
                        <tr class="bg-blue-50 dark:bg-blue-900/20 border-b-2 border-blue-200 dark:border-blue-700">

                            <td class="px-2 py-2">
                                <div class="w-38">
                                    <x-form.datetime.picker wire:model.defer="fecha" without-time
                                        parse-format="YYYY-MM-DD" placeholder="Fecha" />
                                </div>
                            </td>
                            <td class="px-2 py-2">
                                <div class="w-32">
                                    <x-form.select wire:model.defer="payment_method_id" placeholder="Método">
                                        @foreach ($paymentsMethods as $method)
                                            <x-select.option label="{{ $method->description }}"
                                                value="{{ $method->id }}" />
                                        @endforeach
                                    </x-form.select>
                                </div>
                            </td>
                            <td class="px-2 py-2">
                                <div class="w-40">
                                    @if ($this->paymentDestinations && $this->paymentDestinations->isNotEmpty())
                                        <x-form.select wire:model.defer="payment_destination_id"
                                            :options="$this->paymentDestinations->toArray()" option-label="description"
                                            option-value="id" placeholder="Seleccione destino" />
                                    @else
                                        <span class="text-gray-500 text-xs">Sin destinos</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 py-2">
                                <div class="w-28">
                                    <x-form.currency wire:model.defer="monto" placeholder="0.00" :prefix="$document->divisa ?? 'S/'" />
                                </div>
                            </td>
                            <td class="px-2 py-2 text-center">
                                <span
                                    class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                    Pendiente
                                </span>
                            </td>
                            <td class="px-2 py-2">
                                <div class="flex items-center justify-center gap-1">
                                    <button wire:click="save"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-green-100 dark:hover:bg-green-900/30 text-green-600 hover:text-green-700 dark:text-green-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    <button wire:click="cancelNewPayment"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 hover:text-gray-700 dark:text-gray-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-blue-50 dark:bg-blue-900/20">
                            <td colspan="7" class="px-2 py-2">
                                <x-form.input wire:model.defer="numero_operacion"
                                    placeholder="Referencia / N° Operación (opcional)" />
                            </td>
                        </tr>
                    @endif
                </tbody>

                {{-- Footer con totales --}}
                <tfoot class="bg-gray-50 dark:bg-gray-900/30 border-t-2 border-gray-200 dark:border-gray-700">
                    <tr class="text-sm">
                        <td colspan="4" class="px-2 py-2 text-right font-semibold text-gray-700 dark:text-gray-300">
                            Total Pagado:
                        </td>
                        <td class="px-2 py-2 text-right font-bold text-emerald-600 dark:text-emerald-400">
                            {{ $document->divisa }} {{ number_format($document->total - $total_pendiente, 2) }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr class="text-sm">
                        <td colspan="4" class="px-2 py-2 text-right font-semibold text-gray-700 dark:text-gray-300">
                            Pendiente de Pago:
                        </td>
                        <td class="px-2 py-2 text-right font-bold text-amber-600 dark:text-amber-400">
                            {{ $document->divisa }} {{ number_format($total_pendiente, 2) }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Botón para agregar nuevo pago --}}
        @if (!$showNewPaymentRow && $total_pendiente > 0)
            <div class="mt-3 px-3">
                <x-form.button primary icon="plus" label="Agregar Pago" wire:click="showNewPayment" full />
            </div>
        @endif
    @endif

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cerrar" wire:click="closeModal" />
        </div>
    </x-slot>
</x-form.modal.card>
