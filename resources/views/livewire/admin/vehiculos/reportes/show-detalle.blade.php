<div>
    <!-- Start -->
    <div x-data="{ modalContacto: @entangle('openModalDetalle').live }">
        {{-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalContacto = true"
            aria-controls="plan-modal">Change your Plan</button> --}}
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalContacto"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>
        <!-- Modal dialog -->
        <div id="plan-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalContacto"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>
            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                @click.outside="modalContacto = false" @keydown.escape.window="modalContacto = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">VER DETALLE</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalContacto = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-5 pt-4 pb-1">
                    <div class="text-sm">
                        <div class="mb-4">Aqui se muestran los detalles del reporte:</div>
                        <!-- Options -->
                        <ul class="space-y-2 mb-4">

                            @foreach ($detalles as $detalle)
                                <li>
                                    <div
                                        class="w-full h-full text-left py-3 px-4 rounded bg-white border-2 border-indigo-400 shadow-sm duration-150 ease-in-out">
                                        <div class="flex items-center">
                                            {{-- <div class="w-4 h-4 border-4 border-indigo-500 rounded-full mr-3"></div>
                                        --}}
                                            <div class="grow">
                                                <div class="flex flex-wrap items-center justify-between mb-0.5">
                                                    <span
                                                        class="font-medium text-slate-800">{{ $detalle->reporte->vehiculos->placa }}
                                                        |<span
                                                            class="text-xs italic text-slate-500 align-top">{{ $detalle->detalle }}</span></span>
                                                    <span><span
                                                            class="font-medium text-emerald-600">{{ $detalle->updated_at }}</span></span>
                                                </div>
                                                <div class="text-sm">Usuario: <span
                                                        class="text-xs italic text-indigo-500 align-top">{{ $detalle->user->name }}
                                                        ✨</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @if (count($detalles) < 1)
                                <li>
                                    <div
                                        class="w-full h-full text-left py-3 px-4 rounded bg-white border-2 border-indigo-400 shadow-sm duration-150 ease-in-out">
                                        <div class="flex items-center">
                                            {{-- <div class="w-4 h-4 border-4 border-indigo-500 rounded-full mr-3"></div>
                                        --}}
                                            <div class="grow">
                                                <div class="flex flex-wrap items-center justify-between mb-0.5">

                                                    <span>SIN INFORMACION ADICIONAL</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <div
                                    class="w-full h-full text-left py-3 px-4 rounded bg-white border-2 border-indigo-400 shadow-sm duration-150 ease-in-out">
                                    <div class="flex items-center">

                                        <div class="grow">
                                            <div class="flex flex-wrap items-center justify-between mb-0.5">

                                                <textarea wire:model.live="detalle" class="form-input w-full" placeholder="Ingresar informacion adicional"
                                                    name="detalle" id="" rows="3"></textarea>
                                            </div>

                                        </div>

                                    </div>
                                    @error('detalle')
                                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </li>
                            <div class="text-xs text-slate-500">Aqui se muestran los reportes añadidos
                                adicionalmente al
                                original</div>
                        </ul>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="px-5 py-4">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            @click="modalContacto = false">Cerrar</button>
                        <button wire:click.prevent="addDetalle()"
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
