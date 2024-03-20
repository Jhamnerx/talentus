<div class="col-span-12 md:col-span-6 xl:col-span-4">
    <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full"
        @keydown.escape.window="modalOpen = false, files = null">
        <div class="px-5 py-3 border-b border-slate-200">
            <div class="flex justify-between items-center">
                <div class="font-semibold text-slate-800 uppercase">CERTIFICADO FORMATO P12</div>
            </div>
        </div>
        <!-- content -->

        <div class="px-4 py-5 bg-white sm:p-6" x-data="{ file: @entangle('logo').live, files: null }">

            @if ($file)
                <div class="px-5 py-2">
                    <div class="flex justify-between items-center gap-3">
                        <x-admin.iconos.key></x-admin.iconos.key>

                        <button wire:click="$set('file', null)" @click="files = null" type="button"
                            class="mr-2 btn-sm bg-red-500 hover:bg-red-600 text-white">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                    <span>{{ $file->getClientOriginalName() }}</span>
                </div>
            @else
                <div class="mt-1 relative flex justify-center px-6 pt-5 pb-6 border-2 cursor-pointer border-gray-300 border-dashed rounded-md"
                    x-on:dragover="$el.classList.add('border-emerald-400')"
                    x-on:dragleave="$el.classList.remove('border-emerald-400')">
                    <input wire:model.live="file" type="file"
                        class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0 cursor-pointer"
                        id="file" x-on:change="files = $event.target.files; console.log($event.target.files);"
                        accept=".p12">
                    <div class="space-y-1 text-center">
                        <div x-show="!file" class="flex text-sm text-gray-600">
                            <label for="file"
                                class="relative cursor-pointer z-60 bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Subir Archivo</span>

                            </label>
                            <p class="pl-1">o arrastra y suelta</p>
                        </div>
                        <p class="text-xs text-gray-500">ARCHIVOS ACEPTADOS P12</p>
                    </div>
                </div>

                <div wire:loading wire:target="file">
                    <span class="text-emerald-500">Cargando...</span>
                </div>
            @endif
        </div>

        @error('file')
            <p class="mt-2 px-4 peer-invalid:visible text-pink-600 text-sm">
                {{ $message }}
            </p>
        @enderror
        <!-- Modal footer -->
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">

                <x-form.button disabled wire:click='uploadCertificado' spinner="uploadCertificado"
                    label="Subir y Convertir" primary icon="upload" />
            </div>
        </div>
    </div>
</div>
