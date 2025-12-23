@extends('layouts.admin')
@section('ruta', 'admin-work-orders-index')
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

        <!-- Header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Órdenes de Trabajo</h1>
            </div>

            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                @livewire('admin.work-orders.create')
            </div>
        </div>

        <!-- Cards de resumen -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Pendientes</p>
                        <p class="text-2xl font-bold text-amber-600">
                            {{ \App\Models\WorkOrder::estado(\App\Enums\WorkOrderStatus::PENDIENTE)->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-amber-100 rounded-full">
                        <x-icon name="clock" class="w-6 h-6 text-amber-600" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">En Proceso</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ \App\Models\WorkOrder::estado(\App\Enums\WorkOrderStatus::EN_PROCESO)->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <x-icon name="cog" class="w-6 h-6 text-blue-600" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Finalizadas</p>
                        <p class="text-2xl font-bold text-emerald-600">
                            {{ \App\Models\WorkOrder::estado(\App\Enums\WorkOrderStatus::FINALIZADO)->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-emerald-100 rounded-full">
                        <x-icon name="check-circle" class="w-6 h-6 text-emerald-600" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Canceladas</p>
                        <p class="text-2xl font-bold text-rose-600">
                            {{ \App\Models\WorkOrder::estado(\App\Enums\WorkOrderStatus::CANCELADO)->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-rose-100 rounded-full">
                        <x-icon name="x-circle" class="w-6 h-6 text-rose-600" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        @livewire('admin.work-orders.tabla')

    </div>

@stop

@push('modals')
    {{-- Modales adicionales si son necesarios --}}
@endpush

@section('js')
    <script>
        Livewire.on('work-order-created', () => {
            window.$wireui.notify({
                title: 'Éxito',
                description: 'Orden de trabajo creada correctamente',
                icon: 'success'
            });
        });
    </script>
@stop
