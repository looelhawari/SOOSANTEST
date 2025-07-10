@extends('layouts.admin')

@section('title', __('auth.admin_login'))

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="admin-card p-4">
                    <!-- Logo/Brand -->
                    <div class="text-center mb-4">
                        <i class="fas fa-cogs fa-3x text-primary mb-3"></i>
                        <h2 class="h4 mb-0">{{ __('auth.admin_panel') }}</h2>
                        <p class="text-muted">{{ __('auth.sign_in_to_dashboard') }}</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('admin.login.submit') }}" id="adminLoginForm">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('auth.email_address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus
                                    placeholder="{{ __('auth.enter_your_email') }}"
                                    aria-describedby="email-help"
                                >
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small id="email-help" class="form-text text-muted">{{ __('auth.valid_email') }}</small>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('auth.password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    required
                                    placeholder="{{ __('auth.enter_your_password') }}"
                                    aria-describedby="password-help"
                                >
                                <button 
                                    type="button" 
                                    class="btn btn-outline-secondary" 
                                    onclick="toggleAdminPassword()"
                                    title="{{ __('auth.toggle_password_visibility') }}"
                                >
                                    <i class="fas fa-eye" id="admin-password-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small id="password-help" class="form-text text-muted">{{ __('auth.secure_password') }}</small>
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                {{ __('auth.remember_me_30_days') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-admin-primary btn-lg" id="adminLoginBtn">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                {{ __('auth.sign_in') }}
                            </button>
                        </div>
                    </form>

                    <!-- Security Notice -->
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            {{ __('auth.secure_connection') }}
                        </small>
                    </div>

                    <!-- Back to Website Link -->
                    <div class="text-center mt-4">
                        <a href="{{ route('homepage') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>
                            {{ __('auth.back_to_website') }}
                        </a>
                    </div>

                    <!-- Demo Credentials (for development) -->
                    @if(app()->environment('local'))
                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <strong>{{ __('auth.demo_credentials') }}:</strong><br>
                                {{ __('auth.email') }}: admin@example.com<br>
                                {{ __('auth.password') }}: password
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAdminPassword() {
        const passwordInput = document.getElementById('password');
        const passwordEye = document.getElementById('admin-password-eye');
        
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

    // Add loading state to admin login form
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('adminLoginForm');
        const submitButton = document.getElementById('adminLoginBtn');
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

        // Add focus effects
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('input-group-focus');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('input-group-focus');
            });
        });
    });
</script>
@endsection
