<div class="col-span-12 bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-600">
    <div class="flex flex-col h-full">
        <!-- Card top -->
        <div class="grow p-5">
            <div class="flex justify-between items-start">
                <!-- Image + name -->
                <header>
                    <div class="flex mb-2">
                        <a class="relative inline-flex items-start mr-5" href="#0">
                            <img class="rounded-full" src="<?php echo e(asset('images/user-64-10.jpg')); ?>" width="64"
                                height="64" alt="User 01" />
                        </a>
                        <div class="mt-1 pr-1">
                            <a class="inline-flex text-slate-800 dark:text-slate-100 hover:text-slate-900 dark:hover:text-white" href="#0">
                                <h2 class="text-xl leading-snug justify-center font-semibold">
                                    <?php echo e($cliente->razon_social); ?></h2>
                            </a>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-slate-400 dark:text-slate-500 -mt-0.5 mr-1">-&gt;</span>
                                <span class="text-sm text-slate-600 dark:text-slate-300"><?php echo e($cliente->direccion); ?></span>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="relative inline-flex shrink-0">
                    <button wire:click.prevent="unselectCliente" type="button"
                        class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-300 rounded-full"
                        :class="{ 'bg-slate-100 dark:bg-gray-700 text-slate-500': open }" aria-haspopup="true">
                        <span class="sr-only">close</span>
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Bio -->
            <div class="mt-2 text-slate-600 dark:text-slate-300">
                <div class="text-sm">DNI/RUC: <?php echo e($cliente->numero_documento); ?></div>
                <div class="text-sm">TELEFONO: <?php echo e($cliente->telefono); ?></div>
                <div class="text-sm">E-MAIL: <?php echo e($cliente->email); ?></div>
                <div class="text-sm">WEB: <?php echo e($cliente->web_site); ?></div>
            </div>
        </div>
        <!-- Card footer -->
        
    </div>
</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/components/admin/ventas/cliente-selected.blade.php ENDPATH**/ ?>