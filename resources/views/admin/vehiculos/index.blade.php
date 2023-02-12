@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.vehiculos.vehiculos-index')
    @livewire('admin.vehiculos.save-vehiculo')
    @livewire('admin.vehiculos.delete')
    @livewire('admin.vehiculos.import')
    @livewire('admin.vehiculos.suspend')
    @livewire('admin.vehiculos.mantenimiento.save')


@stop

@section('js')

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
        window.addEventListener('change-status', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: event.detail.status,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>

    <script>
        window.addEventListener('vehiculo-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Vehiculo Eliminado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
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

    <script>
        window.addEventListener('vehiculos-import', event => {
            iziToast.success({
                position: 'topRight',
                title: 'IMPORTE COMPLETO',
                message: 'se importo los vehiculos correctamente',
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
