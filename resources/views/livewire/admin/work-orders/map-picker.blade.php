<div>
    {{-- Trigger --}}
    <div class="flex items-center gap-2">
        @if ($lat && $lng)
            <div class="flex items-center gap-1.5 text-sm text-green-600 dark:text-green-400">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate max-w-xs text-xs"
                    title="{{ $direccion ?: number_format($lat, 6) . ', ' . number_format($lng, 6) }}">
                    {{ $direccion ?: number_format($lat, 6) . ', ' . number_format($lng, 6) }}
                </span>
            </div>
        @endif

        <x-form.button outline xs icon="map-pin" wire:click="openModal"
            label="{{ $lat ? 'Cambiar ubicación' : 'Asignar ubicación' }}" />

        @if ($lat && $lng)
            <x-form.button flat xs icon="trash" wire:click="limpiar" wire:confirm="¿Eliminar la ubicación asignada?"
                class="text-red-500 hover:text-red-600 dark:text-red-400" />
        @endif
    </div>

    {{-- Modal --}}
    <x-form.modal.card title="Seleccionar ubicación del servicio" wire:model.live="open" max-width="3xl">

        <div x-data="{
            map: null,
            marker: null,
            searchInput: '',
        
            init() {
                this.$nextTick(() => this.initMap());
            },
        
            initMap() {
                const lat = {{ $lat ?? '-12.0464' }};
                const lng = {{ $lng ?? '-77.0428' }};
                const zoom = {{ $lat ? '16' : '12' }};
        
                this.map = L.map(this.$refs.mapContainer, { zoomControl: true }).setView([lat, lng], zoom);
        
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19,
                }).addTo(this.map);
        
                @if($lat && $lng)
                this.marker = L.marker([{{ $lat }}, {{ $lng }}], { draggable: true }).addTo(this.map);
                this.marker.on('dragend', () => this.onMarkerMove());
                @endif
        
                this.map.on('click', (e) => this.onMapClick(e.latlng));
            },
        
            onMapClick(latlng) {
                if (this.marker) {
                    this.marker.setLatLng(latlng);
                } else {
                    this.marker = L.marker(latlng, { draggable: true }).addTo(this.map);
                    this.marker.on('dragend', () => this.onMarkerMove());
                }
                this.reverseGeocode(latlng.lat, latlng.lng);
            },
        
            onMarkerMove() {
                const latlng = this.marker.getLatLng();
                this.reverseGeocode(latlng.lat, latlng.lng);
            },
        
            async reverseGeocode(lat, lng) {
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lng=${lng}`, { headers: { 'Accept-Language': 'es' } }
                    );
                    const data = await res.json();
                    $wire.seleccionarUbicacion(lat, lng, data.display_name ?? '');
                } catch (_) {
                    $wire.seleccionarUbicacion(lat, lng, '');
                }
            },
        
            async searchAddress() {
                if (!this.searchInput.trim()) return;
                try {
                    const q = encodeURIComponent(this.searchInput);
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${q}&limit=1&countrycodes=pe`, { headers: { 'Accept-Language': 'es' } }
                    );
                    const results = await res.json();
                    if (results.length > 0) {
                        const { lat, lon, display_name } = results[0];
                        const latlng = L.latLng(parseFloat(lat), parseFloat(lon));
                        this.map.setView(latlng, 17);
                        this.onMapClick(latlng);
                    }
                } catch (_) {}
            },
        }" x-init="init()">

            {{-- Leaflet CDN --}}
            @once
                @push('head')
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                @endpush
            @endonce

            {{-- Barra de búsqueda --}}
            <div class="flex gap-2 mb-3">
                <x-form.input x-model="searchInput" @keydown.enter.prevent="searchAddress()"
                    placeholder="Buscar dirección en Perú..." icon="magnifying-glass" class="flex-1" />
                <x-form.button primary label="Buscar" @click="searchAddress()" />
            </div>

            {{-- Mapa --}}
            <div x-ref="mapContainer" style="height: 380px; width: 100%; border-radius: 10px; z-index: 0;"></div>

            {{-- Coordenadas seleccionadas --}}
            @if ($lat && $lng)
                <div
                    class="mt-3 flex items-start gap-2 p-3 rounded-lg bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800">
                    <svg class="w-4 h-4 mt-0.5 text-primary-600 dark:text-primary-400 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-primary-700 dark:text-primary-300">
                            {{ $direccion ?: 'Sin dirección detectada' }}
                        </p>
                        <p class="font-mono text-xs text-primary-500 dark:text-primary-400 mt-0.5">
                            {{ number_format($lat, 6) }}, {{ number_format($lng, 6) }}
                        </p>
                    </div>
                </div>
            @else
                <p class="mt-3 text-sm text-gray-400 dark:text-gray-500 text-center">
                    Haz clic en el mapa o busca una dirección para seleccionar el punto de servicio.
                </p>
            @endif
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary icon="check" label="Guardar ubicación" wire:click="guardar"
                    wire:loading.attr="disabled" :disabled="!$lat || !$lng" />
            </div>
        </x-slot>

    </x-form.modal.card>
</div>
