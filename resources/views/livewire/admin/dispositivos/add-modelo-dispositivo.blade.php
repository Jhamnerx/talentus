<div>
    <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300"
        wire:click="$set('modalOpen', true)" aria-controls="basic-modal">
        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
            <path
                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
        </svg>
        <span class="hidden xs:block ml-2">MODELOS GPS</span>
    </button>

    <x-form.modal.card title="REGISTRAR MODELOS GPS" max-width="lg" wire:model.live="modalOpen" align="center">

        <form autocapitalize="on" autocomplete="off">
            <!-- Modal content -->
            <div class="px-5 py-4 pt-4 pb-1 grid grid-cols-12 gap-6 mb-3">
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium mb-1" for="modelo">Modelo:
                    </label>
                    <input wire:model.live='modelo' id="modelo" class="form-input w-full" type="text"
                        placeholder="Escribe el modelo..." />
                    @error('modelo')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium mb-1" for="marca">Marca:
                    </label>
                    <input wire:model.live='marca' id="marca" class="form-input w-full" type="text"
                        placeholder="Escribe la Marca..." />
                    @error('marca')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-sm font-medium mb-1" for="certificado">Certificado:
                    </label>
                    <input wire:model.live='certificado' id="certificado" class="form-input w-full" type="text"
                        placeholder="Escribe el Certificado..." />
                    @error('certificado')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- separador --}}
                <div class="col-span-12">
                    <div class="flex justify-between items-center" aria-hidden="true">
                        <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                        </svg>
                        <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                            <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                        </div>
                        <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                        </svg>
                    </div>
                </div>

                <div class="col-span-12">
                    <div class="flex">
                        <div class="flex-auto w-full"></div>
                        <div class="flex-auto w-full">
                            <a wire:click.debounce.250ms="addCaracteristica()"
                                class="btn bg-indigo-500 hover:bg-indigo-600 text-white hover:cursor-pointer float-right">
                                <svg class="w-4 h-4 fill-current shrink-0 text-white" viewBox="0 0 16 16">
                                    <path
                                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="col-span-12 shadow-lg px-2">
                    <label class="block text-sm font-medium mb-1">Caracteristicas:
                    </label>
                    @if ($caracteristicas->isEmpty())
                        <div class="col-span-12">
                            <span class="w-full text-red-500">Agregar caracteristicas</span>
                        </div>
                    @else
                        @foreach ($caracteristicas as $clave => $caracteristica)
                            <div class="col-span-12 py-2">
                                <div class="flex gap-2">

                                    <textarea class="form-textarea w-full" wire:model.live="caracteristicas.{{ $clave }}.text" rows="2">

                                            </textarea>

                                    <button type="button" wire:click="eliminarCaracteristica('{{ $clave }}')"
                                        class="text-rose-500 hover:text-rose-600 rounded-full">
                                        <span class="sr-only">Eliminar</span>
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                            <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                            <path
                                                d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                        </svg>
                                    </button>
                                </div>

                                @error('caracteristicas.' . $clave . '.text')
                                    <p class="mt-2 text-pink-600 text-sm">
                                        {{ $errors->first('caracteristicas.' . $clave . '.text') }}
                                    </p>
                                @enderror

                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="closeModal" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
