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
@livewire('admin.tecnico.tareas.modales.w-reading')
@livewire('admin.tecnico.tareas.modales.complete')
@livewire('admin.tecnico.tareas.modales.pending')
@livewire('admin.tecnico.tareas.modales.canceled')
@endpush

@section('js')
<script>
    window.addEventListener('save-task', event => {
        iziToast.show({
            theme: 'dark',
            icon: 'far fa-envelope-open',
            title: 'TAREA CREADA',
            timeout: 2500,
            message: 'Se ha creado la tarea <b>'+event.detail.tarea.token+'</b>',
            position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: 'rgb(5, 44, 82)'
        });
    })

</script>

<script>
    // A basic demo function to handle "select all" functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('handleSelect', () => ({
                selectall: false,
                selected: [],
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
                    //console.log(this.selected);
                },
                toggleAll() {
                    this.selectall = !this.selectall;
                    checkboxes = document.querySelectorAll('input.table-item');
                    [...checkboxes].map((el) => {
                        el.checked = this.selectall;
                    });
                    ids = countEl = document.querySelectorAll('input.table-item');
                    [...ids].map((el) => {
                        if(el.checked){
                            selects.push(el.getAttribute('id-tarea'));
                        };
                    });
                    this.selected = selects;
                    this.selectAction();
                },
                uncheckParent() {
                    this.selectall = false;
                    selects = [];
                    document.getElementById('parent-checkbox').checked = false;
                    ids = countEl = document.querySelectorAll('input.table-item');
                    [...ids].map((el) => {
                        if(el.checked){
                            selects.push(el.getAttribute('id-tarea'));
                        };
                    });
                    this.selected = selects;
                    this.selectAction();
                }
            }))
        })
</script>
@stop
