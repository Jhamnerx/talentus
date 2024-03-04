<div>
    <div x-data="{ modalOpen: @entangle('modalOpen').live }">

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
            <div class="bg-white rounded shadow-lg overflow-auto max-w-2xl w-full max-h-full"
                @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">INFORMACION DISPOSITIVO</div>
                        <button wire:click.prevent="closeModal" class="text-slate-400 hover:text-slate-500"
                            @click="modalOpen = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-4 py-5 bg-white sm:p-6">
                    <!-- Sidebar -->
                    <div>
                        <div
                            class="lg:sticky lg:top-16 bg-slate-50 lg:overflow-x-hidden lg:overflow-y-auto no-scrollbar lg:shrink-0 border-t lg:border-t-0 lg:border-l border-slate-200 w-full">
                            <div class="py-8 px-4 lg:px-8 2xl:px-12">

                                @if ($datos['status'] == 'ok')
                                    <div class="max-w-sm w-full mx-auto lg:max-w-none">
                                        <h2 class="text-2xl text-slate-800 font-bold mb-6">{{ $datos['imei'] }}
                                        </h2>
                                        <div class="space-y-6">

                                            <!-- Details -->
                                            <div>
                                                <div class="text-slate-800 font-semibold mb-2">Detalles Dispositivo
                                                </div>

                                                <ul>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">Imei:</div>
                                                        <div class="text-sm font-medium text-slate-800 ml-2">
                                                            {{ $datos['imei'] }}</div>
                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">Modelo:</div>
                                                        <div class="text-sm font-medium text-slate-800 ml-2">
                                                            {{ $datos['model'] }}</div>
                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="flex items-center">
                                                            <span class="text-sm mr-2">Configuración actual:</span>

                                                        </div>
                                                        <div class="text-sm font-medium text-slate-800 ml-2">

                                                            <span
                                                                class="text-xs inline-flex whitespace-nowrap font-medium uppercase bg-slate-200 text-slate-500 rounded-full text-center px-2.5 py-1">
                                                                {{ $datos['current_configuration'] }}
                                                            </span>
                                                        </div>

                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="flex items-center">
                                                            <span class="text-sm mr-2">Firmware:</span>

                                                        </div>
                                                        <div class="text-sm font-medium text-slate-800 ml-2">

                                                            <span
                                                                class="text-xs inline-flex whitespace-nowrap font-medium uppercase bg-slate-200 text-slate-500 rounded-full text-center px-2.5 py-1">
                                                                {{ $datos['current_firmware'] }}
                                                            </span>
                                                        </div>

                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">Descripción:</div>
                                                        <div class="text-sm font-medium text-emerald-600 ml-2">
                                                            {{ $datos['description'] }}</div>
                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">Company:</div>
                                                        <div class="text-sm font-medium text-emerald-600 ml-2">
                                                            {{ $datos['company_name'] }}</div>
                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">Grupo:</div>
                                                        <div class="text-sm font-medium text-emerald-600 ml-2">
                                                            {{ $datos['group_name'] }}</div>
                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">iccid:</div>
                                                        <div class="text-sm font-medium text-emerald-600 ml-2">
                                                            {{ $datos['iccid'] }}</div>
                                                    </li>
                                                    <li
                                                        class="flex items-center justify-between py-3 border-b border-slate-200">
                                                        <div class="text-sm">imsi:</div>
                                                        <div class="text-sm font-medium text-emerald-600 ml-2">
                                                            {{ $datos['imsi'] }}</div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Details -->
                                            <div>
                                                <div class="text-slate-800 font-semibold mb-4">Visto a las</div>
                                                <div class="text-sm rounded border border-slate-200 p-3">
                                                    <div class="flex items-center justify-between space-x-2">

                                                        <!-- Expiry -->
                                                        <div class=" ml-2">{{ $datos['seen_at'] }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-6">
                                                <div class="mb-4">
                                                    <a target="_blank"
                                                        href="https://fm.teltonika.lt/devices?query={{ $datos['imei'] }}"
                                                        class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white">

                                                        Ver en Fota Web
                                                    </a>
                                                </div>
                                                <div class="text-xs text-slate-500 italic text-center">Estos datos son
                                                    obtenidos de la Api de fota web.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @else
                                    <div class="max-w-sm w-full mx-auto lg:max-w-none">

                                        <h2 class="text-xl text-slate-800 font-bold mb-6">

                                            Dispositivo no encontrado en fota web
                                        </h2>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            @click="modalOpen = false" wire:click.prevent="closeModal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

</div>
