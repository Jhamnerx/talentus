@extends('layouts.admin')
@section('ruta', 'administracion-recibos')


@section('contenido')

    @livewire('admin.gerencia.recibos.edit', ['recibo' => $recibo])


@stop

@push('modals')
    @livewire('admin.clientes.save')
@endpush
