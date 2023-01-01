<div class="grid grid-cols-12 gap-6">

    <x-admin.gerencia.reportes.cards color-initial="from-indigo-400" color-final="to-indigo-600" cantidad="1"
        wire:click="openModalReporteProductos">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor" stroke-linejoin="round"
                    class="nc-icon-wrapper">
                    <path d="M56,30V54a5,5,0,0,1-5,5H13a5,5,0,0,1-5-5V30"></path>
                    <rect x="2" y="14" width="60" height="10"></rect>
                    <path d="M14,8a6,6,0,0,1,6-6c8.875,0,12,12,12,12H20A6,6,0,0,1,14,8Z"></path>
                    <path d="M50,8a6,6,0,0,0-6-6C35.125,2,32,14,32,14H44A6,6,0,0,0,50,8Z"></path>
                    <polyline points="38 14 38 59 26 59 26 14"></polyline>
                </g>
            </svg>
            </x-slot>
            REPORTE PRODUCTOS
    </x-admin.gerencia.reportes.cards>

    <x-admin.gerencia.reportes.cards color-initial="from-teal-400" color-final="to-teal-600" cantidad="1"
        wire:click="openModalReporteLineas">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor" stroke-linejoin="round"
                    class="nc-icon-wrapper">
                    <path
                        d="M41.387,38.587l-4.564,5.7A48.167,48.167,0,0,1,19.709,27.179l5.705-4.564a3.877,3.877,0,0,0,1.12-4.6l-5.2-11.71a3.878,3.878,0,0,0-4.52-2.18l-9.9,2.568A3.9,3.9,0,0,0,4.037,11,57.521,57.521,0,0,0,53,59.963a3.9,3.9,0,0,0,4.307-2.877l2.568-9.9a3.881,3.881,0,0,0-2.179-4.52l-11.709-5.2A3.874,3.874,0,0,0,41.387,38.587Z">
                    </path>
                    <path d="M35,5A24,24,0,0,1,59,29"></path>
                    <path d="M47,29A12,12,0,0,0,35,17"></path>
                </g>
            </svg>
            </x-slot>
            REPORTE LINEAS
    </x-admin.gerencia.reportes.cards>

    <x-admin.gerencia.reportes.cards color-initial="from-cyan-400" color-final="to-cyan-600" cantidad="1"
        wire:click="openModalReporteClientes">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-width="2" fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                    <path d="M38,39H26A18,18,0,0,0,8,57H8s9,4,24,4,24-4,24-4h0A18,18,0,0,0,38,39Z" fill="none"
                        stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10"></path>
                    <path data-color="color-2"
                        d="M19,17.067a13,13,0,1,1,26,0C45,24.283,39.18,32,32,32S19,24.283,19,17.067Z" fill="none"
                        stroke-linecap="square" stroke-miterlimit="10"></path>
                </g>
            </svg>
            </x-slot>
            REPORTES CLIENTES
    </x-admin.gerencia.reportes.cards>

    {{-- <x-admin.gerencia.reportes.cards color-initial="from-blue-400" color-final="to-blue-600" cantidad="1"
        wire:click="openModalReporteVehiculos">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor" stroke-linejoin="round"
                    class="nc-icon-wrapper">
                    <line data-cap="butt" x1="32" y1="29" x2="41" y2="19"></line>
                    <path data-cap="butt" d="M57,29,52.829,8.98A5,5,0,0,0,47.934,5H16.066a5,5,0,0,0-4.895,3.98L7,29">
                    </path>
                    <polyline points="16 54 16 58 6 58 6 54"></polyline>
                    <path d="M62,49H2V36.066a4.99,4.99,0,0,1,1.465-3.532L7,29H57l3.535,3.535A5,5,0,0,1,62,36.071Z">
                    </path>
                    <circle cx="11" cy="40" r="3"></circle>
                    <polyline points="58 54 58 58 48 58 48 54"></polyline>
                    <circle cx="53" cy="40" r="3"></circle>
                    <line x1="25" y1="40" x2="39" y2="40"></line>
                </g>
            </svg>
            </x-slot>
            REPORTES VEHICULOS
    </x-admin.gerencia.reportes.cards> --}}
    {{-- <x-admin.gerencia.reportes.cards color-initial="from-lime-400" color-final="to-lime-600" cantidad="1"
        wire:click="openModalReporteDispositivos">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor" stroke-linejoin="round"
                    class="nc-icon-wrapper">
                    <path data-cap="butt"
                        d="M15.377,8.234c1.829,1.352,3.234,4.79,3.234,4.79a6.253,6.253,0,0,1,2.074,2.5,6.881,6.881,0,0,1,.027,3.3s1.4,4.112.742,5.266-3.461,1.894-3.461,1.894a5.4,5.4,0,0,1-3.543,2.554A3.32,3.32,0,0,0,11.319,32c0,2.225,2.224,5.849,2.224,5.849S15.85,38.977,16.18,39.8a12.585,12.585,0,0,1,.441,2.743s2.2,3.873.959,6.1c-.394.71-2.224,1.236-2.224,1.236L12.79,53.727">
                    </path>
                    <path data-cap="butt"
                        d="M54.887,14.188a47.05,47.05,0,0,1-7.694,2.461s-3.577,3.982-5.925,3.652-4.737-2.965-4.737-2.965.164-4.861-.577-5.108S33.235,13.3,32,12.31s-.523-3.775-.523-3.775-2.69-.838-3.02-1.745.979-2.924,1.229-3.7">
                    </path>
                    <path
                        d="M53.256,33.9c.659,1.565-1.237,5.563-2.8,6.343A10.6,10.6,0,0,0,46.4,43.475c-.578.907-1.335,4.646-3.231,5.388s-6.387,4.969-8.775,4.31-2.39-6.343-.742-8.9c.984-1.525-.164-4.861-.247-6.015s-3.543-3.3-3.543-4.449c0-1.812,3.954-6.59,3.954-6.59s3.241-1.071,4.23-.824A15.012,15.012,0,0,1,40.9,27.8s3.707.329,5.108,1.071l1.9,1.73S52.6,32.33,53.256,33.9Z">
                    </path>
                    <circle cx="32" cy="32" r="29"></circle>
                </g>
            </svg>
            </x-slot>
            REPORTES DISPOSITIVOS
    </x-admin.gerencia.reportes.cards> --}}

    <x-admin.gerencia.reportes.cards color-initial="from-orange-400" color-final="to-orange-600" cantidad="1"
        wire:click="openModalReporteGuias">
        <x-slot:icono>

            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor" stroke-linejoin="round"
                    class="nc-icon-wrapper">
                    <polyline data-cap="butt" points="56 20 39 20 39 3"></polyline>
                    <polygon points="56 20 56 61 8 61 8 3 39 3 56 20"></polygon>
                    <line x1="19" y1="49" x2="45" y2="49"></line>
                    <line x1="19" y1="39" x2="45" y2="39"></line>
                    <line x1="19" y1="29" x2="45" y2="29"></line>
                    <line x1="19" y1="19" x2="30" y2="19"></line>
                </g>
            </svg>
            </x-slot>
            REPORTES GUIAS
    </x-admin.gerencia.reportes.cards>
    <x-admin.gerencia.reportes.cards color-initial="from-red-400" color-final="to-red-600" cantidad="1"
        wire:click="openModalReporteComprasVentas">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-width="2" fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                    <circle data-color="color-2" cx="10.5" cy="54.5" r="5.5" fill="none" stroke-linecap="square"
                        stroke-miterlimit="10"></circle>
                    <circle data-color="color-2" cx="53.5" cy="54.5" r="5.5" fill="none" stroke-linecap="square"
                        stroke-miterlimit="10"></circle>
                    <polyline points="4 4 9 10 9 34 4 43 60 43" fill="none" stroke="currentColor"
                        stroke-linecap="square" stroke-miterlimit="10"></polyline>
                    <polyline data-cap="butt" points="9 10 56 10 48 34 9 34" fill="none" stroke="currentColor"
                        stroke-miterlimit="10"></polyline>
                </g>
            </svg>
            </x-slot>
            COMPRAS VS VENTAS
    </x-admin.gerencia.reportes.cards>
    <x-admin.gerencia.reportes.cards color-initial="from-emerald-400" color-final="to-emerald-600" cantidad="1"
        wire:click="openModalReporteVentas">
        <x-slot:icono>
            <svg class="w-full fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g stroke-width="2" fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                    <circle data-color="color-2" cx="10.5" cy="54.5" r="5.5" fill="none" stroke-linecap="square"
                        stroke-miterlimit="10"></circle>
                    <circle data-color="color-2" cx="53.5" cy="54.5" r="5.5" fill="none" stroke-linecap="square"
                        stroke-miterlimit="10"></circle>
                    <polyline points="4 4 9 10 9 34 4 43 60 43" fill="none" stroke="currentColor"
                        stroke-linecap="square" stroke-miterlimit="10"></polyline>
                    <polyline data-cap="butt" points="9 10 56 10 48 34 9 34" fill="none" stroke="currentColor"
                        stroke-miterlimit="10"></polyline>
                </g>
            </svg>
            </x-slot>
            REPORTES VENTAS
    </x-admin.gerencia.reportes.cards>
</div>
