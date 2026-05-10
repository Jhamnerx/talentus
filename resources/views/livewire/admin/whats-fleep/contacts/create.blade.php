<div>
    <x-form.modal.card title="Nuevo Contacto" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="name" label="Nombre" placeholder="Ej: Juan Pérez" />
            <x-form.input wire:model="number" label="Número (con código de país)" placeholder="51999999999" />
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
                <x-form.button wire:click="save" spinner="save" primary label="Guardar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
