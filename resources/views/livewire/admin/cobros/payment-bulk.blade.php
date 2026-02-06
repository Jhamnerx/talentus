<x-form.modal.card title="REGISTRAR PAGO CONSOLIDADO" max-width="3xl" wire:model.live="modalPayment" align="center">

    <form autocomplete="off" autocapitalize="true">

        <div class="px-8 py-5 bg-white dark:bg-gray-800 sm:p-6">

            {{-- Resumen de vehículos seleccionados --}}
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Vehículos a Pagar:</h3>
                <div class="flex flex-wrap gap-2">
                    @if ($detalles)
                        @foreach ($detalles as $detalle)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ $detalle->vehiculo->placa ?? 'N/A' }} - S/.
                                {{ number_format($detalle->plan, 2) }}
                            </span>
                        @endforeach
                    @endif
                </div>
                <div class="mt-3 pt-3 border-t border-blue-200 dark:border-blue-700">
                    <div class="flex justify-between items-center">
                        <span class="text-blue-900 dark:text-blue-100 font-medium">Total a Pagar:</span>
                        <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $divisa }}
                            {{ number_format($monto, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">

                {{-- NUMERO --}}
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        for="numero">Número:
                        <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="text"
                            class="w-full form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                            wire:model.live='numero' disabled>
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                            <svg class="w-4 h-4 fill-current text-slate-400 dark:text-gray-500 shrink-0 ml-3 mr-2"
                                viewBox="0 0 16 16">
                                <path
                                    d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- TIPO PAGO --}}
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="tipo_pago">Tipo
                        Pago: <span class="text-rose-500">*</span></label>
                    <select id="tipo_pago" name="tipo_pago" wire:model.live="tipo_pago"
                        class="w-full form-select dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100">
                        <option value="FACTURA">Factura/Boleta</option>
                        <option value="RECIBO">Recibo</option>
                    </select>
                    @error('tipo_pago')
                        <p class="mt-2 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DOCUMENTO --}}
                <div class="col-span-12 sm:col-span-6">
                    <x-form.select wire:model.live="paymentable_id" label="{{ $titulo_documento }}"
                        placeholder="Selecciona">
                        @foreach ($documentos as $documento)
                            <x-select.option
                                label="{{ $documento['text'] }} - {{ $documento['divisa'] }} {{ $documento['total'] }}"
                                value="{{ $documento['id'] }}" />
                        @endforeach
                    </x-form.select>
                </div>

                {{-- METODO DE PAGO --}}
                <div class="col-span-12 sm:col-span-6">
                    <x-form.select wire:model.live="payment_method_id" label="Método de pago" placeholder="Selecciona">
                        @foreach ($paymentsMethods as $method)
                            <x-select.option label="{{ $method->description }}" value="{{ $method->id }}" />
                        @endforeach
                    </x-form.select>
                </div>

                {{-- ✅ NUEVO: Destino del Pago --}}
                <div class="col-span-12 sm:col-span-6">
                    <x-form.select label="Destino del Pago" wire:model.defer="payment_destination_id"
                        placeholder="Seleccione destino">
                        @if (count($availableCashes) > 0)
                            <x-select.option label="💰 Caja" value="cash" />
                        @endif
                        @foreach ($bankAccounts as $account)
                            <x-select.option label="🏦 {{ $account->description }} - {{ $account->currency_name }}"
                                value="{{ $account->id }}" />
                        @endforeach
                    </x-form.select>
                </div>

                {{-- AUTO RENOVAR --}}
                <div class="col-span-12">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/20 rounded-lg">
                        <div class="flex-1">
                            <label for="auto_renovar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Renovar automáticamente las fechas
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Al guardar el pago, se actualizarán las fechas según el período configurado
                            </p>
                        </div>
                        <x-form.toggle wire:model.live="auto_renovar" id="auto_renovar" />
                    </div>
                </div>

                {{-- MONTO --}}
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="monto_total">
                        Monto Total: <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" step="0.01" id="monto_total"
                            class="w-full form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                            wire:model.live='monto_total'>
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                            <span class="text-slate-400 dark:text-gray-500 ml-3 mr-2">{{ $divisa }}</span>
                        </div>
                    </div>
                    @error('monto_total')
                        <p class="mt-2 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NUMERO OPERACION --}}
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        for="numero_operacion">
                        Número de Operación:
                    </label>
                    <input type="text" id="numero_operacion"
                        class="w-full form-input focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                        wire:model.live='numero_operacion' placeholder="Ej: 0012345678">
                    @error('numero_operacion')
                        <p class="mt-2 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NOTA --}}
                <div class="col-span-12 mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="nota">
                        Nota / Observación:
                    </label>
                    <textarea id="nota" rows="3"
                        class="w-full form-textarea focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                        wire:model.live='nota' placeholder="Notas adicionales sobre este pago consolidado"></textarea>
                </div>

            </div>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
                <x-form.button primary label="Guardar Pago" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
