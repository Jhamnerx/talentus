<div>
    <x-form.modal.card title="{{ $bank_id ? 'Editar Banco' : 'Nuevo Banco' }}" wire:model="showModal" blur max-width="md">
        <div class="space-y-4">
            <x-form.input label="Descripción" wire:model="description" placeholder="Nombre del banco" />

            <div class="flex items-center gap-2">
                <x-form.checkbox wire:model="active" id="bank-active" />
                <label for="bank-active" class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
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
