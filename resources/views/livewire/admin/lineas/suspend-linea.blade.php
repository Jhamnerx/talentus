<div>
    <!-- Start -->
    <div x-data="{ modalAsign: @entangle('openModal') }">
        {{-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalAsign = true"
            aria-controls="plan-modal">Change your Plan</button> --}}
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalAsign"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>
        <!-- Modal dialog -->
        <div id="plan-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalAsign"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>
            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                @keydown.escape.window="modalAsign = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">SUSPENDER LINEAS</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalAsign = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-8 py-5 bg-white sm:p-6">

                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 mx-auto">
                            <ul class="list-disc">
                                @if ($items)
                                    @foreach ($items as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                @endif

                                <!-- ... -->
                            </ul>
                        </div>
                        <div class="col-span-12 md:col-span-6 gap-2">
                            <label
                                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                <div>Fecha de Suspención: <span class="text-sm text-red-500"> * </span></div>

                            </label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input maxlength="10" wire:model="fecha_suspencion" type="text" readonly
                                    class="form-input fecha fechaInicio w-full pl-9" placeholder="Selecciona la fecha">
                            </div>
                            @error('fecha_suspencion')
                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="col-span-12 md:col-span-6 gap-2">
                            <label
                                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                <div>Fecha de Reactivación: <span class="text-sm text-red-500"> * </span></div>

                            </label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input maxlength="10" wire:model="date_to_suspend" type="text" readonly
                                    class="form-input fecha fechaFinal w-full pl-9" placeholder="Selecciona la fecha">
                            </div>
                            @error('date_to_suspend')
                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="col-span-12 gap-2">
                            {{ $baja }}
                            <div class="m-2 w-full mt-2">
                                <label for="baja">Baja definitiva:</label>
                                <!-- Start -->
                                <div class="flex items-center">
                                    <div class="form-switch">
                                        <input wire:model="baja" type="checkbox" id="baja-1" class="sr-only baja" />
                                        <label class="bg-slate-400" for="baja-1">
                                            <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                            <span class="sr-only">baja switch</span>
                                        </label>
                                    </div>

                                </div>
                                <!-- End -->
                            </div>
                        </div>

                    </div>

                </div>
                <!-- Modal footer -->
                <div class="px-5 py-4">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click.prevent="closeModal">Cerrar</button>

                        <button wire:click.prevent="save()"
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script></script>
@endpush
