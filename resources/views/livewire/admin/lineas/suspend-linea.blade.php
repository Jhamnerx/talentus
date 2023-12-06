<x-form.modal.card title="SUSPENDER LINEAS" wire:model.live="openModal" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 mx-auto">
            <ul class="list-disc">
                @if ($items)
                    @foreach ($items as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                @endif

            </ul>
        </div>
        <div class="col-span-12 md:col-span-6 gap-2">
            {{ $fecha_suspencion }}
            <x-form.datetime-picker without-time display-format="DD-MM-YYYY" :min="now()->subDays(7)"
                label="Fecha de Suspención:" placeholder="Selecciona la fecha" parse-format="YYYY-MM-DD"
                wire:model.defer="fecha_suspencion" />

        </div>
        <div class="col-span-12 md:col-span-6 gap-2">
            {{ $date_to_suspend }}
            <x-form.datetime-picker without-time display-format="DD-MM-YYYY" :min="now()->subDays(7)"
                label="Fecha de Reactivación:" placeholder="Selecciona la fecha" parse-format="YYYY-MM-DD"
                wire:model.defer="date_to_suspend" />

        </div>

        <div class="col-span-12 gap-2">
            <div class="m-2 w-full mt-2">
                <label for="baja">Baja definitiva:</label>
                <div class="flex items-center">
                    <div class="form-switch">
                        <input wire:model.live="baja" type="checkbox" id="baja-1" class="sr-only baja" />
                        <label class="bg-slate-400" for="baja-1">
                            <span class="bg-white shadow-sm" aria-hidden="true"></span>
                            <span class="sr-only">baja switch</span>
                        </label>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
    <script></script>
@endpush
