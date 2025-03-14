<div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-white shadow-lg rounded-sm border border-slate-200">
    <div class="max-w-[90%] mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">

        @if ($detalleIds)
            <div class="col-span-full mb-4">
                <div class="flex justify-center space-x-2 mb-2">
                    @if ($cobro->clientes->tipo_documento_id == 1)
                        <x-form.button full="true" cyan wire:click.prevent="createBoletaGeneral()"
                            right-icon="currency-dollar" success label="Crear Boleta" />
                    @endif
                    @if ($cobro->clientes->tipo_documento_id == 6)
                        <x-form.button full="true" sky wire:click.prevent="createFacturaGeneral()"
                            right-icon="currency-dollar" success label="Crear Factura" />
                    @endif
                    <x-form.button full="true" slate wire:click.prevent="createReciboGeneral()"
                        right-icon="currency-dollar" success label="Crear Recibo" />
                </div>
            </div>
        @endif

        @foreach ($cobro->detalle as $item)
            @php
                $diasRestantes = \Carbon\Carbon::now()->diffInDays($item->fecha, false);
                $colorClase = '';
                if ($diasRestantes > 30) {
                    $colorClase = 'text-emerald-600';
                    $colorBorde = 'border-emerald-600';
                } elseif ($diasRestantes <= 30 && $diasRestantes > 15) {
                    $colorClase = 'text-orange-500';
                    $colorBorde = 'border-orange-500';
                } elseif ($diasRestantes <= 15) {
                    $colorClase = 'text-red-500';
                    $colorBorde = 'border-red-500';
                }
            @endphp
            <div class="bg-white p-5 shadow-lg rounded-lg border {{ $colorBorde }}">

                <div class="flex justify-between items-center mb-2">
                    <x-form.checkbox id="size-sm" wire:model.live="detalleIds" value="{{ $item->id }}" md />
                    <div
                        class="text-slate-800 mx-2 font-semibold uppercase {{ $item->estado == 0 ? 'bg-red-200' : 'bg-white' }}">
                        Detalle de Cobro: <b> {{ $item->vehiculo ? $item->vehiculo->placa : '' }}</b>
                    </div>

                </div>


                <ul class="mb-4">
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Empresa: </div>
                        <div class="font-medium text-slate-800"> {{ $cobro->clientes->razon_social }}</div>
                    </li>
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Placa: </div>
                        <div class="font-medium text-slate-800">
                            {{ $item->vehiculo ? $item->vehiculo->placa : '' }}</div>
                    </li>
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Estado: </div>
                        @if ($item->estado == '0')
                            <div class="text-sm font-semibold text-white px-1.5 bg-red-500 rounded-full">
                                Suspendido
                            </div>
                        @else
                            <div class="text-sm font-semibold text-white px-1.5 bg-emerald-500 rounded-full">
                                Activo
                            </div>
                        @endif
                    </li>
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Fecha Vencimiento: </div>
                        <div class="font-medium {{ $colorClase }}">
                            {{ $item->fecha->format('d-m-Y') }}
                        </div>
                    </li>
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Periodo: </div>
                        <div class="font-medium text-slate-800">{{ $cobro->periodo }}</div>
                    </li>
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Plan: </div>
                        <div class="font-medium text-slate-800">{{ $item->plan }}</div>
                    </li>
                    <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                        <div>Tipo Pago: </div>
                        <div class="font-medium text-slate-800">{{ $cobro->tipo_pago }}</div>
                    </li>
                </ul>

                @livewire('admin.cobros.suspend', ['detalle' => $item], key('suspend' . $item->id))

                @if ($item->estado)
                    @can('admin.payments.create')
                        <div class="flex justify-center mb-4">
                            <x-form.button wire:click.prevent="openModalPayment({{ $item->id }})"
                                right-icon="exclamation-triangle" warning label=" Pagar - ${{ $item->plan }}" />
                        </div>
                    @endcan
                @endif

                <li class="text-sm flex justify-between py-3 border-b border-slate-200 font-bold">
                    <div>Opciones Facturación: </div>

                </li>
                <div class="mt-6">
                    @if ($cobro->clientes->tipo_documento_id == 1)
                        <div class="flex justify-center mb-2">
                            <x-form.button full="true" cyan wire:click.prevent="createBoleta([{{ $item->id }}])"
                                right-icon="currency-dollar" success label="Crear Boleta" />
                        </div>
                    @endif
                    @if ($cobro->clientes->tipo_documento_id == 6)
                        <div class="flex justify-center mb-2">
                            <x-form.button full="true" sky wire:click.prevent="createFactura([{{ $item->id }}])"
                                right-icon="currency-dollar" success label="Crear Factura" />
                        </div>
                    @endif
                    <div class="flex justify-center mb-2">
                        <x-form.button full="true" slate wire:click.prevent="createRecibo([{{ $item->id }}])"
                            right-icon="currency-dollar" success label="Crear Recibo" />
                    </div>
                </div>

                <div class="text-xs text-slate-500 italic text-center">
                    {{ $cobro->comentario }}
                </div>
            </div>
        @endforeach

        @if ($cobro->detalle->count() < 1)
            <div class="bg-white p-5 shadow-lg rounded-lg border border-slate-200">
                <span>NO HAY DETALLE</span>
            </div>
        @endif
    </div>

    {{-- PAGOS REALIZADOS --}}
    @if ($cobro->payments)
        <div class="overflow-auto min-h-screen h-screen">
            @foreach ($cobro->payments as $payment)
                <div class="sm:flex items-center py-6 border-b border-slate-200 bg-white shadow-md mx-2 px-2">
                    <a class="block mb-4 sm:mb-0 mr-5 md:w-32 xl:w-auto shrink-0">

                        <svg class="w-44 h-44" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path
                                    d="M42,47H6a1,1,0,0,1-.983-1.187L9,24.906V14a1,1,0,0,1,1-1H38a1,1,0,0,1,1,1V24.906l3.982,20.907A1,1,0,0,1,42,47Z"
                                    fill="#ffd764"></path>
                                <path
                                    d="M31,21a1,1,0,0,1-1-1V9A6,6,0,0,0,18,9V20a1,1,0,0,1-2,0V9A8,8,0,0,1,32,9V20A1,1,0,0,1,31,21Z"
                                    fill="#a2703f"></path>
                            </g>
                        </svg>
                    </a>
                    <div class="grow">

                        <h3 class="text-lg font-semibold text-slate-800 mb-1">
                            PAGO DEL DOCUMENTO {{ $payment->paymentable->serie_numero }} .
                        </h3>

                        <div class="text-sm mb-2">
                            Pago Realizado en
                            <span
                                class="font-semibold text-slate-900">{{ $payment->paymentMethod->descripcion }}</span>
                            con número de operación
                            <span class="font-semibold text-slate-900">{{ $payment->numero_operacion }}</span>
                        </div>
                        <!-- Product meta -->
                        <div class="flex flex-wrap justify-between items-center">
                            <!-- Rating and price -->
                            <div class="flex flex-wrap items-center space-x-2 mr-2">

                                <div class="text-slate-400">{{ $payment->numero }}</div>
                                <!-- Price -->
                                <div>
                                    <div
                                        class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">
                                        {{ $payment->paymentable->divisa }}
                                        {{ $payment->monto }}
                                    </div>
                                </div>
                            </div>
                            <button
                                class="text-sm underline hover:no-underline">{{ $payment->fecha->format('d-m-Y') }}</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif
</div>
