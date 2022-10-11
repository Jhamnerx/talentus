@extends('layouts.admin')
@section('ruta', 'administracion-cobros')
@section('contenido')


    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-white shadow-lg rounded-sm border border-slate-200">

        <!-- Page content -->
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">
            <!-- Sidebar -->
            <div class="max-w-sm mx-auto lg:max-w-none">
                <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-96">
                    <div class="text-slate-800 font-semibold mb-2 uppercase">Detalle de Cobro</div>
                    <!-- Order details -->
                    <ul class="mb-4">
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold gap-1">
                            <div>Empresa: </div>
                            <div class="font-medium text-slate-800"> {{ $cobro->clientes->razon_social }}</div>
                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Placa: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->vehiculo->placa }}</div>
                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">

                            <div>Estado: </div>
                            @if ($cobro->suspendido)
                                <div class="text-sm font-semibold text-white px-1.5 bg-red-500 rounded-full">Suspendido
                                </div>
                            @else
                                <div class="text-sm font-semibold text-white px-1.5 bg-emerald-500 rounded-full">Activo
                                </div>
                            @endif



                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Fecha Vencimiento: </div>
                            <div class="font-medium text-emerald-600">{{ $cobro->fecha_vencimiento->format('d-m-Y') }}</div>
                        </li>

                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Periodo: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->periodo }}</div>
                        </li>
                        <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                            <div>Tipo Pago: </div>
                            <div class="font-medium text-slate-800">{{ $cobro->tipo_pago }}</div>
                        </li>
                    </ul>
                    <!-- observacion -->

                    @livewire('admin.cobros.suspend', ['cobro' => $cobro->id], key('suspend' . $cobro->id))
                    @livewire('admin.cobros.modal-suspend')
                    @livewire('admin.cobros.modal-activar')


                    @if (!$cobro->suspendido)
                        @livewire('admin.cobros.payment', ['cobro' => $cobro->id], key('payment' . $cobro->id))
                    @endif


                    <div class="text-xs text-slate-500 italic text-center">
                        {{ $cobro->comentario }}
                    </div>
                </div>
            </div>

            <!-- pagos -->
            <div class="mt-6 lg:mt-0 xl:ml-12">
                <div class="mb-3">
                    <div class="flex text-sm font-medium text-slate-400 space-x-2">
                        <span class="text-indigo-500">Administración</span>
                        <span>-&gt;</span>
                        <span class="text-slate-500">Pagos</span>
                        <span>-&gt;</span>
                        <span class="text-slate-500">Resumen</span>
                    </div>
                </div>
                <header class="mb-2">
                    <h1 class="text-2xl md:text-3xl text-slate-800 font-semibold">Pagos realizados ✨</h1>
                </header>

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
                                        PAGO DEL DOCUMENTO {{ $payment->paymentable->numero }} .
                                    </h3>

                                    <div class="text-sm mb-2">
                                        Pago Realizado en {{ $payment->paymentMethod->name }}
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
                                        <button class="text-sm underline hover:no-underline">{{ $payment->fecha }}</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                @endif


                <div class="mt-6 text-center lg:text-left">
                    <a class="text-sm font-medium text-indigo-500 hover:text-indigo-600"
                        href="{{ route('admin.cobros.index') }}">&lt;- Volver a la
                        lista</a>
                </div>



            </div>



        </div>

    </div>

@stop
@push('modals')
@endpush


@section('js')

@stop
