<div wire:poll.15s="refreshLocation"
    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 rounded-2xl shadow-sm overflow-hidden">

    {{-- Leaflet CDN (una sola vez en toda la página) --}}
    @once
        @push('head')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        @endpush
    @endonce

    {{-- Encabezado + estado de la señal --}}
    <div class="px-5 py-3.5 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 min-w-0">
            <span class="shrink-0 w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    Ubicación del Técnico
                </p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                    {{ $tecnicoNombre ?? 'Sin técnico asignado' }}
                </p>
            </div>
        </div>

        {{-- Indicador de frescura de la señal --}}
        <div class="shrink-0">
            @if (is_null($lat) || is_null($lng))
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-400 dark:text-gray-500">
                    <span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                    Sin señal
                </span>
            @elseif ($enProceso && !is_null($secondsAgo) && $secondsAgo < 60)
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 dark:text-green-400">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    En vivo · {{ $lastSeenLabel }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-600 dark:text-amber-400">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    {{ $lastSeenLabel ?? 'Última posición desconocida' }}
                </span>
            @endif
        </div>
    </div>

    {{-- Mapa (Livewire NO debe re-renderizar este subárbol; Alpine + $wire lo controlan) --}}
    <div wire:ignore class="relative" x-data="{
        map: null,
        marker: null,
        accuracyReady: false,
        initMap() {
            if (typeof L === 'undefined') { setTimeout(() => this.initMap(), 200); return; }
            const hasPos = this.$wire.lat !== null && this.$wire.lng !== null;
            const lat = hasPos ? this.$wire.lat : -12.0464;
            const lng = hasPos ? this.$wire.lng : -77.0428;

            this.map = L.map(this.$refs.map, { zoomControl: true, attributionControl: false })
                .setView([lat, lng], hasPos ? 16 : 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this.map);

            // Reajustar tamaño tras el render del contenedor
            setTimeout(() => this.map.invalidateSize(), 250);

            this.syncMarker(this.$wire.lat, this.$wire.lng);
        },
        syncMarker(lat, lng) {
            if (!this.map || lat === null || lng === null) return;
            const pos = [lat, lng];
            if (!this.marker) {
                this.marker = L.marker(pos).addTo(this.map);
                this.map.setView(pos, 16);
            } else {
                this.marker.setLatLng(pos);
                this.map.panTo(pos, { animate: true });
            }
        },
    }" x-init="$nextTick(() => initMap())" x-effect="syncMarker($wire.lat, $wire.lng)">

        <div x-ref="map" style="height: 340px; width: 100%; z-index: 0;"></div>

        {{-- Overlay mientras no hay posición --}}
        <div x-show="$wire.lat === null || $wire.lng === null"
            class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-gray-50/80 dark:bg-gray-900/70 backdrop-blur-sm text-center px-6">
            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 animate-pulse" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Esperando ubicación del técnico…</p>
            <p class="text-xs text-gray-400 dark:text-gray-500">
                El técnico envía su posición desde el app mientras la orden está en proceso.
            </p>
        </div>
    </div>

    {{-- Pie: coordenadas + enlace + nota de refresco --}}
    <div class="px-5 py-2.5 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between gap-3">
        <span class="text-xs font-mono text-gray-400 dark:text-gray-500">
            @if (!is_null($lat) && !is_null($lng))
                {{ number_format($lat, 6) }}, {{ number_format($lng, 6) }}
            @else
                —
            @endif
        </span>
        <div class="flex items-center gap-3">
            @if (!is_null($lat) && !is_null($lng))
                <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1 text-xs text-blue-500 hover:text-blue-700 hover:underline font-medium">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Ver en Maps
                </a>
            @endif
            <span class="inline-flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500">
                <svg class="w-3 h-3" wire:loading wire:target="refreshLocation" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Actualiza cada 15s
            </span>
        </div>
    </div>
</div>
