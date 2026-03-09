<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="Content-Security-Policy" content="frame-src 'self'">
    <link rel="icon" href="<?php echo e(asset('images/favicon2023.png')); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />


    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/fontawesome-all.min.css')); ?>">

    
    <script src="<?php echo e(asset('plugins/jquery/jquery.min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('plugins/ckeditor/ckeditor.js')); ?>"></script>


    <!-- Styles -->

    <script >window.Wireui = {cache: {},hook(hook, callback) {window.addEventListener(`wireui:${hook}`, () => callback())},dispatchHook(hook) {window.dispatchEvent(new Event(`wireui:${hook}`))}}</script>
<script src="http://talentus.test/wireui/assets/scripts" defer ></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>
</head>


<body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }" x-data="{ page: '<?php echo e($attributes->get('ruta', '')); ?>', <?php echo e($attributes->get('panel', '')); ?> sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <?php if (isset($component)) { $__componentOriginal3dde83133891f87f89e964628fb558b6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3dde83133891f87f89e964628fb558b6 = $attributes; } ?>
<?php $component = WireUi\Components\Notifications\Index::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.notifications'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Notifications\Index::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3dde83133891f87f89e964628fb558b6)): ?>
<?php $attributes = $__attributesOriginal3dde83133891f87f89e964628fb558b6; ?>
<?php unset($__attributesOriginal3dde83133891f87f89e964628fb558b6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3dde83133891f87f89e964628fb558b6)): ?>
<?php $component = $__componentOriginal3dde83133891f87f89e964628fb558b6; ?>
<?php unset($__componentOriginal3dde83133891f87f89e964628fb558b6); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginaladf7d5283c6c06cb103ae62523e6a412 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaladf7d5283c6c06cb103ae62523e6a412 = $attributes; } ?>
<?php $component = WireUi\Components\Dialog\Index::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Dialog\Index::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaladf7d5283c6c06cb103ae62523e6a412)): ?>
<?php $attributes = $__attributesOriginaladf7d5283c6c06cb103ae62523e6a412; ?>
<?php unset($__attributesOriginaladf7d5283c6c06cb103ae62523e6a412); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaladf7d5283c6c06cb103ae62523e6a412)): ?>
<?php $component = $__componentOriginaladf7d5283c6c06cb103ae62523e6a412; ?>
<?php unset($__componentOriginaladf7d5283c6c06cb103ae62523e6a412); ?>
<?php endif; ?>
    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>

    <div class="flex h-dvh overflow-hidden">

        <?php if (isset($component)) { $__componentOriginalbebe114f3ccde4b38d7462a3136be045 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbebe114f3ccde4b38d7462a3136be045 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar','data' => ['variant' => $attributes['sidebarVariant']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes['sidebarVariant'])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $attributes = $__attributesOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $component = $__componentOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__componentOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden <?php if($attributes['background']): ?> <?php echo e($attributes['background']); ?> <?php endif; ?>"
            x-ref="contentarea">

            
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.header', ['page' => request()->fullUrl(), 'variant' => 'v3']);

$key = null;
$__componentSlots = [];

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3964432384-0', $key);

$__html = app('livewire')->mount($__name, $__params, $key, $__componentSlots);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

            <main class="grow">
                <?php echo e($slot); ?>

            </main>

        </div>

    </div>




    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

<script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            //width: 600,
            //padding: "3em",
            showConfirmButton: false,
            timer: 2200,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
        Echo.private('App.Models.User.' + <?php echo e(Auth::user()->id); ?>)
            .notification((notification) => {
                Livewire.emit('notificaciones-update');

            });

    });
</script>
<script>
    // Livewire.onPageExpired((response, message) => {
    //     console.log('pagina expirada')

    // })
</script>
<script>
    document.addEventListener('livewire:initialized', () => {
        //success
        //question
        //info
        //warning
        //error
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });


        Livewire.on('notify-toast', (event) => {
            Toast.fire({
                icon: event.icon,
                title: `<div  style="font-size: 15px; color: #052c52;"> ` +
                    event.title + `</div`,
                html: `<div  style="font-size: 14px; color: #056b85;"> ` +
                    event.mensaje + `</div`,
                showCloseButton: true,
                timer: event.timer ? event.timer : 3000,
            });

        });


        Livewire.on('error', (event) => {
            Toast.fire({
                icon: 'error',
                title: event.title,
                html: event.mensaje,
                showCloseButton: true,
            });

        });

        Livewire.on('notify', (event) => {
            Swal.fire({
                icon: event.icon,
                title: event.title,
                text: event.mensaje,
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })

        });

        Livewire.on('suspend-save', (event) => {
            iziToast.success({
                maxWidth: 500,
                position: 'center',
                title: 'Se ha guardado el registro de suspencion!',
                message: 'Las siguientes Lineas: ' + event.lista,
                position: 'topRight',
                transitionIn: 'bounceInLeft',
                // iconText: 'star',
                onOpened: function(instance, toast) {},
                onClosed: function(instance, toast, closedBy) {
                    console.info('closedBy: ' + closedBy);
                }
            });

        });



    });
</script>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('venta-registrada')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'VENTA REGISTRADA',
                text: '<?php echo e(session('venta-registrada')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('nota-registrada')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'NOTA REGISTRADA',
                text: '<?php echo e(session('nota-registrada')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('cobro-registrado')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'REGISTRO DE COBRO REGISTRADO',
                text: '<?php echo e(session('cobro-registrado')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('cotizacion-registrada')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'COTIZACION REGISTRADA',
                text: '<?php echo e(session('cotizacion-registrada')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('cotizacion-actualizada')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'COTIZACION ACTUALIZADA',
                text: '<?php echo e(session('cotizacion-actualizada')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('recibo-registrado')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'GUARDADO',
                text: '<?php echo e(session('recibo-registrado')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('recibog-store')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'GUARDADO',
                text: '<?php echo e(session('recibog-store')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('recibo-actualizo')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'ACTUALIZADO',
                text: '<?php echo e(session('recibo-actualizo')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('recibog-actualizo')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'ACTUALIZADO',
                text: '<?php echo e(session('recibog-actualizo')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('guia-store')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'GUIA REGISTRADA',
                text: '<?php echo e(session('guia-store')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('update')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                text: '<?php echo e(session('update')); ?>',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</html>
<?php /**PATH C:\laragon2\www\talentus\resources\views/layouts/admin.blade.php ENDPATH**/ ?>