<div>

    {{-- <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-12 gap-2 mb-1 relative">

            <div class="col-span-1 sm:col-span-1">
                <span>1</span>
            </div>
            <div class="col-span-4 sm:col-span-3">
                {!! Form::hidden('empresa_id', session('empresa'), ['wire:model.lazy' => 'empresa_id', 'x-data' => 'form()']) !!}
                {!! Form::label('sim_card_n', 'Sim Card:', ['class' => 'block text-sm font-medium mb-1']) !!}

                <input type="tel" class="form-input w-full" placeholder="Escribe el sim card" wire:model="sim_card_n.0"
                    maxlength="20">

                @error('sim_card_n.0')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-4 sm:col-span-3">
                {!! Form::label('operador', 'Operador:', ['class' => 'block text-sm font-medium mb-1']) !!}
                <input type="text"
                    class="form-input w-full valid:border-emerald-300 required:border-rose-300 invalid:border-rose-300 peer"
                    wire:model="operador.0" placeholder="Escribe el operador" required>



                @error('operador.0')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="col-span-2 sm:col-span-2">
                <a wire:click.debounce.250ms="add({{ $i }})"
                    class="btn bg-indigo-500 hover:cursor-pointer hover:bg-indigo-600 text-white float-right">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0 text-white" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>

                </a>

            </div>

        </div>

    </div> --}}

    <div class="flex flex-auto gap-2 mx-4 py-2">
        <div></div>
        <div class="w-full">
            <a wire:click.prevent="addItem"
                class="btn bg-indigo-500 hover:cursor-pointer hover:bg-indigo-600 text-white float-right">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0 text-white" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>

            </a>

        </div>
    </div>



    @foreach ($items->all() as $clave => $item)
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-12 gap-2 relative">

                <div class="col-span-1 sm:col-span-1 flex items-center justify-center">
                    <span>{{ $clave + 1 }}</span>
                </div>
                <div class="col-span-4 sm:col-span-3">
                    {!! Form::label('sim_card', 'Sim Card:', ['class' => 'block text-sm font-medium mb-1']) !!}
                    <input type="tel" class="form-input w-full" placeholder="Escribe el sim card"
                        wire:model="items.{{ $clave }}.sim_card" maxlength="20">


                    @if ($errors->has('items.' . $clave . '.sim_card'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('items.' . $clave . '.sim_card') }}
                        </p>
                    @endif
                </div>

                <div class="col-span-4 sm:col-span-3">
                    {!! Form::label('operador', 'Operador:', ['class' => 'block text-sm font-medium mb-1']) !!}
                    <input type="text" class="form-input w-full" wire:model="items.{{ $clave }}.operador"
                        placeholder="Escribe el operador" required>

                    @if ($errors->has('items.' . $clave . '.operador'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('items.' . $clave . '.operador') }}
                        </p>
                    @endif

                </div>
                <div class="col-span-2 sm:col-span-2 flex items-center justify-center">
                    <button type="button" wire:click.prevent="eliminarItem('{{ $clave }}')"
                        class="text-rose-500 hover:text-rose-600 rounded-full">
                        <span class="sr-only">Eliminar</span>
                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                            <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                            <path
                                d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                        </svg>
                    </button>


                </div>

            </div>

        </div>
    @endforeach

    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

        <button wire:click.prevent="store()"
            class="btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                                                focus:ring-emerald-600 text-white">GUARDAR</button>
    </div>


</div>
