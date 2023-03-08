<div>
    <div x-data="{ modalInforme: @entangle('openModal') }">

        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalInforme"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalInforme"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-3/5 2xl:w-3/5 max-h-full"
                @keydown.escape.window="modalInforme = false">

                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">CREAR INFORME {{$tarea ? $tarea->token : ''}}</div>
                        <button wire:click.prevent="closeModal" class="text-slate-400 hover:text-slate-500">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-8 py-5 bg-white sm:p-6 w-full" wire:ignore>

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable">
                                {{$tarea ? $tarea->informe : ''}}
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="px-5 py-4 border-t border-slate-200">
                        <div class="flex flex-wrap justify-end space-x-2">
                            <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                wire:click.prevent="closeModal">Cerrar</button>
                            <button wire:click.prevent="save"
                                class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                        </div>
                    </div>

                </div>

            </div>


        </div>

    </div>
</div>

@push('scripts')
<script>
    let ck;

    $(document).ready(function() {
    DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ) )
                .then( editor => {

                    ck = editor;
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                    window.editor = editor;

                    editor.model.document.on('change:data', () => {
                        @this.set('message', editor.getData());
                    })

                })
            .catch( error => {
                    console.error( error );
        });

    })
</script>


<script>
    window.addEventListener('set-data', event => {
       //console.log(event.detail.data);

        ck.setData(event.detail.data);

    })

</script>


<script>
    window.addEventListener('save-inform', event => {
        iziToast.show({
            theme: 'dark',
            icon: 'far fa-envelope-open',
            title: 'INFORME TAREA CREADA',
            timeout: 2500,
            message: 'Se ha creado el informa de la tarea <b>'+event.detail.token+'</b>',
            position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: 'rgb(5, 44, 82)'
        });
    })

</script>
@endpush
