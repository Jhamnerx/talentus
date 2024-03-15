@extends('layouts.admin')
@section('ruta', 'almacen-lineas')
@section('contenido')

    @livewire('admin.lineas.index')


@stop

@push('modals')
    @livewire('admin.lineas.asign-to-placa')
    @livewire('admin.lineas.suspend-linea')
    @livewire('admin.lineas.save')
    @livewire('admin.lineas.edit')
    @livewire('admin.gerencia.reportes.modales.reporte-lineas')
    @livewire('admin.sim-card.asign-linea')
@endpush

@section('js')



@stop
