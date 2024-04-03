<x-form.modal.card title="CONSULTA CDR COMPROBANTE" wire:model.live="openModal" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-4">

            <x-form.select label="Tipo Comprobante" placeholder="Selecciona" :options="[
                ['name' => 'FACTURA', 'id' => '01'],
                ['name' => 'NOTA DE CRÉDITO', 'id' => '07'],
                ['name' => 'NOTA DE DEBITO', 'id' => '08'],
            ]" option-label="name"
                option-value="id" wire:model.live="tipo" />
        </div>

        <div class="col-span-12 sm:col-span-4">

            <x-form.input label="Serie:" wire:model.live="serie" id="serie" type="text" />

        </div>

        <div class="col-span-12 sm:col-span-4">

            <x-form.input label="Correlativo:" wire:model.live="correlativo" id="correlativo" type="text" />

        </div>
        {{-- @if ($error)
            <div class="col-span-12">
                <x-form.badge flat negative label="{{ $error }}" />
            </div>
        @endif --}}

        <div class="col-span-12">
            @if (isset($resultado))
                <x-form.card title="Resultado">

                    @if ($resultado['is_success'])
                        <strong>Codigo: </strong> {{ $resultado['codigo'] }} <br>
                        <strong>Mensaje: </strong> {{ $resultado['mensaje'] }} <br>

                        @if (!is_null($resultado['cdr']))
                            <strong>Estado Comprobante: </strong> {{ $resultado['cdr_status'] }}


                            @if (!empty($resultado['cdr_notes']))
                                <br>
                                <strong>Observaciones: </strong>
                                <ul>
                                    @foreach ($resultado['cdr_notes'] as $note)
                                        <li>{{ $note }}</li>
                                    @endforeach

                                    @if (!is_null($filename))
                                        <br>
                                        <strong>CDR: </strong><br>
                                        <a href="{{ Storage::disk('facturacion')->get($filename) }}"><i
                                                class="fa fa-file-archive"></i>&nbsp;<?= $filename ?></a>
                                    @endif

                                </ul>
                            @endif
                        @endif
                    @else
                        <div role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                {{ $resultado['codigo'] }}
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                <p>{{ $resultado['mensaje'] }}.</p>
                                <p>{{ $resultado['error_mensaje'] }}.</p>
                            </div>
                        </div>
                    @endif

                </x-form.card>
            @endif
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click.prevent='closeModal' />
                <x-form.button primary spinner="consultar" label="CONSULTAR" wire:click.prevent='consultar' />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
