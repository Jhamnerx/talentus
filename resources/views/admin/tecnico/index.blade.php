@extends('layouts.admin')
@section('ruta', 'tecnico-tareas-index')
@section('contenido')

    @livewire('admin.tecnico.index')

@stop

@push('modals')
    @livewire('admin.tecnico.modal-dispositivos')
    @livewire('admin.tecnico.modal-sim')
@endpush

@section('js')

@stop
