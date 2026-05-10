<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Form --}}
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Enviar Mensaje de Prueba</h2>

            <x-native-select wire:model="sender" label="Dispositivo de envío *">
                @foreach ($devices as $device)
                    <option value="{{ $device->body }}">{{ $device->body }}</option>
                @endforeach
            </x-native-select>

            <x-form.input wire:model="number" label="Número(s) *" placeholder="51999999999 (usa | para múltiples)" />

            <x-native-select wire:model.live="type" label="Tipo de mensaje">
                <option value="text">Texto</option>
                <option value="image">Imagen</option>
                <option value="video">Video</option>
                <option value="audio">Audio</option>
                <option value="document">Documento</option>
                <option value="button">Botones</option>
            </x-native-select>

            @if ($type === 'text')
                <x-form.textarea wire:model="message" label="Mensaje *" rows="5" />
            @elseif(in_array($type, ['image', 'video', 'audio', 'document']))
                <x-form.input wire:model="mediaUrl" label="URL del archivo *" placeholder="https://..." />
                @if ($type !== 'audio')
                    <x-form.input wire:model="caption" label="Caption (opcional)" />
                @endif
                @if ($type === 'document')
                    <x-form.input wire:model="filename" label="Nombre del archivo (opcional)"
                        placeholder="Ej: contrato.pdf" />
                @endif
            @elseif($type === 'button')
                <x-form.textarea wire:model="buttonText" label="Texto del mensaje *" rows="3" />
                <x-form.input wire:model="buttonFooter" label="Footer (opcional)" />
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Botones (máx. 3)</label>
                    @foreach ($buttons as $i => $btn)
                        <div class="flex gap-2">
                            <x-form.input wire:model="buttons.{{ $i }}.text" placeholder="Texto del botón"
                                class="flex-1" />
                            @if (count($buttons) > 1)
                                <x-form.button wire:click="removeButton({{ $i }})" icon="x-mark"
                                    size="xs" flat negative />
                            @endif
                        </div>
                    @endforeach
                    @if (count($buttons) < 3)
                        <x-form.button wire:click="addButton" icon="plus" flat label="Agregar botón"
                            size="xs" />
                    @endif
                </div>
            @endif

            <x-form.button wire:click="send" spinner="send" :disabled="$sending" positive icon="paper-airplane"
                label="Enviar mensaje" class="w-full" />
        </div>

        {{-- Result --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Respuesta</h2>
            @if ($error)
                <div
                    class="bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg p-4 text-sm border border-red-200 dark:border-red-700">
                    {{ $error }}
                </div>
            @elseif($result)
                <pre class="bg-gray-800 text-green-400 text-xs rounded-lg p-4 overflow-auto max-h-96">{{ json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @else
                <div class="flex flex-col items-center justify-center h-48 text-gray-400 dark:text-gray-500">
                    <x-form.icon name="chat-bubble-left-right" class="w-12 h-12 opacity-30 mb-3" />
                    <p class="text-sm">La respuesta aparecerá aquí</p>
                </div>
            @endif
        </div>
    </div>
</div>
