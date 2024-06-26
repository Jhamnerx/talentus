@extends('layouts.admin')
@section('ruta', 'almacen-sim-card')
@section('contenido')

    <!-- Table -->
    @livewire('admin.sim-card.index')
    @livewire('admin.sim-card.import')

@stop

@push('modals')
    @livewire('admin.sim-card.un-asign')
    @livewire('admin.sim-card.save')
    @livewire('admin.sim-card.edit')
    @livewire('admin.sim-card.asign-linea')
    @livewire('admin.sim-card.ver-cambios')
@endpush


@section('js')

@stop
