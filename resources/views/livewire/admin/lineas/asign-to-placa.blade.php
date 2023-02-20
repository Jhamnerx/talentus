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
                        <div class="font-semibold text-slate-800">ASIGNAR LINEA A PLACA</div>
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
                <div class="px-5 pt-4 pb-1">
                    <div class="text-sm">

                        <div class="mb-4">
                            Modificaras la siguiente Linea: <span
                                class="s text-base font-medium">{{ $linea ? $linea->numero : '' }}</span>
                            <br>
                            Tiene el Siguiente Sim Card: <span
                                class="s text-base font-medium">{{ $linea ? $linea->sim_card->sim_card : '' }}</span>
                        </div>
                    </div>
                    @if ($asignado)
                        <div class="overflow-x-auto mb-2">
                            <table class="table-auto w-full">
                                <!-- Table header -->
                                <thead
                                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                    <tr>

                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-semibold text-left">PLACA</div>
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-semibold text-left">CLIENTE</div>
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-semibold text-left">Accion</div>
                                        </th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody class="text-sm divide-y divide-slate-200">
                                    <!-- Row -->

                                    <tr>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left font-medium text-sky-500">
                                                {{ $linea->sim_card->vehiculos->placa }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">
                                                {{ $linea->sim_card->vehiculos->cliente ? $linea->sim_card->vehiculos->cliente->razon_social : '' }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="space-x-1">


                                                @if ($confirmation)
                                                    <button wire:click.prevent="confirmation()"
                                                        class="btn border-rose-400 hover:border-rose-800 text-rose-600">
                                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                                        </svg>
                                                        <span class="ml-2">Confirmar</span>
                                                    </button>
                                                @else
                                                    <button wire:click.prevent="removeLinea()"
                                                        class="btn border-slate-200 hover:border-slate-300 text-rose-500">
                                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                                        </svg>
                                                        <span class="ml-2">Remover Linea</span>
                                                    </button>
                                                @endif

                                            </div>

                                        </td>

                                    </tr>
                                    @if ($confirmation)
                                        <tr>
                                            <td colspan="3">
                                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                    Confirma la acción haciendo click nuevamente en el boton

                                                </p>
                                                <p>Se Guardara los datos de la linea en el vehiculo</p>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        @if (!$confirmation)
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                Debes eliminar el número del actual vehiculo para asignar a otro
                            </p>
                        @endif
                    @endif





                </div>
                <div class="px-8 py-5 bg-white sm:p-6">

                    <div class="grid grid-cols-12 gap-6">

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium mb-1" for="vehiculos_id">Vehiculo: <span
                                    class="text-rose-500">*</span></label>
                            <div class="relative" wire:ignore lang="es">

                                <select id="vehiculos_id" name="vehiculos_id"
                                    class="vehiculos_id w-full form-input pl-9 " required></select>

                                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                    <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                        <g class="nc-icon-wrapper">
                                            <path
                                                d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                                fill="#363636"></path>
                                            <path
                                                d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                                fill="#363636"></path>
                                            <path
                                                d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                                fill="#e3e3e3"></path>
                                            <path
                                                d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                                fill="#38a838"></path>
                                            <path
                                                d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                                fill="#78d478"></path>
                                            <circle cx="40" cy="27" r="3" fill="#fff">
                                            </circle>
                                            <circle cx="8" cy="27" r="3" fill="#fff">
                                            </circle>
                                            <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636">
                                            </path>
                                            <path
                                                d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                                fill="#49c549"></path>
                                            <circle cx="8" cy="34" r="2" fill="#f7bf26">
                                            </circle>
                                            <circle cx="40" cy="34" r="2" fill="#f7bf26">
                                            </circle>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            @error('vehiculos_id')
                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="px-5 py-4">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            @click="modalAsign = false" wire:click.prevent="closeModal">Cerrar</button>

                        @if (!$asignado)
                            <button wire:click.prevent="asign()"
                                class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('.vehiculos_id').select2({
            placeholder: '    Buscar un Vehiculo',
            language: "es",
            minimumInputLength: 2,
            selectionCssClass: 'pl-9',
            width: '100%',
            ajax: {
                url: '{{ route('search.vehiculos') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    var query = {
                        term: params.term,
                    }
                    return query;
                },
                processResults: function(data, params) {

                    var suggestions = $.map(data.suggestions, function(obj) {
                        obj.id = obj.id || obj.value;
                        obj.text = obj.data;
                        return obj;
                    });

                    return {
                        results: suggestions,
                    };

                },


            }
        });

        $('.vehiculos_id').on('select2:select', function(e) {

            var data = e.params.data;
            @this.set('vehiculo_id', data.id)

        });
    </script>
@endpush
