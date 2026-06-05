<x-form.modal.card title="EDITAR RUBRO DE CLIENTE" max-width="lg" wire:model.live="openModal">
    <div class="space-y-4 p-1">
        <x-form.input label="Nombre *" wire:model.live="nombre" placeholder="Ej: TRANSPORTES, MINERÍA, CONSTRUCCIÓN..." />
        <x-form.input label="Descripción" wire:model="descripcion" placeholder="Opcional" />
        <div class="flex items-center gap-3">
            <x-form.checkbox wire:model.live="is_active" id="edit-rubro-active" />
            <label for="edit-rubro-active" class="text-sm text-gray-700 dark:text-gray-300">Rubro activo</label>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="close" />
            <x-form.button primary label="Actualizar" wire:click="update" />
        </div>
    </x-slot>
</x-form.modal.card>
