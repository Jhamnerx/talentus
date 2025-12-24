@extends('admin.layouts.app')

@section('title', 'Checklist - ' . $workOrder->codigo)

@section('content')
    <div class="container mx-auto px-4 py-6">
        @livewire('admin.work-orders.checklist', ['workOrder' => $workOrder, 'fase' => $fase])
    </div>
@endsection
