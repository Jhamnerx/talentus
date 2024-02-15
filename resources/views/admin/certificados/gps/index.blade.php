@extends('layouts.admin')
@section('ruta', 'certificados-gps')
@section('contenido')

    <!-- Table -->
    @livewire('admin.certificados.gps.certificados-gps-index')


@stop

@push('modals')
    @livewire('admin.certificados.gps.save')
    @livewire('admin.certificados.gps.edit')
    @livewire('admin.certificados.gps.send')
    @livewire('admin.certificados.gps.delete')
@endpush

@section('js')

@stop
