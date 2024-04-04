<x-form.modal.card title="IMPORTAR DISPOSITIVOS" wire:model.live="modalImport" align="center">

    <div class="px-4 py-5 bg-white sm:p-6">

        <div class="col-span-12 sm:col-span-4">


            <label for="modelo" class="block text-sm font-medium text-gray-700">Selecciona Modelo:</label>
            <select wire:model.live="modelo" class="form-select w-full" name="modelo" id="modelo">
                <option selected>Selecciona un modelo</option>
                @foreach ($modelos as $modelo)
                    <option value="{{ $modelo->id }}">{{ $modelo->modelo }}</option>
                @endforeach
            </select>
            @error('modelo')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <label class="block text-sm font-medium text-gray-700"> Elegir Archivo </label>
        <div x-data="{ file: @entangle('file').live, files: null }"
            class="mt-1 relative flex justify-center px-6 pt-5 pb-6 border-2 cursor-pointer border-gray-300 border-dashed rounded-md"
            x-on:dragover="$el.classList.add('border-emerald-400')"
            x-on:dragleave="$el.classList.remove('border-emerald-400')">
            <input wire:model.live="file" type="file"
                class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0 cursor-pointer" id="file"
                x-on:change="files = $event.target.files; console.log($event.target.files);"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
            <div class="space-y-1 text-center">
                <svg x-show="!file" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                    viewBox="0 0 48 48" aria-hidden="true">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg x-show="file" class="mx-auto h-12 w-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"
                    width="48px" height="48px">
                    <path fill="#4CAF50" d="M41,10H25v28h16c0.553,0,1-0.447,1-1V11C42,10.447,41.553,10,41,10z" />
                    <path fill="#FFF"
                        d="M32 15H39V18H32zM32 25H39V28H32zM32 30H39V33H32zM32 20H39V23H32zM25 15H30V18H25zM25 25H30V28H25zM25 30H30V33H25zM25 20H30V23H25z" />
                    <path fill="#2E7D32" d="M27 42L6 38 6 10 27 6z" />
                    <path fill="#FFF"
                        d="M19.129,31l-2.411-4.561c-0.092-0.171-0.186-0.483-0.284-0.938h-0.037c-0.046,0.215-0.154,0.541-0.324,0.979L13.652,31H9.895l4.462-7.001L10.274,17h3.837l2.001,4.196c0.156,0.331,0.296,0.725,0.42,1.179h0.04c0.078-0.271,0.224-0.68,0.439-1.22L19.237,17h3.515l-4.199,6.939l4.316,7.059h-3.74V31z" />
                </svg>
                <div x-show="!file" class="flex text-sm text-gray-600">
                    <label for="file"
                        class="relative cursor-pointer z-60 bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <span>Subir Archivo</span>
                        {{-- <input id="file-upload" name="file-upload" type="file" class="sr-only"
                                        accept="image/*"> --}}



                    </label>
                    <p class="pl-1">o arrastra y suelta</p>
                </div>
                <template x-if="file !== null">
                    <template x-for="(_,index) in Array.from({ length: files.length })">

                        <div class="flex text-sm text-gray-600">
                            Archivo Selecionado:
                            <p class="pl-1" x-text="files[index].name">Subiendo</p>

                        </div>
                    </template>

                </template>

                <p class="text-xs text-gray-500">XLSl, XLS 10MB</p>
            </div>


        </div>
        <div wire:loading wire:target="file">
            <span class="text-emerald-500">Cargando...</span>
        </div>
        @error('file')
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                {{ $message }}
            </p>
        @enderror

        @foreach ($errorInfo as $error)
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                {{ $error['errores'] }} => {{ $error['values'] }}
            </p>
        @endforeach

        <div>
            <p class="mt-1 text-slate-500 text-sm">
                Descargar archivo formato
                <a class="text-blue-800" href="{{ Storage::url('excel/dispositivos.xlsx') }}" download>
                    Haz click aqui
                </a>
            </p>
        </div>
    </div>


    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click='closeModal' />
                <x-form.button primary label="Guardar" wire:click="importExcel" spinner='importExcel' />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
