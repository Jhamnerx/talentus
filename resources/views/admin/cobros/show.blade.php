@extends('layouts.admin')
@section('ruta', 'administracion-cobros')
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-white shadow-lg rounded-sm border border-slate-200 gap-2">
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">
            <div class="flex flex-row gap-2">
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
                    <div class="max-w-sm mx-auto lg:max-w-none">
                        <div class="bg-white p-5 shadow-lg rounded-lg border {{ $colorBorde }} lg:w-72 xl:w-96">
                            <div
                                class="text-slate-800 font-semibold mb-2 uppercase {{ $item->estado == 0 ? 'bg-red-200' : 'bg-white' }}">
                                Detalle de Cobro:
                                <b> {{ $item->vehiculo ? $item->vehiculo->placa : '' }}</b>
                            </div>
                            <ul class="mb-4">
                                <li
                                    class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold gap-1">
                                    <div>Empresa: </div>
                                    <div class="font-medium text-slate-800"> {{ $cobro->clientes->razon_social }}</div>
                                </li>
                                <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                                    <div>Placa: </div>
                                    <div class="font-medium text-slate-800">
                                        {{ $item->vehiculo ? $item->vehiculo->placa : '' }}</div>
                                </li>
                                <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">

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
                                <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                                    <div>Fecha Vencimiento: </div>
                                    <div class="font-medium {{ $colorClase }}">
                                        {{ $cobro->fecha_vencimiento->format('d-m-Y') }}
                                    </div>
                                </li>

                                <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                                    <div>Periodo: </div>
                                    <div class="font-medium text-slate-800">{{ $cobro->periodo }}</div>
                                </li>
                                <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                                    <div>Plan: </div>
                                    <div class="font-medium text-slate-800">{{ $item->plan }}</div>
                                </li>
                                <li class="text-sm w-full flex justify-between py-3 border-b border-slate-200 font-bold">
                                    <div>Tipo Pago: </div>
                                    <div class="font-medium text-slate-800">{{ $cobro->tipo_pago }}</div>
                                </li>
                            </ul>
                            <!-- observacion -->
                            @livewire('admin.cobros.suspend', ['detalle' => $item->id], key('suspend' . $item->id))
                            @livewire('admin.cobros.modal-suspend')
                            @livewire('admin.cobros.modal-activar')

                            @if (!$item->estado)
                                @can('admin.payments.create')
                                    @livewire('admin.cobros.payment', ['detalle' => $item->id], key('payment' . $item->id))
                                @endcan
                            @endif
                            <div class="text-xs text-slate-500 italic text-center">
                                {{ $cobro->comentario }}1
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($cobro->detalle->count() < 1)
                    <div class="max-w-sm mx-auto lg:max-w-none">
                        <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-96">
                            <span>NO HAY DETALLE</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
