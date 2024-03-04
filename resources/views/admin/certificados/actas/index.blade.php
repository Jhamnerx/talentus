@extends('layouts.admin')
@section('ruta', 'certificados-actas')
@section('contenido')

    <!-- Table -->
    @livewire('admin.certificados.actas.actas-index')

@stop

@push('modals')
    @livewire('admin.certificados.actas.save')
    @livewire('admin.certificados.actas.edit')
    @livewire('admin.certificados.actas.send')
    @livewire('admin.certificados.actas.delete')
@endpush

@section('js')


@stop
