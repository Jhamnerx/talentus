@extends('layouts.admin')
@section('ruta', 'tecnico-tareas-index')
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- header -->
        <x-admin.tecnico.tareas.header>
        </x-admin.tecnico.tareas.header>

        <!-- More actions -->

        @livewire('admin.tecnico.tareas.actions')
        @livewire('admin.tecnico.tareas.cards')



        {{-- tabla historial tareas --}}
        @livewire('admin.tecnico.tareas.tabla-historial')
        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-b border-gray-300"></div>
            </div>

        </div>
        @can('tecnico.tareas.tipo.index')
            @livewire('admin.tecnico.tareas.tabla-tipo-tarea')
        @endcan

    </div>

    <!-- Modal de chat CHAT-->
    @livewire('admin.tecnico.notificaciones.cliente-contactos')
@stop

@push('modals')
    @livewire('admin.tecnico.tareas.create-task')
    @livewire('admin.tecnico.tareas.reportes.reporte-principal')
    @livewire('admin.tecnico.tareas.edit-task')
    @livewire('admin.tecnico.tareas.modales.w-reading')
    @livewire('admin.tecnico.tareas.modales.complete')
    @livewire('admin.tecnico.tareas.modales.pending')
    @livewire('admin.tecnico.tareas.modales.canceled')
    @livewire('admin.tecnico.tareas.modales.show-tecnicos')
    @livewire('admin.tecnico.tareas.tipos.create')
    @livewire('admin.tecnico.tareas.tipos.edit')
    @livewire('admin.tecnico.tareas.delete')
    @livewire('admin.tecnico.tareas.modales.cancelar-modal')


    {{-- ckeditpor --}}
    @livewire('admin.tecnico.tareas.inform-task')

    {{-- iframe --}}
    @livewire('admin.tecnico.tareas.modales.iframe')
@endpush

@section('js')

@stop
