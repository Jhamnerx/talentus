@extends('layouts.admin')

@section('contenido')

    @livewire('admin.facturacion.ventas.index')

@stop

@push('modals')
    @livewire('admin.facturacion.ventas.anular-comprobante', [], key('anular-comprobante'))
@endpush
