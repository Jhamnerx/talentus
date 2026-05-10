<div>
    <x-form.modal.card title="Nueva Auto-Respuesta" blur wire:model.live="showModal" align="center">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <x-native-select wire:model.live="device" label="Dispositivo *">
                    <option value="">Selecciona un dispositivo</option>
                    @foreach ($devices as $d)
                        <option value="{{ $d->body }}">{{ $d->body }}</option>
                    @endforeach
                </x-native-select>
            </div>
            <x-form.input wire:model="keyword" label="Keyword *" placeholder="Ej: hola, precio..." />
            <x-native-select wire:model="type_keyword" label="Tipo de coincidencia">
                <option value="Equal">Exacto</option>
                <option value="Contain">Contiene</option>
            </x-native-select>
            <x-native-select wire:model="reply_when" label="Responder en">
                <option value="All">Todos</option>
                <option value="Personal">Privado</option>
                <option value="Group">Grupos</option>
            </x-native-select>
            <x-native-select wire:model.live="type" label="Tipo de respuesta">
                <option value="text">Texto</option>
                <option value="image">Imagen</option>
            </x-native-select>
            @if ($type === 'text')
                <div class="col-span-2">
                    <x-form.textarea wire:model="replyText" label="Texto de respuesta *" rows="4" />
                </div>
            @else
                <x-form.input wire:model="replyImageUrl" label="URL de imagen *" placeholder="https://..."
                    class="col-span-2" />
                <div class="col-span-2">
                    <x-form.textarea wire:model="replyImageCaption" label="Caption (opcional)" rows="2" />
                </div>
            @endif
            <div class="col-span-2 flex gap-6">
                <x-form.toggle wire:model="status" label="Activo" />
                <x-form.toggle wire:model="is_quoted" label="Citar mensaje original" />
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Guardar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
