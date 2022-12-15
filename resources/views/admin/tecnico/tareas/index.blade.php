@extends('layouts.admin')
@section('ruta', 'tecnico-tareas-index')
@section('contenido')

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- header -->
    <x-admin.tecnico.tareas.header>
    </x-admin.tecnico.tareas.header>

    <!-- More actions -->
    <x-admin.tecnico.tareas.actions>
    </x-admin.tecnico.tareas.actions>

    @livewire('admin.tecnico.tareas.cards')

    {{-- tabla historial tareas --}}
    @livewire('admin.tecnico.tareas.tabla-historial')

</div>

@stop

@push('modals')
@livewire('admin.tecnico.tareas.create-task')
@endpush

@section('js')
<script>
    // A basic demo function to handle "select all" functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('handleSelect', () => ({
                selectall: false,
                selectAction() {
                    countEl = document.querySelector('.table-items-action');
                    if (!countEl) return;
                    checkboxes = document.querySelectorAll('input.table-item:checked');
                    document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                    if (checkboxes.length > 0) {
                        countEl.classList.remove('hidden');
                    } else {
                        countEl.classList.add('hidden');
                    }
                },
                toggleAll() {
                    this.selectall = !this.selectall;
                    checkboxes = document.querySelectorAll('input.table-item');
                    [...checkboxes].map((el) => {
                        el.checked = this.selectall;
                    });
                    this.selectAction();
                },
                uncheckParent() {
                    this.selectall = false;
                    document.getElementById('parent-checkbox').checked = false;
                    this.selectAction();
                }
            }))
        })
</script>
@stop
