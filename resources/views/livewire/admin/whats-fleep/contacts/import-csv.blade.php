<div>
    <x-form.modal.card title="Importar Contactos desde CSV/Excel" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">

            {{-- Info box --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Formato del archivo</h3>
                        <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                            Tu archivo debe tener las columnas: <strong>name</strong> y <strong>number</strong>
                            (y opcionalmente <strong>tag</strong>).
                        </p>
                    </div>
                </div>
            </div>

            {{-- Group selector --}}
            <x-form.select wire:model="tag_id" label="Grupo destino" placeholder="Sin grupo">
                @foreach ($tags as $tag)
                    <x-select.option value="{{ $tag->id }}" label="{{ $tag->name }}" />
                @endforeach
            </x-form.select>

            {{-- File input --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Archivo CSV / Excel
                </label>
                <input type="file" wire:model="file" accept=".xlsx,.csv"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400 cursor-pointer
                           file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                           file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700
                           hover:file:bg-violet-100 dark:file:bg-violet-900/20 dark:file:text-violet-400">
                <div wire:loading wire:target="file" class="text-xs text-gray-400 mt-1">Cargando archivo...</div>
                @error('file')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            @if ($file)
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Archivo seleccionado: <strong>{{ $file->getClientOriginalName() }}</strong>
                </p>
            @endif

            @if ($errors->any())
                <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="import" spinner="import" primary label="Importar Contactos" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
