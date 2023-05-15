                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 py-5">
                            <form action="#" method="post">
                                @csrf
                                <div class="grid grid-cols-12 gap-6">


                                    <div class="col-span-12 sm:col-span-6">
                                        <label class="block text-sm font-medium mb-1" for="emprsa">Empresa:</label>
                                        <input wire:model='empresa' type="text" class="form-input w-full"
                                            placeholder="Talentus Technology EIRL">
                                        @error('empresa')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label class="block text-sm font-medium mb-1" for="marca">Cargo:</label>
                                        <input type="text" wire:model="cargo" class="form-input w-full"
                                            placeholder="Gerente">

                                        @error('cargo')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-span-12">
                                        <label class="block text-sm font-medium mb-1" for="marca">Nombre y
                                            Apellido:</label>
                                        <input wire:model="name" type="text" class="form-input w-full"
                                            placeholder="e.g John">

                                        @error('name')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label class="block text-sm font-medium mb-1" for="telefono">Telefono:</label>
                                        <input wire:model="telefono" type="tel" class="form-input w-full"
                                            placeholder="987654321">
                                        @error('telefono')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-span-12 sm:col-span-6">
                                        <label class="block text-sm font-medium mb-1" for="birthday">Fecha de
                                            nacimiento:</label>
                                        <input wire:model="birthday" type="text" x-mask="99/99/9999"
                                            placeholder="mm/dd/yyyyy" class="form-input w-full">
                                        @error('birthday')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-span-12">
                                        <label class="block text-sm font-medium mb-1" for="q1">
                                            ¿Qué tan satisfecho se siente con la atención brindada a sus consultas y
                                            requerimientos?
                                        </label>

                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q1" value="Muy satisfecho" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">1. Muy satisfecho</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q1" value="Satisfecho" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">2. Satisfecho</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q1" value="Poco satisfecho" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">3. Poco satisfecho</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q1" value="Nada satisfecho" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">4. Nada satisfecho</span>
                                            </label>

                                        </div>
                                        @error('q1')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-span-12">
                                        <label class="block text-sm font-medium mb-1" for="q2">
                                            ¿En qué aspecto cree Ud., que debería mejorar nuestro servicio?
                                        </label>

                                        <div>

                                            <textarea wire:model="q2" class="form-textarea w-full" cols="30" rows="5"></textarea>
                                        </div>
                                        @error('q2')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-span-12">
                                        <label class="block text-sm font-medium mb-1" for="q3">
                                            ¿Tiene algún inconveniente en el manejo de nuestras plataformas de
                                            monitoreo? Si
                                            su respuesta es Si, por favor especifique:
                                        </label>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q3" value="SI" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">SI</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q3" value="NO" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">NO</span>
                                            </label>

                                        </div>
                                        @error('q3')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        <div>

                                            <textarea wire:model="q3_res" class="form-textarea w-full" cols="30" rows="5"></textarea>
                                        </div>
                                        @error('q3_res')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-12">
                                        <label class="block text-sm font-medium mb-1" for="q1">
                                            ¿Tiene alguna solicitud pendiente que no se haya atendido? Marque la
                                            alternativa
                                            o alternativas que considere.
                                        </label>

                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q4" value="FACTURACION" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">1. Facturación</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q4" value="REPORTES" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">2. Reportes</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q4" value="SERVICIO TECNICO" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">3. Servicio técnico</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q4" value="TODAS" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">4. Todas las anteriores</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q4" value="NINGUA" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">5. Ninguna de las anteriores</span>
                                            </label>

                                        </div>
                                        @error('q4')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-12">
                                        <label class="block text-sm font-medium mb-1" for="q1">
                                            ¿Recomendaría nuestro servicio a un familiar o amigo?
                                        </label>

                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q5" value="SI" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2">SI</span>
                                            </label>

                                        </div>
                                        <div class="m-3">

                                            <label class="flex items-center">
                                                <input wire:model="q5" value="NO" type="radio"
                                                    class="form-radio" />
                                                <span class="text-sm ml-2 pr-3">NO, Por qué? </span>

                                                <input wire:model="q5_why"type="text"
                                                    class="form-input w-1/2 pl-2">
                                            </label>

                                        </div>
                                        @error('q5')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        @error('q5_why')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex left-2 py-3 justify-end">

                                    <button type="button" wire:click.prevent="sendForm()"
                                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">Enviar</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
