<div>
    <x-form.modal.card title="{{ $cashId ? 'Editar Caja Chica' : 'Aperturar Caja Chica' }}" wire:model="showModal" blur
        max-width="3xl">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Saldo Inicial PEN --}}
            <x-form.currency label="Saldo Inicial PEN *" placeholder="0.00" wire:model.live="saldo_inicial" prefix="S/"
                precision="2" thousands="," decimal="." />

            {{-- Saldo Inicial USD --}}
            <x-form.currency label="Saldo Inicial USD *" placeholder="0.00" wire:model.live="saldo_inicial_usd"
                prefix="$" precision="2" thousands="," decimal="." />

            {{-- Número de Referencia --}}
            <x-form.input label="Número de Referencia" placeholder="Ej: CAJ-001" wire:model.live="reference_number"
                maxlength="10" />

            {{-- Fecha de Apertura --}}
            <x-form.datetime.picker label="Fecha de Apertura *" wire:model.live="fecha_apertura" without-time />
        </div>

        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-start gap-3">
                <x-form.icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <p class="font-semibold mb-1">Caja Multi-Moneda</p>
                    <p>Esta caja registrará movimientos en <strong>Soles (PEN)</strong> y <strong>Dólares (USD)</strong>
                        por separado. Los saldos se actualizarán automáticamente según la moneda de cada transacción.
                    </p>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click="save" spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
