<div>
    <x-form.modal.card title="Nueva Auto-Respuesta" blur wire:model.live="showModal" align="center">
        <div class="grid grid-cols-1 gap-5">

            {{-- Dispositivo --}}
            <div>
                @if (session()->has('selectedDevice'))
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Dispositivo WhatsApp
                    </label>
                    <div
                        class="flex items-center gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ session('selectedDevice.device_body') }}
                        </span>
                    </div>
                @else
                    <x-form.select wire:model.live="device" label="Dispositivo" placeholder="Selecciona un dispositivo"
                        :hint="$errors->first('device')">
                        @foreach ($devices as $d)
                            <x-select.option value="{{ $d->body }}" label="{{ $d->body }}" />
                        @endforeach
                    </x-form.select>
                    @error('device')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            {{-- Keyword --}}
            <x-form.input wire:model.live="keyword" label="Palabra Clave" placeholder="Ej: hola, info, precio..."
                :hint="$errors->first('keyword')" />

            {{-- Type Keyword + Reply When --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipo de coincidencia
                    </label>
                    <div class="flex gap-4">
                        <label
                            class="flex items-center gap-1.5 cursor-pointer text-sm text-gray-700 dark:text-gray-300">
                            <input type="radio" wire:model.live="type_keyword" value="Equal"
                                class="text-violet-600 border-gray-300 dark:border-gray-600 focus:ring-violet-500">
                            Exacto
                        </label>
                        <label
                            class="flex items-center gap-1.5 cursor-pointer text-sm text-gray-700 dark:text-gray-300">
                            <input type="radio" wire:model.live="type_keyword" value="Contain"
                                class="text-violet-600 border-gray-300 dark:border-gray-600 focus:ring-violet-500">
                            Contiene
                        </label>
                    </div>
                    @error('type_keyword')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Responder cuando el remitente sea
                    </label>
                    <div class="flex gap-3 flex-wrap">
                        @foreach (['Group' => 'Grupos', 'Personal' => 'Personal', 'All' => 'Todos'] as $val => $lbl)
                            <label
                                class="flex items-center gap-1.5 cursor-pointer text-sm text-gray-700 dark:text-gray-300">
                                <input type="radio" wire:model.live="reply_when" value="{{ $val }}"
                                    class="text-violet-600 border-gray-300 dark:border-gray-600 focus:ring-violet-500">
                                {{ $lbl }}
                            </label>
                        @endforeach
                    </div>
                    @error('reply_when')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tipo de respuesta --}}
            <x-form.select wire:model.live="type" label="Tipo de Respuesta">
                <x-select.option value="text" label="Texto" />
                <x-select.option value="image" label="Imagen" />
            </x-form.select>

            {{-- Campos dinámicos --}}
            @if ($type === 'text')
                <x-form.textarea wire:model.live="replyText" label="Mensaje de Respuesta"
                    placeholder="Escribe el mensaje que se enviará automáticamente..." rows="4"
                    :hint="$errors->first('replyText')" />
            @else
                <x-form.input wire:model.live="replyImageUrl" label="URL de la Imagen"
                    placeholder="https://example.com/imagen.jpg" :hint="$errors->first('replyImageUrl')" />
                <x-form.textarea wire:model.live="replyImageCaption" label="Caption (opcional)"
                    placeholder="Texto que acompaña la imagen..." rows="3" />
            @endif

            {{-- Estado + Citar --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                    <x-form.toggle wire:model.live="status" label="Activo" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Citar mensaje original
                    </label>
                    <x-form.toggle wire:model.live="is_quoted" label="Citar al responder" />
                </div>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Crear Auto-Respuesta" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
