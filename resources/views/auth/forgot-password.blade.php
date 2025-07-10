<x-guest-layout>
    <div class="auth-title">{{ __('auth.reset_password_title') }}</div>
    <div class="auth-subtitle">{{ __('auth.reset_password_subtitle') }}</div>
    
    <div class="mb-4 text-sm text-gray-600">
        {{ __('auth.reset_instructions') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="status-message">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2"></i>
                {{ __('auth.email_address') }}
            </label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="{{ __('auth.email_placeholder') }}">
            @error('email')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a class="auth-link" href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i>
                {{ __('auth.back_to_login') }}
            </a>
            
            <button type="submit" class="auth-button">
                <i class="fas fa-paper-plane me-2"></i>
                {{ __('auth.send_reset_link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
