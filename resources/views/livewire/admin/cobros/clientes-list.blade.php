    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Smaller container -->
        <div class="max-w-5xl mx-auto">

            <!-- Page header -->
            <div class="sm:flex sm:justify-between sm:items-center mb-8">

                <!-- Left: Title -->
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">{{ $cliente->razon_social }} ✨</h1>
                </div>

                <!-- Right: Actions -->
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-4">


                    <!-- Add taks button -->
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="ml-2">AGREGAR</span>
                    </button>

                </div>

            </div>

            <!-- Tasks -->
            <div class="space-y-6">

                <!-- Group 1 -->
                <div>
                    <h2 class="grow font-semibold text-slate-800 truncate mb-4">ACTIVOS 🖋️</h2>
                    <div class="space-y-2">

                        <!-- item -->
                        @foreach ($cliente->cobros()->estado('0')->get() as $cobro)
                            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4" draggable="true">
                                <div class="sm:flex sm:justify-between sm:items-start">

                                    <div class="grow mt-0.5 mb-3 sm:mb-0 space-y-3 sm:w-4/5">
                                        <div class="flex items-center">
                                            <!-- Drag button -->
                                            <button class="cursor-move mr-2">
                                                <span class="sr-only">Drag</span>
                                                <svg class="w-3 h-3 fill-slate-500" viexBox="0 0 12 12"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 1h12v2H0V1Zm0 4h12v2H0V5Zm0 4h12v2H0V9Z" fill="#CBD5E1"
                                                        fill-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <!-- Checkbox button and description -->

                                            <label class="flex items-center">
                                                <input type="checkbox"
                                                    class="peer focus:ring-0 focus-visible:ring w-5 h-5 bg-white border border-slate-200 text-indigo-500 rounded-full" />
                                                <span class="font-light text-slate-800 ml-2">

                                                    SERVICIO MONITOREO VEHICULO CON PLACA:
                                                    <span class="font-medium">{{ $cobro->vehiculo->placa }}</span>
                                                    PLAN
                                                    <span class="font-medium">{{ $cobro->monto_unidad }}</span> PERIODO
                                                    <span class="font-medium">{{ $cobro->periodo }}</span> CON
                                                    DOCUMENTO DE PAGO: <span
                                                        class="font-medium">{{ $cobro->tipo_pago }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end space-x-3 sm:w-1/5">
                                        <!-- Date -->
                                        <div class="flex items-center text-green-500">
                                            <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                <path
                                                    d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                            </svg>
                                            <div class="text-sm text-green-600">
                                                {{ $cobro->fecha_vencimiento->format('d-m-Y') }}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>

                <!-- Group 2 -->
                <div>
                    <h2 class="grow font-semibold text-slate-800 truncate mb-4">POR VENCER ✌️</h2>
                    <div class="space-y-2">

                        @foreach ($cliente->cobros()->estado('1')->get() as $cobro)
                            <!-- item -->
                            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4" draggable="true">
                                <div class="sm:flex sm:justify-between sm:items-start">

                                    <div class="grow mt-0.5 mb-3 sm:mb-0 space-y-3 sm:w-4/5">
                                        <div class="flex items-center">

                                            <button class="cursor-move mr-2">
                                                <span class="sr-only">Drag</span>
                                                <svg class="w-3 h-3 fill-slate-500" viexBox="0 0 12 12"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 1h12v2H0V1Zm0 4h12v2H0V5Zm0 4h12v2H0V9Z" fill="#CBD5E1"
                                                        fill-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <label class="flex items-center">
                                                <input type="checkbox"
                                                    class="peer focus:ring-0 focus-visible:ring w-5 h-5 bg-white border border-slate-200 text-indigo-500 rounded-full" />
                                                <span class="font-light text-slate-800 ml-2">

                                                    SERVICIO MONITOREO VEHICULO CON PLACA:
                                                    <span class="font-medium">{{ $cobro->vehiculo->placa }}</span>
                                                    PLAN
                                                    <span class="font-medium">{{ $cobro->monto_unidad }}</span> PERIODO
                                                    <span class="font-medium">{{ $cobro->periodo }}</span> CON
                                                    DOCUMENTO DE PAGO: <span
                                                        class="font-medium">{{ $cobro->tipo_pago }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end space-x-3 sm:w-1/5">
                                        <!-- Date -->
                                        <div class="flex items-center text-amber-500">
                                            <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                <path
                                                    d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                            </svg>
                                            <div class="text-sm text-amber-600">
                                                {{ $cobro->fecha_vencimiento->format('d-m-Y') }}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>

                <!-- Group 3 -->
                <div>
                    <h2 class="grow font-semibold text-slate-800 truncate mb-4">VENCIDOS 🎉</h2>
                    <div class="space-y-2">
                        @foreach ($cliente->cobros()->estado('2')->get() as $cobro)
                            <!-- item -->
                            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4 opacity-80">
                                <div class="sm:flex sm:justify-between sm:items-start">

                                    <div class="grow mt-0.5 mb-3 sm:mb-0 space-y-3 sm:w-4/5">
                                        <div class="flex items-center">

                                            <button class="cursor-move mr-2">
                                                <span class="sr-only">Drag</span>
                                                <svg class="w-3 h-3 fill-slate-500" viexBox="0 0 12 12"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 1h12v2H0V1Zm0 4h12v2H0V5Zm0 4h12v2H0V9Z" fill="#CBD5E1"
                                                        fill-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <label class="flex items-center">
                                                <input type="checkbox" checked
                                                    class="peer focus:ring-0 focus-visible:ring w-5 h-5 bg-white border border-slate-200 text-indigo-500 rounded-full" />
                                                <span class="font-light text-slate-800 ml-2 peer-checked:line-through">

                                                    SERVICIO MONITOREO VEHICULO CON PLACA:
                                                    <span class="font-medium">{{ $cobro->vehiculo->placa }}</span>
                                                    PLAN
                                                    <span class="font-medium">{{ $cobro->monto_unidad }}</span> PERIODO
                                                    <span class="font-medium">{{ $cobro->periodo }}</span> CON
                                                    DOCUMENTO DE PAGO: <span
                                                        class="font-medium">{{ $cobro->tipo_pago }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end space-x-3 sm:w-1/5">
                                        <!-- Date -->
                                        <div class="flex items-center text-red-600">
                                            <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                <path
                                                    d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                            </svg>
                                            <div class="text-sm text-red-700">
                                                {{ $cobro->fecha_vencimiento->format('d-m-Y') }}</div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>
