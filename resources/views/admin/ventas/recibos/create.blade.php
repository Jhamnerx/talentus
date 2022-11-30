@extends('layouts.admin')
@section('ruta', 'ventas-recibos')


@section('contenido')

    @livewire('admin.ventas.recibos.create')


@stop

@push('modals')
    @livewire('admin.clientes.save')
@endpush
