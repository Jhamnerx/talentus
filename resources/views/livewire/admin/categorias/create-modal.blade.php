<div>
    <x-form.modal.card title="Nueva Categoría" wire:model.live="modalCreate" width="2xl" align="center">
        <div class="space-y-4">
            <x-form.input label="Nombre *" wire:model.live="nombre" placeholder="Nombre de la categoría" />
            <x-form.textarea label="Descripción" wire:model.live="descripcion"
                placeholder="Descripción de la categoría" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Guardar" wire:click="save" primary spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
