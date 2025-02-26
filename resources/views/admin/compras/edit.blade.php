@extends('layouts.admin')

@section('contenido')

    @livewire('admin.compras.edit', ['compra' => $compra])

@stop

@push('modals')
@endpush

{{-- section de js --}}
@section('js')

@endsection
