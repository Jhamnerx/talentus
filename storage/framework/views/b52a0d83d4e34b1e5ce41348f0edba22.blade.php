<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<x-form.card  {{ $attributes }}>
<x-slot name="footer" class="flex justify-between gap-x-4">{{ $footer }}</x-slot>
{{ $slot ?? "" }}
</x-form.card>