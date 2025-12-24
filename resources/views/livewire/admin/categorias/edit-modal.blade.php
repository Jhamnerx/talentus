<div>
    <x-form.modal.card title="Editar Categoría" wire:model="modalEdit" max-width="2xl">
        <div class="space-y-4">
            <x-form.input label="Nombre *" wire:model="nombre" placeholder="Nombre de la categoría" />
            <x-form.textarea label="Descripción" wire:model="descripcion" placeholder="Descripción de la categoría" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Actualizar" wire:click="update" primary spinner="update" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
