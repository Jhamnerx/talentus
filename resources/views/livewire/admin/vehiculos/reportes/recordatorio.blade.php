<x-form.modal.card title="CREAR RECORDATORIO" blur wire:model.live="openModalRecordatorio" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12">
            <x-form.datetime.picker label="Fecha Recordatorio:" id="fecha_recordatorio" name="fecha_recordatorio"
                wire:model.live="fecha_recordatorio" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>

        <div class="col-span-12 mt-2">

            <label class="block text-sm font-medium mb-1" for="nota">Nota:</label>
            <div class="relative">


                <textarea wire:model.live="nota" placeholder="Ingresa una nota"
                    class="form-input pl-8 py-2 outline-none block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                    name="nota" id="nota" cols="30" rows="10"></textarea>
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                    <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g fill="none" class="nc-icon-wrapper">
                            <path
                                d="M10.08 10.86c.05-.33.16-.62.3-.87.14-.25.34-.46.59-.62.24-.15.54-.22.91-.23.23.01.44.05.63.13.2.09.38.21.52.36s.25.33.34.53c.09.2.13.42.14.64h1.79c-.02-.47-.11-.9-.28-1.29-.17-.39-.4-.73-.7-1.01-.3-.28-.66-.5-1.08-.66-.42-.16-.88-.23-1.39-.23-.65 0-1.22.11-1.7.34-.48.23-.88.53-1.2.92-.32.39-.56.84-.71 1.36-.15.52-.24 1.06-.24 1.64v.27c0 .58.08 1.12.23 1.64.15.52.39.97.71 1.35.32.38.72.69 1.2.91.48.22 1.05.34 1.7.34.47 0 .91-.08 1.32-.23.41-.15.77-.36 1.08-.63.31-.27.56-.58.74-.94.18-.36.29-.74.3-1.15h-1.79c-.01.21-.06.4-.15.58-.09.18-.21.33-.36.46s-.32.23-.52.3c-.19.07-.39.09-.6.1-.36-.01-.66-.08-.89-.23a1.75 1.75 0 0 1-.59-.62c-.14-.25-.25-.55-.3-.88a6.74 6.74 0 0 1-.08-1v-.27c0-.35.03-.68.08-1.01zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                </div>
            </div>
            @error('nota')
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                {{ $message }}
            </p>
            @enderror
        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>