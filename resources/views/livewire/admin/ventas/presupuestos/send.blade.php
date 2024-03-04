<!-- Send Feedback -->
<div class="m-1.5">
    <!-- Start -->
    <div x-data="{ modalOpenSend: @entangle('modalOpenSend').live }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpenSend"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>
        <!-- Modal dialog -->
        <div id="feedback-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalOpenSend"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>
            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                @click.outside="modalOpenSend = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">
                            ENVIAR COTIZACIÓN
                        </div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpenSend = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-5 py-4">
                    <div class="text-sm">
                        <div class="font-medium text-slate-800 mb-3">
                            Enviar cotización a cliente 🙌</div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="from">De: <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full px-2 py-1 disabled:bg-slate-100" readonly
                                wire:model.live="from" type="email" required disabled />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="to">Para: <span
                                    class="text-rose-500">*</span></label>
                            <input id="to" class="form-input w-full px-2 py-1 disabled:bg-slate-100"
                                wire:model.live="to" type="email" required disabled />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="asunto">Asunto: <span
                                    class="text-rose-500">*</span></label>
                            <input id="asunto" class="form-input w-full px-2 py-1" wire:model.live="asunto"
                                type="text" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="body">Mensaje:
                            </label>
                            <textarea id="body" class="form-textarea w-full px-2 py-1" wire:model.live="body" rows="5" required></textarea>
                        </div>

                        {{-- <div class="mb-1 text-center" wire:loading wire:target="sendPresupuesto"> --}}
                        <div class="mb-1 text-center w-full" wire:loading wire:target="sendPresupuesto">

                            <div class='loader'>
                                <div class='loader--dot'></div>
                                <div class='loader--dot'></div>
                                <div class='loader--dot'></div>
                                <div class='loader--dot'></div>
                                <div class='loader--dot'></div>
                                <div class='loader--dot'></div>
                                <div class='loader--text'></div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200" x-data="{ estado: @entangle('disabled').live }">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            @click="modalOpenSend = false" wire:click="closeModal">Cancelar</button>


                        <x-form.button wire:click="sendPresupuesto" x-bind:disabled="estado"
                            spinner="sendPresupuesto" loading-delay="short" primary label="Enviar" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->
</div>
