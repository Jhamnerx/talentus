@extends('layouts.admin')
@section('ruta', 'tecnico-tareas-index')
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- header -->
        <x-admin.tecnico.tareas.header>
        </x-admin.tecnico.tareas.header>

        <!-- More actions -->
        <x-admin.tecnico.tareas.actions>
        </x-admin.tecnico.tareas.actions>
        @livewire('admin.tecnico.tareas.cards')
    </div>

@stop

@section('js')

@stop
