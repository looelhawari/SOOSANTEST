@extends('layouts.admin')

@section('title', __('users.edit_user'))
@section('page-title', __('users.edit_user'))

@push('styles')
<style>
    /* Page Header */
    .modern-page-header {
        background: #0077C8;
        color: #F0F0F0;
        padding: 2.5rem 0;
        margin: -1.5rem -1.5rem 2rem;
        border-radius: 0 0 12px 12px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .modern-page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        z-index: 0;
    }
    .modern-page-header .container-fluid {
        position: relative;
        z-index: 1;
    }
    .modern-page-header h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: #F0F0F0;
        margin-bottom: 0.5rem;
    }
    .modern-page-header p {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        color: #F0F0F0;
        opacity: 0.9;
        margin-bottom: 0;
    }
    .dark-mode .modern-page-header {
        background: #005B99;
    }

    /* Modern Card */
    .modern-card {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }
    .dark-mode .modern-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }

    /* Form Group */
    .modern-form-group {
        margin-bottom: 1.5rem;
    }
    .modern-label {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #333333;
        margin-bottom: 0.5rem;
        display: block;
    }
    .dark-mode .modern-label {
        color: #F0F0F0;
    }
    .modern-input, .modern-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #E9ECEF;
        border-radius: 8px;
        background: #FFFFFF;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #333333;
        transition: all 0.3s ease;
    }
    .modern-input:focus, .modern-select:focus {
        border-color: #C1D82F;
        box-shadow: 0 0 0 0.2rem rgba(193, 216, 47, 0.25);
        outline: none;
    }
    .modern-input.is-invalid {
        border-color: #E53935;
    }
    .dark-mode .modern-input, .dark-mode .modern-select {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .dark-mode .modern-input::placeholder, .dark-mode .modern-select::placeholder {
        color: #A0AEC0;
    }
    .modern-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23333333' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em 1.25em;
        padding-right: 2.5rem;
    }
    .dark-mode .modern-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23F0F0F0' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }

    /* Checkbox */
    .modern-checkbox {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #F9F9F9;
        border-radius: 8px;
        border: 2px solid #E9ECEF;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .modern-checkbox:hover {
        border-color: #C1D82F;
        background: #F0F4FF;
    }
    .dark-mode .modern-checkbox {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .dark-mode .modern-checkbox:hover {
        border-color: #C1D82F;
        background: #3B3B3B;
    }
    .modern-checkbox input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #0077C8;
        border-radius: 4px;
        background: #FFFFFF;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .modern-checkbox input[type="checkbox"]:checked {
        background: #0077C8;
        border-color: #0077C8;
    }
    .dark-mode .modern-checkbox input[type="checkbox"] {
        background: #2D2D2D;
        border-color: #F0F0F0;
    }
    .dark-mode .modern-checkbox input[type="checkbox"]:checked {
        background: #C1D82F;
        border-color: #C1D82F;
    }

    /* Buttons */
    .modern-btn {
        background: #0077C8;
        border: none;
        color: #F0F0F0;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .modern-btn:hover {
        background: #C1D82F;
        color: #333333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193, 216, 47, 0.3);
    }
    .modern-btn-secondary {
        background: #6C757D;
        color: #F0F0F0;
        border: 1px solid #E9ECEF;
    }
    .modern-btn-secondary:hover {
        background: #C1D82F;
        color: #333333;
        box-shadow: 0 4px 12px rgba(193, 216, 47, 0.3);
    }
    .dark-mode .modern-btn-secondary {
        background: #4A4A4A;
        border-color: #4A4A4A;
    }

    /* Invalid Feedback */
    .invalid-feedback {
        font-family: 'Poppins', sans-serif;
        color: #E53935;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        font-weight: 600;
    }

    /* User Avatar */
    .user-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #0077C8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F0F0F0;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 6px 16px rgba(0, 119, 200, 0.3);
    }
    .dark-mode .user-avatar-large {
        background: #005B99;
    }

    /* Password Help */
    .password-help {
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        color: #6C757D;
        margin-top: 0.25rem;
    }
    .dark-mode .password-help {
        color: #A0AEC0;
    }

    /* Focused Effect */
    .focused .modern-input,
    .focused .modern-select {
        border-color: #C1D82F;
        box-shadow: 0 0 0 0.2rem rgba(193, 216, 47, 0.25);
        transform: translateY(-1px);
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .modern-page-header {
            padding: 1.5rem 0;
            margin: -1rem -1rem 1.5rem;
        }
        .modern-page-header h1 {
            font-size: 1.5rem;
        }
        .user-avatar-large {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }
        .modern-form-group {
            margin-bottom: 1rem;
        }
        .modern-input, .modern-select {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="modern-page-header">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>{{ __('users.edit_user') }}</h1>
                <p>{{ __('users.edit_user_description') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('users.back_to_users') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="card-body p-4">
                <!-- User Avatar -->
                <div class="text-center mb-4">
                    @php $userImg = $user->image_url ?? null; @endphp
                    @if($userImg)
                        <img src="{{ asset($userImg) }}" alt="{{ $user->name }}" class="user-avatar-large rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="user-avatar-large bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="name" class="modern-label">
                                    {{ __('users.name') }} <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="modern-input @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}" 
                                    required
                                    placeholder="{{ __('users.name_placeholder') }}"
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="email" class="modern-label">
                                    {{ __('users.email') }} <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    class="modern-input @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                    placeholder="{{ __('users.email_placeholder') }}"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="password" class="modern-label">
                                    {{ __('users.new_password') }}
                                </label>
                                <input 
                                    type="password" 
                                    class="modern-input @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password"
                                    placeholder="{{ __('users.new_password_placeholder') }}"
                                >
                                <small class="password-help">{{ __('users.password_help') }}</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="password_confirmation" class="modern-label">
                                    {{ __('users.confirm_password') }}
                                </label>
                                <input 
                                    type="password" 
                                    class="modern-input" 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    placeholder="{{ __('users.confirm_password_placeholder') }}"
                                >
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="role" class="modern-label">
                                    {{ __('users.role') }} <span class="text-danger">*</span>
                                </label>
                                <select class="modern-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">{{ __('users.select_role') }}</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        {{ __('users.admin') }}
                                    </option>
                                    <option value="employee" {{ old('role', $user->role) === 'employee' ? 'selected' : '' }}>
                                        {{ __('users.employee') }}
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-label">{{ __('users.account_status') }}</label>
                                <div class="modern-checkbox">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_verified" 
                                        name="is_verified" 
                                        {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="is_verified">
                                        <strong>{{ __('users.account_verified') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ __('users.account_verified_description') }}</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                                    <i class="fas fa-times"></i>
                                    {{ __('users.cancel') }}
                                </a>
                                <button type="submit" class="modern-btn">
                                    <i class="fas fa-save"></i>
                                    {{ __('users.update_user') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('editUserForm');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    form.addEventListener('submit', function(e) {
        if (passwordField.value && passwordField.value !== confirmPasswordField.value) {
            e.preventDefault();
            alert('{{ __('users.passwords_do_not_match') }}');
            confirmPasswordField.focus();
        }
    });
    
    // Password confirmation validation
    confirmPasswordField.addEventListener('input', function() {
        if (passwordField.value && this.value && passwordField.value !== this.value) {
            this.setCustomValidity('{{ __('users.passwords_do_not_match') }}');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Enhanced focus effects
    const inputs = document.querySelectorAll('.modern-input, .modern-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
});
</script>
@endpush
@endsection