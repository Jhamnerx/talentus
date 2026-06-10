<x-form.modal.card title="Crear Recordatorio" blur wire:model.live="openModalRecordatorio" align="center">

    <div class="grid grid-cols-12 gap-4">

        <div class="col-span-12">
            <x-form.datetime.picker
                label="Fecha recordatorio"
                id="fecha_recordatorio"
                name="fecha_recordatorio"
                wire:model.live="fecha_recordatorio"
                without-time
                parse-format="YYYY-MM-DD"
                display-format="DD-MM-YYYY"
                :clearable="false" />
            @error('fecha_recordatorio')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-span-12">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="nota">Nota (opcional)</label>
            <textarea
                wire:model.live="nota"
                id="nota"
                rows="4"
                class="form-textarea w-full text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 resize-none"
                placeholder="Escribe una nota para el recordatorio..."></textarea>
        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-2">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Guardar" wire:click="save" spinner="save" />
        </div>
    </x-slot>

</x-form.modal.card>
