<div class="mb-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
    <div class="flex flex-col sm:flex-row sm:items-end gap-3">
        <div class="grow">
            <label class="block text-sm font-medium mb-1">Días para considerar cliente nuevo</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                Un cliente es <strong>nuevo</strong> si tiene 1 solo vehículo y se registró hace este número de días o menos.
            </p>
            <input type="number" min="1" max="3650" wire:model="dias" class="form-input w-32" />
            @error('dias')
                <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <x-form.button primary label="Guardar" wire:click="guardar" spinner="guardar" />
    </div>
</div>
