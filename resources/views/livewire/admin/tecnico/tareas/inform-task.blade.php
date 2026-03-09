<div>
    <x-form.modal.card title="CREAR INFORME {{ $tarea ? $tarea->token : '' }}" max-width="4xl" wire:model.live="openModal">
        <div class="w-full" wire:ignore>
            <div class="document-editor">
                <div class="document-editor__toolbar"></div>
                <div class="document-editor__editable-container">
                    <div class="document-editor__editable">
                        {{ $tarea ? $tarea->informe : '' }}
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="closeModal" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

@push('scripts')
    <script>
        let ck;

        $(document).ready(function() {
            //console.log(DecoupledDocumentEditor);
            DecoupledDocumentEditor
                .create(document.querySelector('.document-editor__editable'))
                .then(editor => {

                    ck = editor;
                    const toolbarContainer = document.querySelector('.document-editor__toolbar');

                    toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                    window.editor = editor;

                    editor.model.document.on('change:data', () => {
                        @this.set('message', editor.getData());
                    })

                })
                .catch(error => {
                    console.error(error);
                });

        })
    </script>


    <script>
        // window.addEventListener('set-data', event => {
        //     console.log(event.detail);
        //     ck.setData(event.detail[0].data);
        // })

        Livewire.on('set-data', (event) => {

            ck.setData(event.data);

        });
    </script>


    <script>
        window.addEventListener('save-inform', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'INFORME TAREA CREADA',
                timeout: 2500,
                message: 'Se ha creado el informa de la tarea <b>' + event.detail.token + '</b>',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
            });
        })
    </script>
@endpush
