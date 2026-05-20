<div>

    {{-- ══════════════════════════════════════════════════════════════════════════
     HUB — Seleccione una opción
     ══════════════════════════════════════════════════════════════════════════ --}}
    <x-form.modal.card title="Panel M2M · SIM" align="center" wire:model.live="modalHub" width="2xl" persistent>

        <div class="text-center text-xs text-slate-500 -mt-2 mb-4">
            ICC: <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $icc }}</span>
        </div>

        {{-- Overlay spinner mientras procesa cualquier acción del hub --}}
        <div wire:loading wire:target="irDetalles,irDiagnostico,irEditar,irSms"
            class="flex flex-col items-center justify-center py-10 gap-3">
            <svg class="animate-spin w-10 h-10 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
            </svg>
            <p class="text-sm text-slate-500">Cargando...</p>
        </div>

        <div wire:loading.remove wire:target="irDetalles,irDiagnostico,irEditar,irSms"
            class="grid grid-cols-2 gap-3 py-2">

            {{-- Ver detalles --}}
            <button wire:click="irDetalles"
                class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700 transition text-left group">
                <span
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-sky-100 dark:bg-sky-900 text-sky-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0121 9.414V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-200 group-hover:text-orange-600">Ver
                    detalles</span>
            </button>

            {{-- Diagnosticar --}}
            <button wire:click="irDiagnostico"
                class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700 transition text-left group">
                <span
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <span
                    class="text-sm font-medium text-slate-700 dark:text-slate-200 group-hover:text-orange-600">Diagnosticar</span>
            </button>

            {{-- Editar datos --}}
            <button wire:click="irEditar"
                class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700 transition text-left group">
                <span
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-200 group-hover:text-orange-600">Editar
                    datos</span>
            </button>

            {{-- Enviar SMS --}}
            <button wire:click="irSms"
                class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700 transition text-left group">
                <span
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-violet-100 dark:bg-violet-900 text-violet-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-200 group-hover:text-orange-600">Enviar
                    SMS</span>
            </button>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-form.button flat label="Cerrar" wire:click="$set('modalHub', false)" />
            </div>
        </x-slot>
    </x-form.modal.card>


    {{-- ══════════════════════════════════════════════════════════════════════════
     VER DETALLES — Con tabs
     ══════════════════════════════════════════════════════════════════════════ --}}
    <x-form.modal.card title="Detalles SIM" align="center" wire:model.live="modalDetalles" width="2xl" persistent>

        @if ($cargandoDet)
            <div class="flex justify-center items-center py-12">
                <svg class="animate-spin w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                </svg>
            </div>
        @elseif ($errorDet)
            <div class="flex flex-col items-center py-10 text-rose-500 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm">{{ $errorDet }}</p>
            </div>
        @else
            {{-- TABS --}}
            <div x-data="{ tab: $wire.entangle('tab') }">
                <div class="flex border-b border-slate-200 dark:border-slate-700 gap-1 mb-5 overflow-x-auto">
                    @php
                        $tabs = [
                            'identificacion' => ['label' => 'IDENTIFICACIÓN SIM'],
                            'dispositivo' => ['label' => 'DISPOSITIVO'],
                            'conexion' => ['label' => 'CONEXIÓN'],
                            'consumo' => ['label' => 'CONSUMO'],
                            'ubicacion' => ['label' => 'UBICACIÓN'],
                        ];
                    @endphp
                    @foreach ($tabs as $key => $info)
                        <button @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ?
                                'border-b-2 border-orange-500 text-orange-500 font-semibold' :
                                'text-slate-400 hover:text-slate-600'"
                            class="flex items-center gap-1 px-3 pb-2 text-xs uppercase tracking-wide whitespace-nowrap transition">
                            {{ $info['label'] }}
                        </button>
                    @endforeach
                </div>

                {{-- TAB: Identificación SIM --}}
                <div x-show="tab === 'identificacion'" x-cloak>
                    <div class="grid grid-cols-2 gap-4">
                        @php $d = $detalles; @endphp
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">ICC</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['icc'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">MSISDN (Fono)</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['msisdn'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Tipo SIM</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['simType'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Nombre Personalizado</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['customField1'] ?? '—' }}</div>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-center text-slate-500 mb-1">Plan</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['planName'] ?? '—' }}</div>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-center text-slate-500 mb-1">Estado SIM</label>
                            <div
                                class="form-input text-center text-sm
                                {{ ($d['simCycleState'] ?? '') === 'ACTIVATED' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-slate-50 dark:bg-slate-700' }}">
                                {{ $d['simCycleState'] ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Dispositivo --}}
                <div x-show="tab === 'dispositivo'" x-cloak>
                    @php $d = $detalles; @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">IMEI</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['imei'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">IMSI</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['imsi'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Fabricante Módulo</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['commModuleManufacturer'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Modelo Módulo</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['commModuleModel'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Campo Personalizado</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['customField2'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Operador Red</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['operator'] ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Conexión --}}
                <div x-show="tab === 'conexion'" x-cloak>
                    @php $d = $detalles; @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">APN</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['apn'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">IP</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['ip'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Estado GPRS</label>
                            <div
                                class="form-input text-center text-sm
                                {{ ($d['gprsStatus'] ?? 0) == 1 ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-rose-50 text-rose-600 dark:bg-rose-900/30 dark:text-rose-300' }}">
                                {{ ($d['gprsStatus'] ?? 0) == 1 ? 'Conectado' : 'Desconectado' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Última conexión
                                (inicio)</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['lastConnStart'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Última conexión (fin)</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['lastConnStop'] ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Consumo --}}
                <div x-show="tab === 'consumo'" x-cloak>
                    @php $d = $detalles; @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Consumo Mensual
                                (bytes)</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ number_format($d['consumptionMonthlyData'] ?? 0) }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Consumo Diario (bytes)</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ number_format($d['consumptionDailyData'] ?? 0) }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Plan</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['planCode'] ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Ubicación --}}
                <div x-show="tab === 'ubicacion'" x-cloak>
                    @php $d = $detalles; @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Latitud</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['latitude'] ?? '—' }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-center text-slate-500 mb-1">Longitud</label>
                            <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                                {{ $d['longitude'] ?? '—' }}</div>
                        </div>
                        @if (!empty($d['latitude']) && !empty($d['longitude']))
                            <div class="col-span-2">
                                <a href="https://maps.google.com/?q={{ $d['latitude'] }},{{ $d['longitude'] }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-center gap-2 btn bg-orange-500 hover:bg-orange-600 text-white w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Ver en Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        @endif

        <x-slot name="footer">
            <div class="flex justify-between items-center w-full">
                <x-form.button flat label="← Volver" wire:click="$set('modalDetalles', false)"
                    x-on:click="$wire.set('modalHub', true)" />
                <x-form.button primary label="Actualizar" wire:click="cargarDetalles" wire:loading.attr="disabled"
                    wire:target="cargarDetalles" />
            </div>
        </x-slot>
    </x-form.modal.card>


    {{-- ══════════════════════════════════════════════════════════════════════════
     DIAGNOSTICAR — Test GSM / GPRS
     ══════════════════════════════════════════════════════════════════════════ --}}
    <x-form.modal.card title="Test SIM" align="center" wire:model.live="modalDiagnostico" width="2xl" persistent>

        {{-- Info SIM --}}
        <div
            class="grid grid-cols-4 gap-2 text-xs text-center mb-5 pb-4 border-b border-orange-200 dark:border-slate-600">
            <div>
                <p class="font-semibold text-slate-500 mb-1">ICC</p>
                <p class="text-slate-800 dark:text-slate-200 break-all">{{ $icc }}</p>
            </div>
            <div>
                <p class="font-semibold text-slate-500 mb-1">Fono</p>
                <p class="text-slate-800 dark:text-slate-200">{{ $detalles['msisdn'] ?? '—' }}</p>
            </div>
            <div>
                <p class="font-semibold text-slate-500 mb-1">IMEI</p>
                <p class="text-slate-800 dark:text-slate-200">{{ $detalles['imei'] ?? '—' }}</p>
            </div>
            <div>
                <p class="font-semibold text-slate-500 mb-1">Dispositivo</p>
                <p class="text-slate-800 dark:text-slate-200">{{ $detalles['commModuleModel'] ?? '—' }}</p>
            </div>
        </div>

        {{-- Lista de tests --}}
        <div class="divide-y divide-orange-100 dark:divide-slate-700">

            {{-- Test GSM --}}
            <div class="flex items-center justify-between py-3 gap-3">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Test GSM</p>
                        <p class="text-xs text-slate-400">Permite comprobar si el dispositivo esta conectado a la red
                            celular.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if (!empty($testGsm))
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-bold
                            {{ ($testGsm['data']['result'] ?? '') === 'GSM_UP' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $testGsm['data']['result'] ?? ($testGsm['error'] ?? '?') }}
                        </span>
                    @endif
                    <button wire:click="ejecutarTestGsm" wire:loading.attr="disabled" wire:target="ejecutarTestGsm"
                        class="btn bg-orange-500 hover:bg-orange-600 text-white text-xs px-3 py-1.5">
                        <span wire:loading.remove wire:target="ejecutarTestGsm">Ejecutar</span>
                        <span wire:loading wire:target="ejecutarTestGsm" class="flex items-center gap-1">
                            <svg class="animate-spin w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                            </svg>
                            Probando...
                        </span>
                    </button>
                </div>
            </div>

            {{-- Test GPRS --}}
            <div class="flex items-center justify-between py-3 gap-3">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Test GPRS</p>
                        <p class="text-xs text-slate-400">Permite comprobar si el dispositivo esta conectado a
                            internet.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if (!empty($testGprs))
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-bold
                            {{ ($testGprs['data']['result'] ?? '') === 'GPRS_UP' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $testGprs['data']['result'] ?? ($testGprs['error'] ?? '?') }}
                        </span>
                    @endif
                    <button wire:click="ejecutarTestGprs" wire:loading.attr="disabled" wire:target="ejecutarTestGprs"
                        class="btn bg-orange-500 hover:bg-orange-600 text-white text-xs px-3 py-1.5">
                        <span wire:loading.remove wire:target="ejecutarTestGprs">Ejecutar</span>
                        <span wire:loading wire:target="ejecutarTestGprs" class="flex items-center gap-1">
                            <svg class="animate-spin w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                            </svg>
                            Probando...
                        </span>
                    </button>
                </div>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-start">
                <x-form.button flat label="← Volver" wire:click="$set('modalDiagnostico', false)"
                    x-on:click="$wire.set('modalHub', true)" />
            </div>
        </x-slot>
    </x-form.modal.card>


    {{-- ══════════════════════════════════════════════════════════════════════════
     EDITAR CAMPOS PERSONALIZADOS
     ══════════════════════════════════════════════════════════════════════════ --}}
    <x-form.modal.card title="Editar campos personalizados SIM" align="center" wire:model.live="modalEditar"
        width="2xl" persistent>

        <div class="grid grid-cols-2 gap-4">
            {{-- Datos de solo lectura de la API --}}
            <div>
                <label class="block text-xs text-center text-slate-500 mb-1">ICC</label>
                <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm select-all">
                    {{ $icc }}</div>
            </div>
            <div>
                <label class="block text-xs text-center text-slate-500 mb-1">Fono</label>
                <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                    {{ $detalles['msisdn'] ?? '—' }}</div>
            </div>
            <div>
                <label class="block text-xs text-center text-slate-500 mb-1">APN</label>
                <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                    {{ $detalles['apn'] ?? '—' }}</div>
            </div>
            <div>
                <label class="block text-xs text-center text-slate-500 mb-1">IMEI</label>
                <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                    {{ $detalles['imei'] ?? '—' }}</div>
            </div>
            <div class="col-span-2">
                <label class="block text-xs text-center text-slate-500 mb-1">Operador / Dispositivo</label>
                <div class="form-input text-center bg-slate-50 dark:bg-slate-700 text-sm">
                    {{ $detalles['operator'] ?? '—' }}
                    {{ !empty($detalles['commModuleModel']) ? '· ' . $detalles['commModuleModel'] : '' }}</div>
            </div>

            {{-- Campos editables --}}
            <div>
                <label class="block text-xs text-center text-slate-500 mb-1">Nombre Personalizado</label>
                <input wire:model.live="customField1" type="text" maxlength="100"
                    placeholder="Nombre personalizado" class="form-input w-full text-sm" />
                @error('customField1')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs text-center text-slate-500 mb-1">Campo Personalizado</label>
                <input wire:model.live="customField2" type="text" maxlength="100"
                    placeholder="Campo personalizado" class="form-input w-full text-sm" />
                @error('customField2')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between items-center w-full">
                <x-form.button primary label="Guardar datos" wire:click="guardarEditar" wire:loading.attr="disabled"
                    wire:target="guardarEditar" />
                <x-form.button flat label="Cancelar" wire:click="$set('modalEditar', false)"
                    x-on:click="$wire.set('modalHub', true)" />
            </div>
        </x-slot>
    </x-form.modal.card>


    {{-- ══════════════════════════════════════════════════════════════════════════
     ENVIAR SMS
     ══════════════════════════════════════════════════════════════════════════ --}}
    <x-form.modal.card title="Enviar SMS" align="center" wire:model.live="modalSms" width="2xl" persistent>

        <p class="text-xs text-slate-400 -mt-2 mb-4">ICC: {{ $icc }}</p>

        <div class="space-y-3">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                Mensaje <span class="text-rose-500">*</span>
            </label>
            <textarea wire:model.live="smsTexto" rows="4" maxlength="160"
                placeholder="Escribe el mensaje SMS (máx. 160 caracteres)…" class="form-input w-full resize-none text-sm"></textarea>
            <div class="flex justify-between items-center">
                @error('smsTexto')
                    <p class="text-xs text-rose-500">{{ $message }}</p>
                @else
                    <span></span>
                @enderror
                <span class="text-xs text-slate-400">{{ strlen($smsTexto) }}/160</span>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between items-center w-full">
                <button wire:click="enviarSms" wire:loading.attr="disabled" wire:target="enviarSms"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-violet-600 hover:bg-violet-700 text-white transition disabled:opacity-50">
                    <svg wire:loading.remove wire:target="enviarSms" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <svg wire:loading wire:target="enviarSms" class="animate-spin w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    Enviar SMS
                </button>
                <x-form.button flat label="Cancelar" wire:click="$set('modalSms', false)"
                    x-on:click="$wire.set('modalHub', true)" />
            </div>
        </x-slot>
    </x-form.modal.card>

</div>
