@extends('layouts.admin')
@section('ruta', 'ventas-recibos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.ventas.recibos.recibos-index')
    @livewire('admin.ventas.recibos.reportes')
    @livewire('admin.ventas.recibos.send')
    @livewire('admin.ventas.recibos.delete')

@stop

@section('js')


@stop
