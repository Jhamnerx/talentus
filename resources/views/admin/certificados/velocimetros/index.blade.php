@extends('layouts.admin')
@section('ruta', 'certificados-velocimetro')
@section('contenido')

    <!-- Table -->

    @livewire('admin.certificados.velocimetros.velocimetros-index')

@stop

@push('modals')
    @livewire('admin.certificados.velocimetros.save')
    @livewire('admin.certificados.velocimetros.edit')
    @livewire('admin.certificados.velocimetros.send')
    @livewire('admin.certificados.velocimetros.delete')
    @livewire('admin.vehiculos.save-quick')
@endpush


@section('js')
    <script>
        window.addEventListener('certificado-velocimetro-edit', event => {
            iziToast.success({
                position: 'topRight',
                title: 'ACTUALIZADO',
                message: 'El Certificado N° ' + event.detail.certificado + ' Fue Actualizado',
            });

        })
    </script>

    <script>
        window.addEventListener('certificado-velocimetro-save', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El certificado de ' + event.detail.vehiculo + ' Fue Creado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
            $('.formVelocimetroSave .vehiculos_id').val(null).trigger('change');
            $('.formVelocimetroSave .ciudades').val(null).trigger('change');
        })
    </script>
    <script>
        window.addEventListener('certificado-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Certificado Eliminado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>

    <script>
        window.addEventListener('save-quick-vehiculo', event => {
            iziToast.success({
                position: 'topRight',
                title: 'VEHICULO GUARDO',
                message: 'Se creo el vehiculo' + event.detail.placa + '!',
            });
            $('.clientes_id').val(null).trigger('change');

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
