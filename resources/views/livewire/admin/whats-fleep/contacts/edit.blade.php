<div>
    <x-form.modal.card title="Editar Contacto" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="name" label="Nombre" />
            <x-form.input wire:model="number" label="Número" />
            <x-native-select wire:model="tag_id" label="Lista / Phonebook">
                <option value="">Sin lista</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </x-native-select>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Actualizar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
