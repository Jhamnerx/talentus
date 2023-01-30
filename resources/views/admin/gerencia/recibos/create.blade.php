@extends('layouts.admin')
@section('ruta', 'administracion-recibos')


@section('contenido')

    @livewire('admin.gerencia.recibos.create')


@stop

@push('modals')
    @livewire('admin.clientes.save')
@endpush
