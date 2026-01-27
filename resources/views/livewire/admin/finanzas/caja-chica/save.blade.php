<div>
    <x-form.modal.card title="{{ $cashId ? 'Editar Caja Chica' : 'Nueva Caja Chica' }}" wire:model="showModal" blur
        max-width="2xl">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-form.input label="Nombre de la Caja *" placeholder="Ej: Caja Chica Oficina Principal"
                    wire:model.live="nombre" />
            </div>

            <div class="sm:col-span-2">
                <x-form.textarea label="Descripción" placeholder="Descripción opcional" wire:model.live="descripcion"
                    rows="2" />
            </div>

            <x-form.currency label="Saldo Inicial *" placeholder="0.00" wire:model.live="saldo_inicial" prefix="S/"
                precision="2" thousands="," decimal="." />

            <x-form.native.select label="Moneda *" wire:model.live="moneda">
                <option value="PEN">Soles (PEN)</option>
                <option value="USD">Dólares (USD)</option>
            </x-form.native.select>

            <div class="sm:col-span-2">
                <x-form.datetime.picker label="Fecha de Apertura *" wire:model.live="fecha_apertura" without-time />
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
