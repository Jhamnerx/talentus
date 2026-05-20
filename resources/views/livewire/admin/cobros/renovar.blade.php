<x-form.modal.card title="Renovar Período" wire:model="modalOpen" blur width="2xl">
    <div class="space-y-4">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Registra el nuevo período de servicio prepago para este vehículo.
        </p>

        <div class="grid grid-cols-2 gap-4">
            <x-form.datetime.picker
                wire:model.live="fecha_inicio"
                label="Fecha Inicio"
                parse-format="YYYY-MM-DD"
                display-format="DD/MM/YYYY"
                without-time
            />
            <x-form.select
                wire:model.live="periodo"
                label="Período"
                :options="[
                    ['name' => 'Mensual',    'id' => 'MENSUAL'],
                    ['name' => 'Bimensual',  'id' => 'BIMENSUAL'],
                    ['name' => 'Trimestral', 'id' => 'TRIMESTRAL'],
                    ['name' => 'Semestral',  'id' => 'SEMESTRAL'],
                    ['name' => 'Anual',      'id' => 'ANUAL'],
                ]"
                option-label="name"
                option-value="id"
                :clearable="false"
            />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-form.datetime.picker
                wire:model="fecha_fin"
                label="Fecha Fin"
                parse-format="YYYY-MM-DD"
                display-format="DD/MM/YYYY"
                without-time
            />
            <x-form.select
                wire:model="divisa"
                label="Divisa"
                :options="[['name' => 'Soles (PEN)', 'id' => 'PEN'], ['name' => 'Dólares (USD)', 'id' => 'USD']]"
                option-label="name"
                option-value="id"
                :clearable="false"
            />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-form.input
                type="number"
                wire:model="monto"
                label="Monto"
                min="0"
                step="0.01"
            />
            <x-form.input
                type="number"
                wire:model="descuento"
                label="Descuento"
                min="0"
                step="0.01"
            />
        </div>

        <x-form.textarea
            wire:model="observaciones"
            label="Observaciones (opcional)"
            rows="2"
        />

        <div class="flex items-center gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
            <x-form.checkbox wire:model="cobrar_ahora" id="cobrar-ahora-check" />
            <label for="cobrar-ahora-check" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                Generar comprobante ahora
            </label>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="cerrar" />
            <x-form.button primary label="Renovar Período" wire:click="renovar" wire:loading.attr="disabled" spinner="renovar" />
        </div>
    </x-slot>
</x-form.modal.card>