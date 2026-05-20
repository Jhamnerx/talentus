<div>
    <x-form.modal.card title="Enviar mensaje al grupo: {{ $groupName }}" blur wire:model.live="showModal"
        align="center">
        <div class="space-y-4">
            <x-form.select wire:model.live="messageType" label="Tipo de mensaje">
                <x-select.option value="text" label="Texto" />
                <x-select.option value="image" label="Imagen" />
                <x-select.option value="video" label="Video" />
                <x-select.option value="audio" label="Audio" />
                <x-select.option value="document" label="Documento" />
            </x-form.select>

            @if ($messageType === 'text')
                <x-form.textarea wire:model="message" label="Mensaje" rows="4" />
            @elseif(in_array($messageType, ['image', 'video', 'audio', 'document']))
                <x-form.input wire:model="mediaUrl" label="URL del archivo" placeholder="https://..." />
                @if (in_array($messageType, ['image', 'video', 'document']))
                    <x-form.input wire:model="caption" label="Caption (opcional)" />
                @endif
                @if ($messageType === 'document')
                    <x-form.input wire:model="filename" label="Nombre del archivo (opcional)"
                        placeholder="Ej: contrato.pdf" />
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
