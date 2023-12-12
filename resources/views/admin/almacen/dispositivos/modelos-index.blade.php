@extends('layouts.admin')
@section('ruta', 'almacen-dispositivos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.dispositivos.modelos-dispositivos-index')

@stop

@push('modals')
    @livewire('admin.dispositivos.edit-modelo-dispositivo')
    @livewire('admin.dispositivos.delete-modelo')
@endpush

@section('js')

@stop
