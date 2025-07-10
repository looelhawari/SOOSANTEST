<x-guest-layout>
    <div class="auth-title">{{ __('auth.welcome_back') }}</div>
    <div class="auth-subtitle">{{ __('auth.sign_in_to_account') }}</div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="status-message">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2"></i>
                {{ __('auth.email_address') }}
            </label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="{{ __('auth.email_placeholder') }}">
            @error('email')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2"></i>
                {{ __('auth.password') }}
            </label>
            <div class="password-input-wrapper" style="position: relative;">
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('auth.password_placeholder') }}">
                <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer; font-size: 1rem;" onclick="togglePassword()" title="{{ __('auth.toggle_password_visibility') }}">
                    <i class="fas fa-eye" id="password-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
            <label for="remember_me" class="checkbox-label">{{ __('auth.remember_me_30_days') }}</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-button">
            <i class="fas fa-sign-in-alt me-2"></i>
            {{ __('auth.sign_in') }}
        </button>

        <!-- Links -->
        <div class="auth-actions">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    <i class="fas fa-key me-1"></i>
                    {{ __('auth.forgot_password') }}
                </a>
            @endif

            @if (Route::has('register'))
                <a class="auth-link" href="{{ route('register') }}">
                    <i class="fas fa-user-plus me-1"></i>
                    {{ __('auth.create_account') }}
                </a>
            @endif
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordEye = document.getElementById('password-eye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordEye.classList.remove('fa-eye');
                passwordEye.classList.add('fa-eye-slash');
                passwordInput.setAttribute('aria-label', '{{ __('auth.hide_password') }}');
            } else {
                passwordInput.type = 'password';
                passwordEye.classList.remove('fa-eye-slash');
                passwordEye.classList.add('fa-eye');
                passwordInput.setAttribute('aria-label', '{{ __('auth.show_password') }}');
            }
        }

        // Add loading state to form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            form.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('auth.processing') }}';
                
                // Re-enable button after 5 seconds as failsafe
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }, 5000);
            });
        });
    </script>
</x-guest-layout>
