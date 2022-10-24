<div class="col-span-full xl:col-span-12 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">ALMACEN DISPOSITIVOS</h2>
    </header>
    <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                    <tr>
                        <th class="p-2">
                            <div class="font-semibold text-left">Modelo</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Total</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Stock</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Vendidos</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Porcentaje Vendidos</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm font-medium divide-y divide-slate-100">
                    <!-- Row -->
                    @foreach ($modelos as $modelo)
                        <tr>
                            <td class="p-2">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3">

                                        @if ($modelo->image)
                                            <img class="ml-1" src="{{ Storage::url($modelo->image->url) }}.webp"
                                                width="40" height="40" alt="{{ $modelo->modelo }}" />
                                        @else
                                        @endif

                                    </div>
                                    <div class="text-slate-800">{{ $modelo->marca }} {{ $modelo->modelo }}</div>
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">{{ $modelo->dispositivo()->empresa()->get()->count() }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-center text-emerald-500">
                                    {{ $modelo->dispositivo()->stock()->empresa()->get()->count() }}
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">
                                    {{ $modelo->dispositivo()->vendido()->empresa()->get()->count() }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-center text-sky-500">
                                    {{ $modelo->porcentaje }}%
                                    {{-- {{ ($modelo->dispositivo()->vendido()->empresa()->get()->count() /$modelo->dispositivo()->empresa()->get()->count()) *100 }} --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</div>
