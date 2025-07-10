@props(['route' => 'admin.logout', 'label' => null])

<form method="POST" action="{{ route($route) }}" class="d-inline">
    @csrf
    <button type="submit" {{ $attributes->merge(['class' => 'nav-icon-item logout-btn']) }} style="border: none; background: none;">
        <i class="fas fa-sign-out-alt nav-icon"></i>
        <span class="nav-icon-label">{{ $label ?? __('common.logout') }}</span>
    </button>
</form>
