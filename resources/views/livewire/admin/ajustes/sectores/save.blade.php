<x-form.modal.card title="AÑADIR SECTOR" max-width="lg" wire:model.live="openModal">
    <div class="space-y-4 p-1">
        <x-form.input label="Nombre *" wire:model.live="nombre" placeholder="Ej: SUTRAN, MINA: CMC, PERSONAL..." />
        <x-form.input label="Descripción" wire:model="descripcion" placeholder="Opcional" />
        <x-form.input label="Orden de visualización" wire:model="orden" type="number" min="0" />
        <div class="flex items-center gap-3">
            <x-form.checkbox wire:model.live="is_active" id="save-sector-active" />
            <label for="save-sector-active" class="text-sm text-gray-700 dark:text-gray-300">Sector activo</label>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="close" />
            <x-form.button primary label="Guardar" wire:click="save" />
        </div>
    </x-slot>
</x-form.modal.card>
