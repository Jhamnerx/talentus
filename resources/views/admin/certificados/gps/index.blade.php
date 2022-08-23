@extends('layouts.admin')
@section('ruta', 'certificados-gps')
@section('contenido')

    <!-- Table -->
    @livewire('admin.certificados.gps.certificados-gps-index')

@stop

@push('modals')
    @livewire('admin.certificados.gps.save')
    @livewire('admin.certificados.gps.edit')
@endpush

@section('js')
    <script>
        // INICIALIZAR LOS INPUTS DE FECHA
        $(document).ready(function() {

            flatpickr('.inputDateCertificadoFinal', {
                mode: 'single',
                defaultDate: [new Date().setDate(new Date().getDate() + 30), new Date()],
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        })
    </script>
    <script>
        window.addEventListener('certificado-edit', event => {
            iziToast.success({
                position: 'topRight',
                title: 'ACTUALIZADO',
                message: 'El Certificado N° ' + event.detail.certificado + ' Fue Actualizado',
            });

        })
    </script>

    <script>
        window.addEventListener('certificado-save', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El certificado de ' + event.detail.vehiculo + ' Fue Creado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
                $('.formCertificadoSave .vehiculos_id').val(null).trigger('change');
                $('.formCertificadoSave .ciudades').val(null).trigger('change');
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
