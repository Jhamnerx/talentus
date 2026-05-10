<div>
    <x-form.modal.card title="Importar Contactos desde Excel/CSV" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 text-sm text-blue-700 dark:text-blue-300">
                El archivo debe tener las columnas: <strong>name</strong>, <strong>number</strong> (y opcionalmente
                <strong>tag</strong>).
            </div>
            <x-native-select wire:model="tag_id" label="Asignar a lista">
                <option value="">Sin lista</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </x-native-select>
            <x-file wire:model="file" label="Archivo Excel / CSV" accept=".xlsx,.csv" />
            @if ($file)
                <p class="text-xs text-gray-500 dark:text-gray-400">Archivo seleccionado:
                    {{ $file->getClientOriginalName() }}</p>
            @endif
            @if ($errors->any())
                <x-errors />
            @endif
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="import" spinner="import" primary label="Importar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
