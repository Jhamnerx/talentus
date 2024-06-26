@extends('layouts.admin')
@section('ruta', 'administracion-ajustes')
@section('panel', "settingsPanel: 'series',")
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Series Comprobantes ✨</h1>

        </div>

        <div class="bg-white shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <x-admin.settings.navigation></x-admin.settings.navigation>

                <div class="grow">

                    <div class="p-6 space-y-6">
                        @livewire('admin.ajustes.series.index')


                    </div>


                </div>

            </div>

        </div>

    </div>


@stop

@push('modals')
    @livewire('admin.ajustes.series.delete')
@endpush
@section('js')

@endsection
