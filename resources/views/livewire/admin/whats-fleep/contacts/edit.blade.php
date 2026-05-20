<div>
    <x-form.modal.card title="Editar Contacto" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="name" label="Nombre (Opcional)" placeholder="Ej: Juan Pérez"
                hint="Nombre descriptivo del contacto" />
            <x-form.input wire:model="number" label="Número de WhatsApp" placeholder="Ej: 51987654321"
                hint="Número completo con código de país" />
            <x-form.select wire:model="tag_id" label="Grupo" placeholder="Sin grupo">
                @foreach ($tags as $tag)
                    <x-select.option value="{{ $tag->id }}" label="{{ $tag->name }}" />
                @endforeach
            </x-form.select>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Actualizar Contacto" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
