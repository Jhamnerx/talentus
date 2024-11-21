@extends('layouts.admin')

@section('ruta', 'almacen-categorias')



@section('contenido')

<!-- Table -->
@livewire('admin.categorias.index')


@stop


@push('modals')
@livewire('admin.categorias.create-modal')
@livewire('admin.categorias.edit-modal')
@livewire('admin.categorias.delete')
@endpush

{{-- section de js --}}
@section('js')



@stop