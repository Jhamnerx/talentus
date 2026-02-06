<x-form.modal.card title="REGISTRAR PAGO" wire:model.live="modalSave" blur width="2xl">
    <div class="grid grid-cols-12 gap-4">

        <!-- Número -->
        <div class="col-span-12 md:col-span-6">
            <x-form.input label="Número" wire:model="numero" readonly />
        </div>

        <!-- Fecha -->
        <div class="col-span-12 md:col-span-6">
            <x-form.datetime.picker label="Fecha" wire:model.defer="fecha" without-time parse-format="YYYY-MM-DD" />
        </div>

        <!-- Tipo de Pago -->
        <div class="col-span-12 md:col-span-6">
            <x-form.select label="Tipo Pago" wire:model.live="tipo_pago" :clearable="false">
                <x-select.option label="FACTURA" value="FACTURA" />
                <x-select.option label="RECIBO" value="RECIBO" />
            </x-form.select>
        </div>

        <!-- Documento -->
        <div class="col-span-12 md:col-span-6">

            <x-form.select label="{{ $titulo_documento }}" wire:model.live="paymentable_id"
                placeholder="Seleccione un documento">
                @foreach ($documentos as $documento)
                    <x-select.option label="{{ $documento['text'] }}" value="{{ $documento['id'] }}" />
                @endforeach
            </x-form.select>
        </div>

        <!-- Método de Pago -->
        <div class="col-span-12 md:col-span-6">
            <x-form.select label="Método de Pago" wire:model.live="payment_method_id" placeholder="Seleccione un método"
                :options="$paymentMethods" option-label="description" option-value="id" />
        </div>

        <!-- ✅ NUEVO: Destino del Pago (Caja o Cuenta Bancaria) -->
        <div class="col-span-12 md:col-span-6">
            <x-form.select label="Destino del Pago" wire:model.defer="payment_destination_id"
                placeholder="Seleccione destino">
                @if (count($availableCashes) > 0)
                    <x-select.option label="💰 Caja" value="cash" />
                @endif
                @foreach ($bankAccounts as $account)
                    <x-select.option
                        label="🏦 {{ $account->description }} - {{ $account->currency_name }} ({{ $account->number }})"
                        value="{{ $account->id }}" />
                @endforeach
            </x-form.select>
            <p class="text-xs text-gray-500 mt-1">
                @if (count($availableCashes) == 0 && count($bankAccounts) == 0)
                    ⚠️ No hay cajas ni cuentas disponibles
                @else
                    Seleccione si el dinero va a Caja o a una Cuenta Bancaria específica
                @endif
            </p>
        </div>

        <!-- Cuenta Bancaria (solo si es depósito) - MANTENER POR COMPATIBILIDAD -->
        @if ($showBankAccountSelector)
            <div class="col-span-12 md:col-span-6">
                <x-form.select label="Cuenta Bancaria" wire:model.defer="bank_account_id"
                    placeholder="Seleccione una cuenta">
                    @foreach ($bankAccounts as $account)
                        <x-select.option
                            label="{{ $account->bank->name }} - {{ $account->number }} ({{ $account->currency_type_id }})"
                            value="{{ $account->id }}" />
                    @endforeach
                </x-form.select>
            </div>
        @endif

        <!-- Número de Operación -->
        <div class="col-span-12 md:col-span-6">
            <x-form.input label="Número de Operación" wire:model.defer="numero_operacion" />
        </div>

        <!-- Divisa -->
        <div class="col-span-12 md:col-span-4">
            <x-form.select label="Divisa" wire:model.defer="divisa" :disabled="$divisaDoc ? true : false">
                <x-select.option label="Soles (PEN)" value="PEN" />
                <x-select.option label="Dólares (USD)" value="USD" />
            </x-form.select>
        </div>

        <!-- Monto -->
        <div class="col-span-12 md:col-span-8">
            <x-form.currency label="Monto" wire:model.defer="monto" thousands="," decimal="." />
        </div>

        <!-- Información de Saldo (si hay documento seleccionado) -->
        @if ($paymentable_id && $totalDocumento > 0)
            <div class="col-span-12">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Total Documento:</span>
                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $divisaDoc }} {{ number_format($totalDocumento, 2) }}
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Pagos Previos:</span>
                            <div class="font-semibold text-orange-600 dark:text-orange-400">
                                {{ $divisaDoc }} {{ number_format($pagosPrevios, 2) }}
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Saldo Pendiente:</span>
                            <div class="font-semibold text-green-600 dark:text-green-400">
                                {{ $divisaDoc }} {{ number_format($saldoPendiente, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkbox para marcar como pagado -->
            <div class="col-span-12">
                <label class="flex items-center">
                    <x-form.checkbox wire:model.defer="marcar_como_pagado" id="marcar_como_pagado" />
                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Marcar documento como PAGADO (completar pago)
                    </span>
                </label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-6">
                    Al activar esta opción, el documento se marcará como pagado completamente
                </p>
            </div>
        @endif

        <!-- Nota -->
        <div class="col-span-12">
            <x-form.textarea label="Nota" wire:model.defer="nota" placeholder="Observaciones del pago"
                rows="3" />
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Guardar" wire:click="save" spinner="save" />
        </div>
    </x-slot>
</x-form.modal.card>
