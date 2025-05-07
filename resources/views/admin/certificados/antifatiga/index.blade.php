@extends('layouts.admin')
@section('ruta', 'certificados-velocimetro')
@section('contenido')

    <!-- Table -->

    @livewire('admin.certificados.antifatiga.index')

@stop

@push('modals')
    @livewire('admin.certificados.antifatiga.save')
    @livewire('admin.certificados.antifatiga.edit')
    @livewire('admin.certificados.antifatiga.delete')
    @livewire('admin.vehiculos.save-quick')
@endpush


@section('js')

@stop
