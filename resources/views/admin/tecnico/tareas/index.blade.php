@extends('layouts.admin')
@section('ruta', 'tecnico-tareas-index')
@section('contenido')

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- header -->
        <x-admin.tecnico.tareas.header>
        </x-admin.tecnico.tareas.header>

        <!-- More actions -->

        @livewire('admin.tecnico.tareas.actions')
        @livewire('admin.tecnico.tareas.cards')



        {{-- tabla historial tareas --}}
        @livewire('admin.tecnico.tareas.tabla-historial')
        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-b border-gray-300"></div>
            </div>

        </div>
        @can('tecnico.tareas.tipo.index')
            @livewire('admin.tecnico.tareas.tabla-tipo-tarea')
        @endcan

    </div>

    <!-- Modal de chat CHAT-->
    @livewire('admin.tecnico.notificaciones.cliente-contactos')
@stop

@push('modals')
    @livewire('admin.tecnico.tareas.create-task')
    @livewire('admin.tecnico.tareas.reportes.reporte-principal')
    @livewire('admin.tecnico.tareas.edit-task')
    @livewire('admin.tecnico.tareas.modales.w-reading')
    @livewire('admin.tecnico.tareas.modales.complete')
    @livewire('admin.tecnico.tareas.modales.pending')
    @livewire('admin.tecnico.tareas.modales.canceled')
    @livewire('admin.tecnico.tareas.modales.show-tecnicos')
    @livewire('admin.tecnico.tareas.tipos.create')
    @livewire('admin.tecnico.tareas.tipos.edit')
    @livewire('admin.tecnico.tareas.delete')


    {{-- ckeditpor --}}
    @livewire('admin.tecnico.tareas.inform-task')


    </div>
@endpush

@section('js')

    <script>
        // INICIALIZAR LOS INPUTS DE FECHA
        $(document).ready(function() {
            cont = 0;
            detalles = 0;
            flatpickr('.fechaInicio', {
                mode: 'single',
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
            flatpickr('.fechaFin', {
                mode: 'single',
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        })
    </script>

    <script>
        window.addEventListener('save-task', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'TAREA CREADA',
                timeout: 2500,
                message: 'Se ha creado la tarea <b>' + event.detail.tarea.token + '</b>',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
            });
        })
    </script>

    <script>
        window.addEventListener('update-task', event => {
            iziToast.show({
                color: event.detail.color,
                icon: '<i class="fas fa-tasks"></i>',
                title: event.detail.titulo,
                timeout: 2500,
                message: '<b>' + event.detail.message + ' ' + event.detail.token + '</b>',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: event.detail.progressBarColor
            });
        })
    </script>


    <script>
        window.addEventListener('save-imagen', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'IMAGEN GUARDADA',
                timeout: 2500,
                message: 'Se guardo la imagen de la tarea <b>' + event.detail.tarea + '</b>',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
            });
        })
    </script>
    <script>
        window.addEventListener('mensaje-enviado', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'NOTIFICACIÓN POR WHATSAPP',
                timeout: 2500,
                message: 'Se envio la notificación',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)',
            });
        })
    </script>
    <script>
        window.addEventListener('error-mensaje-whatsapp', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'OCURRIO UN ERROR AL ENVIAR',
                timeout: 2500,
                message: 'No se pudo enviar el mensaje: ' + event.detail.error,
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(237, 71, 82)'
            });
        })

        window.addEventListener('not-number', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'OCURRIO UN ERROR AL ENVIAR',
                timeout: 2500,
                message: 'No se encontro un número registrado',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(237, 71, 82)'
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
                        if (el.checked) {
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
                        if (el.checked) {
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
