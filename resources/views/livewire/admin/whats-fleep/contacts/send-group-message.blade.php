<div>
    <x-form.modal.card title="Enviar mensaje al grupo: {{ $groupName }}" blur wire:model.live="showModal"
        align="center">
        <div class="space-y-4">
            <x-native-select wire:model="messageType" label="Tipo de mensaje">
                <option value="text">Texto</option>
                <option value="image">Imagen</option>
                <option value="video">Video</option>
                <option value="audio">Audio</option>
                <option value="document">Documento</option>
            </x-native-select>

            @if ($messageType === 'text')
                <x-form.textarea wire:model="message" label="Mensaje" rows="4" />
            @else
                <x-form.input wire:model="mediaUrl" label="URL del archivo" placeholder="https://..." />
                @if (in_array($messageType, ['image', 'video', 'document']))
                    <x-form.input wire:model="caption" label="Caption (opcional)" />
                @endif
            @endif
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="sendMessage" spinner="sendMessage" :disabled="$sending" primary
                    icon="paper-airplane" label="Enviar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
