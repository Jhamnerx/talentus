<x-admin-layout>

    {{-- Layout dividido: 2 columnas en desktop, 1 en móvil --}}
    <div class="flex flex-col lg:flex-row gap-0 lg:gap-4 min-h-screen">

        {{-- Panel izquierdo: Líneas --}}
        <div class="w-full lg:w-1/2 overflow-x-auto">
            @livewire('admin.lineas.index')
        </div>

        {{-- Divisor vertical solo en desktop --}}
        <div class="hidden lg:block w-px bg-slate-200 dark:bg-slate-700 self-stretch"></div>

        {{-- Panel derecho: Sim Cards --}}
        <div class="w-full lg:w-1/2 overflow-x-auto">
            @livewire('admin.sim-card.index')
        </div>

    </div>

    {{-- Modales de Líneas --}}
    @livewire('admin.sim-card.asign-linea')
    @livewire('admin.lineas.asign-to-placa')
    @livewire('admin.lineas.suspend-linea')
    @livewire('admin.lineas.save')
    @livewire('admin.lineas.edit')
    @livewire('admin.lineas.cambiar-chip')
    @livewire('admin.lineas.registrar-asignacion')
    @livewire('admin.gerencia.reportes.modales.reporte-lineas')

    {{-- Modales de Sim Cards --}}
    @livewire('admin.sim-card.import')
    @livewire('admin.sim-card.un-asign')
    @livewire('admin.sim-card.save')
    @livewire('admin.sim-card.edit')
    @livewire('admin.sim-card.ver-cambios')
    @livewire('admin.sim-card.cambiar-numero')

</x-admin-layout>
