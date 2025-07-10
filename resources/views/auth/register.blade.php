<x-guest-layout>
    <div class="auth-title">{{ __('auth.create_your_account') }}</div>
    <div class="auth-subtitle">{{ __('auth.join_our_platform') }}</div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">
                <i class="fas fa-user me-2"></i>
                {{ __('common.full_name') }}
            </label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('common.full_name') }}">
            @error('name')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2"></i>
                {{ __('auth.email_address') }}
            </label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="{{ __('auth.email_placeholder') }}">
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
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('auth.password_placeholder') }}">
                <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer; font-size: 1rem;" onclick="togglePassword('password')" title="{{ __('auth.toggle_password_visibility') }}">
                    <i class="fas fa-eye" id="password-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="password-strength" style="margin-top: 0.5rem;">
                <div class="strength-bar" style="height: 4px; background: #e2e8f0; border-radius: 2px; overflow: hidden;">
                    <div id="strength-fill" style="height: 100%; width: 0%; background: #dc2626; transition: all 0.3s ease;"></div>
                </div>
                <div id="strength-text" style="font-size: 0.8rem; color: #6b7280; margin-top: 0.25rem;">{{ __('auth.password_strength') }}</div>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock me-2"></i>
                {{ __('auth.confirm_password') }}
            </label>
            <div class="password-input-wrapper" style="position: relative;">
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('auth.confirm_password') }}">
                <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer; font-size: 1rem;" onclick="togglePassword('password_confirmation')" title="{{ __('auth.toggle_password_visibility') }}">
                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div id="password-match" style="font-size: 0.8rem; margin-top: 0.25rem; display: none;">
                <i class="fas fa-check-circle" style="color: #22c55e;"></i>
                {{ __('auth.password_confirmed') }}
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="checkbox-group">
            <input id="terms" type="checkbox" class="checkbox-input" name="terms" required>
            <label for="terms" class="checkbox-label">
                {{ __('I agree to the') }}
                <a href="{{ route('terms') }}" class="auth-link" target="_blank">{{ __('common.terms') }}</a>
                {{ __('and') }}
                <a href="{{ route('privacy') }}" class="auth-link" target="_blank">{{ __('common.privacy') }}</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-button" id="register-btn" disabled>
            <i class="fas fa-user-plus me-2"></i>
            {{ __('auth.create_account') }}
        </button>

        <!-- Links -->
        <div class="auth-actions">
            <a class="auth-link" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt me-1"></i>
                {{ __('auth.already_have_account') }}
            </a>
        </div>
    </form>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordEye = document.getElementById(fieldId + '-eye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordEye.classList.remove('fa-eye');
                passwordEye.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordEye.classList.remove('fa-eye-slash');
                passwordEye.classList.add('fa-eye');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const termsCheckbox = document.getElementById('terms');
            const registerBtn = document.getElementById('register-btn');
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            const passwordMatch = document.getElementById('password-match');
            
            // Password strength checker
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strength = checkPasswordStrength(password);
                
                strengthFill.style.width = strength.percentage + '%';
                strengthFill.style.background = strength.color;
                strengthText.textContent = strength.text;
                strengthText.style.color = strength.color;
                
                checkFormValidity();
            });
            
            // Password confirmation checker
            confirmPasswordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword && password === confirmPassword) {
                    passwordMatch.style.display = 'block';
                    passwordMatch.style.color = '#22c55e';
                    this.style.borderColor = '#22c55e';
                } else if (confirmPassword) {
                    passwordMatch.style.display = 'block';
                    passwordMatch.innerHTML = '<i class="fas fa-times-circle" style="color: #dc2626;"></i> {{ __("auth.password_confirmed") }}';
                    passwordMatch.style.color = '#dc2626';
                    this.style.borderColor = '#dc2626';
                } else {
                    passwordMatch.style.display = 'none';
                    this.style.borderColor = 'var(--border-color)';
                }
                
                checkFormValidity();
            });
            
            // Terms checkbox
            termsCheckbox.addEventListener('change', checkFormValidity);
            
            function checkPasswordStrength(password) {
                let score = 0;
                if (password.length >= 8) score++;
                if (/[a-z]/.test(password)) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^a-zA-Z0-9]/.test(password)) score++;
                
                const strengths = [
                    { text: '{{ __("Very Weak") }}', color: '#dc2626', percentage: 20 },
                    { text: '{{ __("Weak") }}', color: '#f59e0b', percentage: 40 },
                    { text: '{{ __("Fair") }}', color: '#eab308', percentage: 60 },
                    { text: '{{ __("Good") }}', color: '#22c55e', percentage: 80 },
                    { text: '{{ __("Strong") }}', color: '#16a34a', percentage: 100 }
                ];
                
                return strengths[Math.min(score, 4)];
            }
            
            function checkFormValidity() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const termsAccepted = termsCheckbox.checked;
                const passwordStrong = password.length >= 8;
                const passwordsMatch = password === confirmPassword && confirmPassword;
                
                if (passwordStrong && passwordsMatch && termsAccepted) {
                    registerBtn.disabled = false;
                    registerBtn.style.opacity = '1';
                    registerBtn.style.cursor = 'pointer';
                } else {
                    registerBtn.disabled = true;
                    registerBtn.style.opacity = '0.6';
                    registerBtn.style.cursor = 'not-allowed';
                }
            }
        });
    </script>
</x-guest-layout>
