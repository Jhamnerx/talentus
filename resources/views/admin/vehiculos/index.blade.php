@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.vehiculos.vehiculos-index')
    @livewire('admin.vehiculos.save-vehiculo')
    @livewire('admin.vehiculos.delete')
    @livewire('admin.vehiculos.import')
    @livewire('admin.vehiculos.suspend')
    @livewire('admin.vehiculos.mantenimiento.save', ['update' => session('updated-numero')])
    @livewire('admin.vehiculos.save-quick')


@stop

@section('js')

@stop
