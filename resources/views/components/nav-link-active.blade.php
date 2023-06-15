@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center p-2 rounded-lg text-white bg-gray-700'
    : 'flex items-center p-2 rounded-lg text-white hover:bg-gray-700';

@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
