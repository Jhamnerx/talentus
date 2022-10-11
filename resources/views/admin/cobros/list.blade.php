@extends('layouts.admin')
@section('ruta', 'administracion-cobros')

@section('contenido')

    <!-- Table -->

    @livewire('admin.cobros.clientes-list', ['cliente' => $cliente])

@stop

@section('js')

@stop
