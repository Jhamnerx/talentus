@extends('layouts.admin')
@section('ruta', 'vehiculos-mantenimiento')
@section('contenido')

    <!-- Tabla -->
    @livewire('admin.vehiculos.mantenimiento.index')
    @livewire('admin.vehiculos.mantenimiento.save')
    @livewire('admin.vehiculos.mantenimiento.create-task')

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
