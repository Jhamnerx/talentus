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
@endpush
@section('js')

@stop
