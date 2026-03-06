<div class="mb-8">
    
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-7 gap-4">

        
        <div class="col-span-1 bg-linear-to-br from-blue-500 to-blue-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Ventas PEN</p>
            <p class="text-2xl font-bold mt-1">S/ <?php echo e(number_format($resumen['ventas_pen'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Facturas emitidas</p>
        </div>

        
        <div class="col-span-1 bg-linear-to-br from-sky-500 to-sky-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Ventas USD</p>
            <p class="text-2xl font-bold mt-1">$ <?php echo e(number_format($resumen['ventas_usd'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Facturas emitidas</p>
        </div>

        
        <div class="col-span-1 bg-linear-to-br from-violet-500 to-violet-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Recibos PEN</p>
            <p class="text-2xl font-bold mt-1">S/ <?php echo e(number_format($resumen['recibos_pen'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Recibos emitidos</p>
        </div>

        
        <div class="col-span-1 bg-linear-to-br from-purple-500 to-purple-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Recibos USD</p>
            <p class="text-2xl font-bold mt-1">$ <?php echo e(number_format($resumen['recibos_usd'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Recibos emitidos</p>
        </div>

        
        <div class="col-span-1 bg-linear-to-br from-orange-500 to-orange-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Compras</p>
            <p class="text-2xl font-bold mt-1">S/ <?php echo e(number_format($resumen['compras'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Total compras</p>
        </div>

        
        <div class="col-span-1 bg-linear-to-br from-emerald-500 to-emerald-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Ingresos</p>
            <p class="text-2xl font-bold mt-1">S/ <?php echo e(number_format($resumen['ingresos'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Movimientos +</p>
        </div>

        
        <div class="col-span-1 bg-linear-to-br from-rose-500 to-rose-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Egresos</p>
            <p class="text-2xl font-bold mt-1">S/ <?php echo e(number_format($resumen['egresos'], 2)); ?></p>
            <p class="text-xs opacity-70 mt-1">Movimientos -</p>
        </div>

    </div>
</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/inicio/dashboard.blade.php ENDPATH**/ ?>