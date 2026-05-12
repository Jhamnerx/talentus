<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Mensaje de Prueba</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Form --}}
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Enviar Mensaje de Prueba</h2>

            <x-form.select wire:model="sender" label="Dispositivo de envío *">
                @foreach ($devices as $device)
                    <x-select.option value="{{ $device->body }}" label="{{ $device->body }}" />
                @endforeach
            </x-form.select>

            <x-form.input wire:model="number" label="Número(s) *" placeholder="51999999999 (usa | para múltiples)" />

            <x-form.select wire:model.live="type" label="Tipo de mensaje">
                <x-select.option value="text" label="Texto" />
                <x-select.option value="image" label="Imagen" />
                <x-select.option value="video" label="Video" />
                <x-select.option value="audio" label="Audio" />
                <x-select.option value="document" label="Documento" />
            </x-form.select>

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
