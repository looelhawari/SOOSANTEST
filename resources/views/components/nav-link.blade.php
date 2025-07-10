@props(['active', 'icon' => null])

@php
$classes = ($active ?? false)
            ? 'nav-icon-item active'
            : 'nav-icon-item';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="fas fa-{{ $icon }} nav-icon"></i>
    @endif
    <span class="nav-icon-label">{{ $slot }}</span>
</a>
