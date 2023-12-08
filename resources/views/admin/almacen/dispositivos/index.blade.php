@extends('layouts.admin')
@section('ruta', 'almacen-dispositivos')
@section('contenido')

    @livewire('admin.dispositivos.dispositivos-index')

@stop

@push('modals')
    @livewire('admin.dispositivos.show-info')
    @livewire('admin.dispositivos.save')
@endpush


@section('js')


@stop
