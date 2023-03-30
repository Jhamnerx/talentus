@extends('layouts.admin')
@section('ruta', 'almacen-lineas')
@section('contenido')

    <!-- Table -->

    @livewire('admin.lineas.index')
    @livewire('admin.lineas.asign-to-placa')
    @livewire('admin.lineas.suspend-linea')

@stop

@section('js')
    <script>
        window.addEventListener('asign-linea-to-placa', event => {
            iziToast.success({
                position: 'topRight',
                title: '#' + event.detail.linea,
                message: 'Numero asignado a la siguiente placa: ' + event.detail.placa,
            });
            $('.vehiculos_id').val(null).trigger('change');
        })
    </script>

    @if (session('store'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: '{{ session('store') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif
    @if (session('asign'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Asignado',
                    text: '{{ session('asign') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif
    @if (session('update'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: '{{ session('update') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif

    @if (session('delete'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: '{{ session('delete') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif

    @if (session('unasign'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: '{{ session('unasign') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif
    @if (session()->has('import'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Importar',
                    text: '{{ session('import') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif




    {{-- SUSPEND SCRIPTS --}}

    <script>
        $(document).ready(function() {
            flatpickr('.fechaInicio', {
                mode: 'single',
                disableMobile: "true",
                defaultDate: "today",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        });

        $(document).ready(function() {
            flatpickr('.fechaFinal', {
                mode: 'single',
                disableMobile: "true",
                defaultDate: [new Date().setDate(new Date().getDate() + 60), new Date()],
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        });
    </script>


    <script>
        window.addEventListener('suspend-save', event => {
            iziToast.success({
                maxWidth: 500,
                position: 'center',
                title: 'Se ha guardado el registro de suspencion!',
                message: 'Las siguientes Lineas: ' + event.detail.lista,
                position: 'topRight',
                transitionIn: 'bounceInLeft',
                // iconText: 'star',
                onOpened: function(instance, toast) {},
                onClosed: function(instance, toast, closedBy) {
                    console.info('closedBy: ' + closedBy);
                }
            });
        })
    </script>
@stop
