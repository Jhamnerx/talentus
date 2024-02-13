@extends('layouts.admin')
@section('ruta', 'vehiculos-reportes')
@section('contenido')

    <!-- Table -->


    @livewire('admin.vehiculos.reportes.index')

@stop

@push('modals')
    @livewire('admin.vehiculos.reportes.show-contactos')
    @livewire('admin.vehiculos.reportes.save')
    @livewire('admin.vehiculos.reportes.edit')
    @livewire('admin.vehiculos.reportes.delete')
    @livewire('admin.vehiculos.reportes.show-detalle')
    @livewire('admin.vehiculos.reportes.recordatorio')
@endpush



@section('js')





@stop
