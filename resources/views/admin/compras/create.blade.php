@extends('layouts.admin')
@section('ruta', 'compras-facturas')


@section('contenido')

    @livewire('admin.compras.create')

@stop


@push('modals')
@endpush

@section('js')



@endsection
