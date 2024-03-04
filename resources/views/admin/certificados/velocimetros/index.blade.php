@extends('layouts.admin')
@section('ruta', 'certificados-velocimetro')
@section('contenido')

    <!-- Table -->

    @livewire('admin.certificados.velocimetros.velocimetros-index')

@stop

@push('modals')
    @livewire('admin.certificados.velocimetros.save')
    @livewire('admin.certificados.velocimetros.edit')
    @livewire('admin.certificados.velocimetros.send')
    @livewire('admin.certificados.velocimetros.delete')
    @livewire('admin.vehiculos.save-quick')
@endpush


@section('js')

@stop
