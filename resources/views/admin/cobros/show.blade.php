@extends('layouts.admin')
@section('ruta', 'administracion-cobros')
@section('contenido')

    @livewire('admin.cobros.show', ['cobro' => $cobro])

@stop


@push('modals')
    @livewire('admin.cobros.payment')
    @livewire('admin.cobros.modal-suspend')
    @livewire('admin.cobros.modal-activar')
@endpush
