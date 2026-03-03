<x-form.modal.card title="REGISTRAR PAGO" max-width="2xl" wire:model.live="modalPayment" align="center">

    <form autocomplete="off" autocapitalize="true">

        <div class="px-8 py-5 bg-white dark:bg-gray-800 sm:p-6">

            <div class="grid grid-cols-12 gap-6">

                {{-- MODO: CREAR vs ASOCIAR --}}
                <div class="col-span-12 mb-4">
                    <div class="flex items-center justify-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Modo:</label>
                        <div class="flex gap-2">
                            <x-form.button :primary="$paymentMode === 'create'" :flat="$paymentMode !== 'create'" label="Crear Nuevo Pago"
                                wire:click="$set('paymentMode', 'create')" sm />
                            <x-form.button :secondary="$paymentMode === 'associate'" :flat="$paymentMode !== 'associate'" label="Asociar Pago Existente"
                                wire:click="$set('paymentMode', 'associate')" sm />
                        </div>
                    </div>
                </div>

                @if ($paymentMode === 'associate')
                    {{-- MODO ASOCIAR: Solo selector de pagos existentes --}}
                    <div class="col-span-12">
                        <x-form.select wire:model.defer="existing_payment_id" label="Selecciona el Pago a Asociar"
                            placeholder="Busca un pago existente...">
                            @if (count($existingPayments) > 0)
                                @foreach ($existingPayments as $payment)
                                    <x-select.option label="{{ $payment['label'] }}" value="{{ $payment['id'] }}" />
                                @endforeach
                            @else
                                <x-select.option label="No hay pagos disponibles para asociar" value=""
                                    disabled />
                            @endif
                        </x-form.select>

                        @if (count($existingPayments) === 0)
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                ℹ️ No hay pagos a CRÉDITO disponibles sin cobro asociado para este cliente.
                            </p>
                        @endif
                    </div>
                @else
                    {{-- MODO CREAR: Formulario completo normal --}}

                    {{-- TIPO PAGO --}}

                    <div class="col-span-12 sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                            for="numero">Número:
                            <span class="text-rose-500">*</span></label>
                        <div class="relative" lang="es">

                            <input type="text"
                                class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                wire:model.live='numero' disabled>
                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="w-4 h-4 fill-current text-gray-500 dark:text-gray-400 shrink-0 ml-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g fill="none" class="nc-icon-wrapper">
                                        <path
                                            d="M2 11h14v2H2v-2zm16 6h2v.5h-1v1h1v.5h-2v1h3v-4h-3v1zm0-6h1.8L18 13.1v.9h3v-1h-1.8l1.8-2.1V10h-3v1zm2-3V4h-2v1h1v3h1zM2 17h14v2H2v-2zM2 5h14v2H2V5z"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        @error('tipo_pago')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                            for="tipo_pago">Tipo
                            Pago: <span class="text-rose-500">*</span></label>
                        <div class="relative" lang="es">

                            <select id="tipo_pago" name="tipo_pago" wire:model.live="tipo_pago"
                                class="tipo_pago w-full form-input pl-9 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                                <option selected value="FACTURA">FACTURA</option>
                                <option value="RECIBO">RECIBO</option>

                            </select>

                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="w-4 h-4 fill-current text-gray-500 dark:text-gray-400 shrink-0 ml-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <g class="nc-icon-wrapper">
                                        <path
                                            d="M40,47a1,1,0,0,1-.53-.152L24,37.179,8.53,46.848A1,1,0,0,1,7,46V6a5,5,0,0,1,5-5H36a5,5,0,0,1,5,5V46a1,1,0,0,1-1,1Z"
                                            fill="#ffd764"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        @error('tipo_pago')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- DOCUMENTO --}}

                    <div class="col-span-12 sm:col-span-6">

                        <x-form.select wire:model.live="paymentable_id" label="{{ $titulo_documento }}"
                            placeholder="Selecciona">

                            @foreach ($documentos as $documento)
                                <x-select.option label="{{ $documento['text'] }}" value="{{ $documento['id'] }}" />
                            @endforeach

                        </x-form.select>
                    </div>

                    {{-- metodo de pago --}}
                    <div class="col-span-12 sm:col-span-6">

                        <x-form.select wire:model.live="payment_method_id" label="Metodo de pago"
                            placeholder="Selecciona">

                            @foreach ($paymentsMethods as $metodo)
                                <x-select.option label="{{ $metodo['description'] }}" value="{{ $metodo['id'] }}" />
                            @endforeach

                        </x-form.select>
                    </div>

                    {{-- ✅ Destino del Pago (Caja o Cuenta Bancaria) - Patrón PaymentDestinationHelper --}}
                    <div class="col-span-12 sm:col-span-6">
                        @if ($this->paymentDestinations && $this->paymentDestinations->isNotEmpty())
                            <x-form.select label="Destino del Pago" wire:model.defer="payment_destination_id"
                                :options="$this->paymentDestinations->toArray()" option-label="description" option-value="id"
                                placeholder="Seleccione destino" />
                            <p class="text-xs text-gray-500 mt-1">
                                Seleccione si el dinero va a Caja o a una Cuenta Bancaria específica
                            </p>
                        @else
                            <x-form.input label="Destino del Pago" value="Sin destinos disponibles" readonly disabled />
                            <p class="text-xs text-red-500 mt-1">
                                ⚠️ No hay cajas abiertas ni cuentas bancarias activas
                            </p>
                        @endif
                    </div>

                    {{-- Cuenta Bancaria (solo si es depósito) --}}
                    @if ($showBankAccountSelector)
                        <div class="col-span-12 sm:col-span-6">
                            <x-form.select label="Cuenta Bancaria" wire:model.defer="bank_account_id"
                                placeholder="Seleccione una cuenta">
                                @foreach ($bankAccounts as $account)
                                    <x-select.option
                                        label="{{ $account->bank->name }} - {{ $account->number }} ({{ $account->currency_type_id }})"
                                        value="{{ $account->id }}" />
                                @endforeach
                            </x-form.select>
                        </div>
                    @endif

                    {{-- monto --}}
                    <div class="col-span-12 sm:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                            for="monto">Monto:</label>

                        <div class="relative">

                            <input wire:model.live="monto" type="text"
                                class="form-input w-full pl-12 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                placeholder="$199.00">
                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium px-3">S/</span>
                            </div>
                        </div>
                        @error('monto')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-span-12 sm:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                            for="numeronumero_operacion">Numero de
                            operación:</label>

                        <div class="relative">

                            <input wire:model.live="numero_operacion" type="text"
                                class="form-input w-full pl-12 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                placeholder="45474001">

                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="w-4 h-4 fill-current text-gray-500 dark:text-gray-400 shrink-0 ml-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <g stroke-linecap="square" stroke-miterlimit="10" fill="none"
                                        stroke="currentColor" stroke-linejoin="miter" class="nc-icon-wrapper">
                                        <line x1="10" y1="33" x2="24" y2="33">
                                        </line>
                                        <line x1="32" y1="33" x2="38" y2="33">
                                        </line>
                                        <path
                                            d="M43,41H5a2.946,2.946,0,0,1-3-3V12A2.946,2.946,0,0,1,5,9H43a2.946,2.946,0,0,1,3,3V38A2.946,2.946,0,0,1,43,41Z">
                                        </path>
                                        <path d="M31.189,23.392a3.933,3.933,0,0,0,0-4.784"></path>
                                        <path d="M35.991,26.993a9.943,9.943,0,0,0,0-11.986"></path>
                                        <circle cx="26" cy="21" r="2" stroke="none"
                                            fill="currentColor">
                                        </circle>
                                        <rect x="10" y="17" width="7" height="6">
                                        </rect>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        @error('numero_operacion')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-span-12">
                        @error('divisa')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- nota --}}
                    <div class="col-span-12 sm:col-span-12 mb-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="nota">
                            Nota:
                        </label>

                        <div class="relative">
                            <textarea class="w-full form-input pl-9 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                wire:model.live="nota" name="nota" id="" rows="4" placeholder="Ingresa una nota">
                                    </textarea>

                            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                <svg class="w-4 h-4 fill-current text-gray-500 dark:text-gray-400 shrink-0 ml-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <g class="nc-icon-wrapper">
                                        <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                            fill="#e3e3e3"></path>
                                        <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                        </path>
                                        <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                        </path>
                                        <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                        </path>
                                        <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                        </path>
                                        <path
                                            d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                            fill="#3aace9"></path>
                                        <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z"
                                            fill="#aeaeae"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        @error('documentos')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                @endif {{-- Fin modo CREAR --}}

            </div>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@section('js')
    <script>
        window.addEventListener('savePayment', event => {
            Swal.fire({
                icon: 'success',
                title: 'Guardado',
                text: 'se ha creado ' + event.detail.payment.numero,
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            })

        })
    </script>
@endsection
