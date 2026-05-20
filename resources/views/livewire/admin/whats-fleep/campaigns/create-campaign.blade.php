<div>
    {{-- Steps indicator --}}
    <div class="flex items-center justify-center gap-2 mb-8">
        @foreach ([1 => 'Configuración', 2 => 'Mensaje', 3 => 'Programación'] as $step => $label)
            <div class="flex items-center gap-2">
                <div @class([
                    'w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold',
                    'bg-primary-600 text-white' => $currentStep === $step,
                    'bg-green-500 text-white' => $currentStep > $step,
                    'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400' =>
                        $currentStep < $step,
                ])>
                    @if ($currentStep > $step)
                        <x-form.icon name="check" class="w-4 h-4" />
                    @else
                        {{ $step }}
                    @endif
                </div>
                <span @class([
                    'text-sm font-medium',
                    'text-primary-600' => $currentStep === $step,
                    'text-gray-400 dark:text-gray-500' => $currentStep !== $step,
                ])>
                    {{ $label }}
                </span>
                @if ($step < 3)
                    <x-form.icon name="chevron-right" class="w-4 h-4 text-gray-300" />
                @endif
            </div>
        @endforeach
    </div>

    {{-- Step 1 --}}
    @if ($currentStep === 1)
        <div class="space-y-4 max-w-lg mx-auto">
            <x-form.input wire:model="name" label="Nombre de la campaña *" placeholder="Ej: Promo Diciembre 2025" />
            <x-form.select wire:model.live="device_id" label="Dispositivo de envío *"
                placeholder="Selecciona un dispositivo">
                @foreach ($devices as $device)
                    <x-select.option value="{{ $device->id }}" label="{{ $device->body }}" />
                @endforeach
            </x-form.select>
            @if ($sender)
                <p class="text-xs text-gray-500">Sender: <span
                        class="font-mono text-gray-700 dark:text-gray-300">{{ $sender }}</span></p>
            @endif
        </div>
    @endif

    {{-- Step 2 --}}
    @if ($currentStep === 2)
        <div class="space-y-4 max-w-2xl mx-auto">
            <x-form.select wire:model="tag_id" label="Lista de contactos (Phonebook) *"
                placeholder="Selecciona una lista">
                @foreach ($phonebooks as $pb)
                    <x-select.option value="{{ $pb->id }}"
                        label="{{ $pb->name }} ({{ $pb->contacts_count }} contactos)" />
                @endforeach
            </x-form.select>
            <x-form.select wire:model.live="message_type" label="Tipo de mensaje">
                <x-select.option value="text" label="Texto" />
                <x-select.option value="image" label="Imagen" />
                <x-select.option value="video" label="Video" />
                <x-select.option value="audio" label="Audio" />
                <x-select.option value="document" label="Documento" />
            </x-form.select>

            @if ($message_type === 'text')
                <x-form.textarea wire:model="message" label="Mensaje *" rows="4" />
            @elseif (in_array($message_type, ['image', 'video', 'audio', 'document']))
                <x-form.input wire:model="image_url" label="URL del archivo *" placeholder="https://..." />
                @if ($message_type !== 'audio')
                    <x-form.input wire:model="caption" label="Caption (opcional)" />
                @endif
            @endif
        </div>
    @endif

    {{-- Step 3 --}}
    @if ($currentStep === 3)
        <div class="space-y-4 max-w-lg mx-auto">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Delay entre mensajes
                    (segundos)</label>
                <x-form.input wire:model="delay" type="number" min="1" max="60" />
            </div>
            <x-form.select wire:model.live="schedule_type" label="Tipo de envío">
                <x-select.option value="immediate" label="Inmediato" />
                <x-select.option value="scheduled" label="Programado" />
            </x-form.select>
            @if ($schedule_type === 'scheduled')
                <x-form.input wire:model="schedule_time" type="datetime-local" label="Fecha y hora de envío" />
            @endif

            {{-- Summary --}}
            <div
                class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-sm space-y-1 border border-gray-200 dark:border-gray-700">
                <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">Resumen de la campaña</h4>
                <p><span class="text-gray-500">Nombre:</span> <strong>{{ $name }}</strong></p>
                <p><span class="text-gray-500">Sender:</span> <strong>{{ $sender }}</strong></p>
                <p><span class="text-gray-500">Tipo:</span> <strong>{{ $message_type }}</strong></p>
                <p><span class="text-gray-500">Envío:</span>
                    <strong>{{ $schedule_type === 'immediate' ? 'Inmediato' : $schedule_time }}</strong>
                </p>
            </div>
        </div>
    @endif

    {{-- Navigation --}}
    <div class="flex justify-between mt-8 pt-4 border-t border-gray-100 dark:border-gray-700">
        @if ($currentStep > 1)
            <x-form.button wire:click="prevStep" flat icon="arrow-left" label="Anterior" />
        @else
            <div></div>
        @endif
        @if ($currentStep < 3)
            <x-form.button wire:click="nextStep" spinner="nextStep" primary icon-trailing="arrow-right"
                label="Siguiente" />
        @else
            <x-form.button wire:click="create" spinner="create" positive icon="paper-airplane" label="Lanzar campaña" />
        @endif
    </div>
</div>
