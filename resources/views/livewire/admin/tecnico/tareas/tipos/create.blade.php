<x-form.modal.card title="AÑADIR TIPO TAREA" wire:model.live="modalSave" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-6">

            <label class="block text-sm font-medium mb-1" for="placa">Nombre: <span
                    class="text-rose-500">*</span></label>
            <div class="relative">

                <input wire:model.live="nombre" placeholder="Introduce el nombre" name="nombre" id="nombre"
                    class="form-input w-full pl-9 valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer"
                    type="text" required />


                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                    <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g fill="none" class="nc-icon-wrapper">
                            <path
                                d="M15 11V5l-3-3-3 3v2H3v14h18V11h-6zm-8 8H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm6 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm6 12h-2v-2h2v2zm0-4h-2v-2h2v2z"
                                fill="currentColor"></path>
                        </g>
                    </svg>

                </div>
            </div>
            @error('nombre')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="col-span-12 sm:col-span-6">

            <label class="block text-sm font-medium mb-1" for="costo">Costo: <span
                    class="text-rose-500">*</span></label>
            <div class="relative">

                <input wire:model.live="costo" placeholder="Introduce el costo" name="costo" id="costo"
                    class="form-input w-full pl-9 valid:border-emerald-300
                                                    required:border-rose-300 invalid:border-rose-300 peer"
                    type="text" required />


                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                    <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <g stroke-linecap="round" fill="none" stroke="currentColor" stroke-linejoin="round"
                            class="nc-icon-wrapper">
                            <path d="M55,60,32,47,9,60V8a5,5,0,0,1,5-5H50a5,5,0,0,1,5,5Z"></path>
                        </g>
                    </svg>
                </div>
            </div>
            @error('costo')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="col-span-12 sm:col-span-6">

            <label class="block text-sm font-medium mb-1" for="afecta_mantenimiento">Afecta
                mantenimiento? </label>
            <x-form.toggle left-label="" lg wire:model.live="afecta_mantenimiento" value="1" />
        </div>
        <div class="col-span-12">
            <x-form.badge flat positive label="%modelo_gps%" />
            <x-form.badge flat negative label="%placa%" />
            <x-form.badge flat warning label="%fecha%" />
            <x-form.badge flat info label="%hora%" />
            <x-form.badge flat dark label="%velo_modelo%" />
        </div>

        <div class="col-span-12">
            <x-form.textarea wire:model.live="descripcion" label="Descripcion"
                placeholder="Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%" />
        </div>

        @role('admin')
            <div class="col-span-12">
                <label class="block text-sm font-medium mb-1" for="plataforma">Selecciona El Tecnico:
                    <span class="text-rose-500">*</span></label>
                <div class="flex flex-wrap items-center">

                    @foreach ($tecnicos as $tecnico)
                        <div class="m-3">
                            <label class="flex items-center">
                                <input type="radio" name="radio-buttons" class="form-radio" wire:model.live="user_id"
                                    value="{{ $tecnico->id }}" />
                                <span class="text-sm ml-2">{{ $tecnico->name }}</span>
                            </label>
                        </div>
                    @endforeach

                </div>
                @error('user_id')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        @endrole
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" spinner="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
