@extends('layouts.admin')
@section('ruta', 'administracion-reportes-gerenciales')
@section('contenido')

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-200 font-bold">REPORTES GERENCIALES</h1>
        </div>

    </div>


    @livewire('admin.gerencia.reportes.cards')

    {{-- HISTORIAL --}}
    @livewire('admin.gerencia.reportes.historial-models')






</div>

@stop

@push('modals')
@livewire('admin.gerencia.reportes.modales.reporte-productos')
@livewire('admin.gerencia.reportes.modales.reporte-lineas')
@livewire('admin.gerencia.reportes.modales.reporte-clientes')
@livewire('admin.gerencia.reportes.modales.reporte-vehiculos')
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
            message: 'Se ha creado la tarea <b>'+event.detail.tarea.token+'</b>',
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
            message: '<b>'+event.detail.message+' '+event.detail.token+'</b>',
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
            message: 'Se guardo la imagen de la tarea <b>'+event.detail.tarea+'</b>',
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
