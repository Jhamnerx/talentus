@extends('layouts.admin')
@section('ruta', 'vehiculos-mantenimiento')
@section('contenido')

    <!-- Tabla -->
    @livewire('admin.vehiculos.mantenimiento.index')
    @livewire('admin.vehiculos.mantenimiento.save')
    @livewire('admin.vehiculos.mantenimiento.edit')
    @livewire('admin.vehiculos.mantenimiento.create-task')
    @livewire('admin.vehiculos.mantenimiento.delete')
    @livewire('admin.vehiculos.mantenimiento.export')

@stop

@section('js')

    <script>
        window.addEventListener('mantenimiento-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Registro Eliminado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>

    <script>
        window.addEventListener('mantenimiento-save', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'Tarea Mantenimiento guardada',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
            $('.vehiculos_id').val(null).trigger('change');
        })
    </script>
    <script>
        window.addEventListener('mantenimiento-update', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'Tarea Mantenimiento Actualizado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
            $('.vehiculos_id_edit').val(null).trigger('change');
        })
    </script>
    <script>
        window.addEventListener('mantenimiento-update', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualización',
                    text: 'Tarea Mantenimiento actualizada',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
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
        window.addEventListener('mark-as', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'MANTENIMIENTO MARCADO COMO: ' + event.detail.estado,
                timeout: 2500,
                message: 'Se ha cambiado el estado del registro',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(66, 245, 158)'
            });
        })
    </script>





@stop
