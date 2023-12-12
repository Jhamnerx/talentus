@extends('layouts.admin')
@section('ruta', 'almacen-dispositivos')
@section('contenido')

    @livewire('admin.dispositivos.dispositivos-index')

@stop

@push('modals')
    @livewire('admin.dispositivos.show-info')
    @livewire('admin.dispositivos.save')
    @livewire('admin.dispositivos.edit')
    @livewire('admin.dispositivos.import')
@endpush


@section('js')


@stop
