@extends('layouts.admin')
@section('ruta', 'ventas-recibos')


@section('contenido')

    @livewire('admin.ventas.recibos.edit', ['recibo' => $recibo])

@stop

@push('modals')
    @livewire('admin.clientes.save')
@endpush
