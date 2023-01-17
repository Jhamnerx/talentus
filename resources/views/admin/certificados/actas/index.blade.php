@extends('layouts.admin')
@section('ruta', 'certificados-actas')
@section('contenido')

<!-- Table -->
@livewire('admin.certificados.actas.actas-index')

@stop

@push('modals')
@livewire('admin.certificados.actas.save')
@livewire('admin.certificados.actas.edit')
@livewire('admin.certificados.actas.send')
@livewire('admin.certificados.actas.delete')
@livewire('admin.certificados.actas.import')
@endpush

@section('js')

<script>
    // INICIALIZAR LOS INPUTS DE FECHA
        $(document).ready(function() {

            flatpickr('.inputDateActaInicio', {
                mode: 'single',
                defaultDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
            flatpickr('.inputDateActaFinal', {
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
    window.addEventListener('acta-edit', event => {
            iziToast.success({
                position: 'topRight',
                title: 'ACTUALIZADO',
                message: 'El Acta N° ' + event.detail.acta + ' Fue Actualizado',
            });

        })
</script>
<script>
    window.addEventListener('acta-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Acta Eliminada',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
</script>
<script>
    window.addEventListener('acta-save', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El Acta de ' + event.detail.vehiculo + ' Fue Creado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })


                $('.formSaveActa .vehiculos_id').val(null).trigger('change');
                $('.formSaveActa .ciudades').val(null).trigger('change');
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
