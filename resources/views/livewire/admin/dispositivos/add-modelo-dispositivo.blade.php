<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ modalOpen: @entangle('modalOpen').live }">
        <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300"
            @click="modalOpen = true" aria-controls="basic-modal">
            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                <path
                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
            </svg>
            <span class="hidden xs:block ml-2">MODELOS GPS</span>
        </button>
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalOpen" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>
            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                @keydown.escape.window="modalOpen = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">REGISTRAR MODELOS GPS</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>

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

                                            <button type="button"
                                                wire:click="eliminarCaracteristica('{{ $clave }}')"
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

                    <!-- Modal footer -->
                    <div class="px-5 py-4 border-t border-slate-200">
                        <div class="flex flex-wrap justify-end space-x-2">
                            <button type="button"
                                class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                @click="modalOpen = false">Cerrar</button>
                            <button wire:click.prevent='save'
                                class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End -->

</div>
