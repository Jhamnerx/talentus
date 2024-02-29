@extends('layouts.admin')
@section('ruta', 'administracion-recibos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.gerencia.recibos.index')

@stop

@push('modals')
    @livewire('admin.gerencia.recibos.delete')
@endpush

@section('js')



@stop
