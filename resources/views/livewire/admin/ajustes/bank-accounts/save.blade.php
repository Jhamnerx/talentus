<div>
    <x-form.modal.card title="{{ $account_id ? 'Editar Cuenta Bancaria' : 'Nueva Cuenta Bancaria' }}"
        wire:model="showModal" blur max-width="2xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Banco -->
            <x-form.select label="Banco" wire:model="bank_id" placeholder="Seleccione un banco">
                @foreach ($banks as $bank)
                    <x-select.option label="{{ $bank->description }}" value="{{ $bank->id }}" />
                @endforeach
            </x-form.select>

            <!-- Descripción -->
            <x-form.input label="Descripción" wire:model="description" placeholder="Ej: Cuenta de ahorros" />

            <!-- Número de cuenta -->
            <x-form.input label="Número de Cuenta" wire:model="number" placeholder="0000-0000-0000-0000" />

            <!-- CCI -->
            <x-form.input label="CCI (Opcional)" wire:model="cci" placeholder="Código de cuenta interbancario" />

            <!-- Moneda -->\n <x-form.native.select label="Moneda" wire:model="currency_type_id">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                @endforeach
            </x-form.native.select>

            <!-- Saldo inicial -->
            <x-form.currency label="Saldo Inicial" wire:model="initial_balance" />

            <!-- Establecimiento (opcional) -->
            <div class="md:col-span-2">
                <x-form.input label="ID Establecimiento (Opcional)" wire:model="establishment_id" type="number" />
            </div>

            <!-- Checkboxes -->
            <div class="md:col-span-2 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <x-form.checkbox wire:model="status" id="account-status" />
                    <label for="account-status" class="text-sm text-gray-700 dark:text-gray-300">Cuenta activa</label>
                </div>

                <div class="flex items-center gap-2">
                    <x-form.checkbox wire:model="show_in_documents" id="show-in-docs" />
                    <label for="show-in-docs" class="text-sm text-gray-700 dark:text-gray-300">Mostrar cuenta en los
                        reportes de comprobantes</label>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
