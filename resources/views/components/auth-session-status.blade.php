@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-center font-medium text-sm text-red-600 dark:text-red-400']) }}>
        {{ $status }}
    </div>
@endif
