<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<x-form.card  {{ $attributes }}>
<x-slot name="action" >{{ $action }}</x-slot>
<x-slot name="footer" class="flex justify-end gap-3">{{ $footer }}</x-slot>
{{ $slot ?? "" }}
</x-form.card>