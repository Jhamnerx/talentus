<div class="grid grid-cols-12 gap-6 w-1/2">
    @if ($tipo_solicitud == "servicio")

    <div class="col-span-12">
        <label class="block text-sm font-medium mb-1" for="numero">Ingresa tu Nombre o razon social: <span
                class="text-rose-500">*</span></label>

        <input placeholder="Talentus Technology" wire:model.live="nombre" required type="text" class="form-input w-full">

        @error('nombre')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="col-span-12">
        <label class="block text-sm font-medium mb-1" for="email">Ingresa tu email: <span
                class="text-rose-500">*</span></label>

        <input placeholder="soporte@talentustechnology.com" wire:model.live="email" wire:model.live="email" required name="fecha"
            type="text" class="form-input w-full">

        @error('email')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>

    <div class="col-span-12">
        <label class="block text-sm font-medium mb-1" for="email">Servicio a solicitar: <span
                class="text-rose-500">*</span></label>

        <select class="form-select w-full" wire:model.live="servicio_solicitado">
            <option value="SERVICIO DE MONITOREO">SERVICIO DE MONITOREO</option>
            <option value="COMPRA EQUIPO GPS">COMPRA EQUIPO GPS</option>
            <option value="OTRO">OTRO (indique en el detalle)</option>
        </select>

        @error('servicio_solicitado')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    <div class="col-span-12">
        <label class="block text-sm font-medium mb-1" for="servicio_solicitad">Cuentanos un poco más: <span
                class="text-rose-500">*</span></label>

        <textarea class="form-textarea w-full" rows="5" wire:model.live="detalle"></textarea>


        @error('detalle')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    @else
    <div class="col-span-12">
        <label class="block text-sm font-medium mb-1" for="numero">Ingresa tu Nombre o razon social: <span
                class="text-rose-500">*</span></label>

        <input placeholder="Talentus Technology" wire:model.live="nombre" required type="text" class="form-input w-full">

        @error('nombre')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="col-span-12 md:col-span-6">
        <label class="block text-sm font-medium mb-1" for="email_envio">Ingresa tu email:</label>

        <input placeholder="soporte@talentustechnology.com" wire:model.live="email_envio" required name="fecha" type="text"
            class="form-input w-full">
        <div class="text-xs mt-1">Este correo se usara para enviar el reporte!</div>
        @error('email_envio')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    <div class="col-span-12 md:col-span-6">
        <label class="block text-sm font-medium mb-1" for="telefono_envio">Ingresa tu Numero:</label>

        <input placeholder="+51 987654321" wire:model.live="telefono_envio" required name="fecha" type="text"
            class="form-input w-full">
        <div class="text-xs mt-1">Este número se usara para enviar el reporte!</div>

        @error('telefono_envio')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    <div class="col-span-12 md:col-span-6">
        <label class="block text-sm font-medium mb-1" for="fecha_inicial">Fecha Inicial: <span
                class="text-rose-500">*</span></label>

        <input placeholder="2022-12-12" wire:model.live="fecha_inicial" required name="fecha" type="text"
            class="form-input w-full fecha">
        <div class="text-xs mt-1">Ingresa la fecha inicial del reporte!</div>

        @error('fecha_inicial')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    <div class="col-span-12 md:col-span-6">
        <label class="block text-sm font-medium mb-1" for="fecha_final">Fecha Final: <span
                class="text-rose-500">*</span></label>

        <input placeholder="2022-12-12" wire:model.live="fecha_final" required name="fecha" type="text"
            class="form-input w-full fecha">
        <div class="text-xs mt-1">Ingresa la fecha final del reporte!</div>

        @error('fecha_final')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    <div class="col-span-12 md:col-span-6">
        <label class="block text-sm font-medium mb-1" for="placa">Placa Vehículo: <span
                class="text-rose-500">*</span></label>
        <input placeholder="ABC-123" wire:model.live="placa" required name="placa" type="text"
            class="form-input w-full placa">
        <div class="text-xs mt-1">Por favor ingresa la placa de la unidad!</div>
        @error('placa')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror
    </div>
    <div class="col-span-12">
        <label class="block text-sm font-medium mb-1" for="servicio_solicitado">Ingresa alguna indicación: </label>

        <textarea class="form-textarea w-full" rows="5" wire:model.live="detalle"></textarea>


        @error('detalle')
        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
            {{ $message }}
        </p>
        @enderror

    </div>
    @endif
    <div class="mb-1 text-center w-full" wire:loading wire:target="guardarSolicitud">

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
    <div class="col-span-12">
        <div class="px-5 py-4 border-t border-slate-200">
            <div class="flex flex-wrap justify-end space-x-2">

                <button wire:click.prevent="guardarSolicitud()" wire:loading.attr="disabled"
                    class="btn-sm bg-indigo-500 disabled:bg-indigo-300 hover:bg-indigo-600 text-white">Enviar
                    Solicitud</button>
            </div>
        </div>
    </div>
</div>
