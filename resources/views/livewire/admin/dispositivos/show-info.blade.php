<div>
    <x-form.modal.card title="INFORMACION DISPOSITIVO" max-width="2xl" wire:model.live="modalOpen">
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
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Imei:</div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">
                                                {{ $datos['imei'] }}</div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Modelo:</div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">
                                                {{ $datos['model'] }}</div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
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
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
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
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Descripción:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                {{ $datos['description'] }}</div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Company:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                {{ $datos['company_name'] }}</div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Grupo:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                {{ $datos['group_name'] }}</div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">iccid:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                {{ $datos['iccid'] }}</div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
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




        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="closeModal" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
