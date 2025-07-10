@extends('layouts.admin')

@section('title', __('owners.edit_owner'))

@section('content')
<style>
/* Reset and prevent inheritance from global styles */
.owners-edit-container * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.owners-edit-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem;
    color: #1f2937;
    line-height: 1.6;
}

.owners-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.owners-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.owners-header p {
    opacity: 0.9;
    font-size: 1.1rem;
    margin: 0;
}

.owners-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.owners-form {
    padding: 2rem;
}

.owners-form-group {
    margin-bottom: 1.5rem;
}

.owners-form-group:last-child {
    margin-bottom: 0;
}

.owners-form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #374151;
    font-size: 0.875rem;
    letter-spacing: 0.025em;
}

.owners-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    background-color: #fff;
    color: #1f2937;
    transition: all 0.2s ease;
    font-family: inherit;
}

.owners-form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background-color: #fff;
}

.owners-form-control.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.owners-invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
}

.owners-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .owners-form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

.owners-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
    margin-top: 2rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid transparent;
}

.alert-success {
    background-color: #ecfdf5;
    border-color: #a7f3d0;
    color: #065f46;
}

.alert-danger {
    background-color: #fef2f2;
    border-color: #fecaca;
    color: #991b1b;
}

.alert ul {
    margin: 0;
    padding-left: 1.25rem;
}

.alert li {
    margin-bottom: 0.25rem;
}

/* Form textarea styles */
.owners-form-control[rows] {
    resize: vertical;
    min-height: 100px;
}

/* Select dropdown styles */
select.owners-form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}
</style>

<div class="owners-edit-container">
    <div class="owners-header">
        <h1>
            <i class="fas fa-user-edit"></i>
            {{ __('owners.edit_owner') }}
        </h1>
        <p>{{ __('owners.update_owner_info_system') }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="owners-card">
        <form method="POST" action="{{ route('admin.owners.update', $owner) }}" class="owners-form">
            @csrf
            @method('PUT')
            
            <div class="owners-form-row">
                <div class="owners-form-group">
                    <label for="name">{{ __('owners.full_name') }} <span style="color: #ef4444;">{{ __('owners.required') }}</span></label>
                    <input type="text" 
                           class="owners-form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $owner->name) }}"
                           required
                           placeholder="{{ __('owners.enter_full_name') }}">
                    @error('name')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="owners-form-group">
                    <label for="email">{{ __('owners.email_address') }} <span style="color: #ef4444;">{{ __('owners.required') }}</span></label>
                    <input type="email" 
                           class="owners-form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $owner->email) }}"
                           required
                           placeholder="{{ __('owners.enter_email_example') }}">
                    @error('email')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="owners-form-row">
                <div class="owners-form-group">
                    <label for="phone_number">{{ __('owners.phone_number') }}</label>
                    <input type="text" 
                           class="owners-form-control @error('phone_number') is-invalid @enderror" 
                           id="phone_number" 
                           name="phone_number" 
                           value="{{ old('phone_number', $owner->phone_number) }}"
                           placeholder="{{ __('owners.enter_phone') }}">
                    @error('phone_number')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="owners-form-group">
                    <label for="company">{{ __('owners.company') }}</label>
                    <input type="text" 
                           class="owners-form-control @error('company') is-invalid @enderror" 
                           id="company" 
                           name="company" 
                           value="{{ old('company', $owner->company) }}"
                           placeholder="{{ __('owners.company_name_placeholder') }}">
                    @error('company')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="owners-form-group">
                <label for="address">{{ __('owners.address') }}</label>
                <textarea class="owners-form-control @error('address') is-invalid @enderror" 
                          id="address" 
                          name="address" 
                          rows="3" 
                          placeholder="{{ __('owners.full_street_address') }}">{{ old('address', $owner->address) }}</textarea>
                @error('address')
                    <div class="owners-invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="owners-form-row">
                <div class="owners-form-group">
                    <label for="city">{{ __('owners.city') }}</label>
                    <input type="text" 
                           class="owners-form-control @error('city') is-invalid @enderror" 
                           id="city" 
                           name="city" 
                           value="{{ old('city', $owner->city) }}"
                           placeholder="{{ __('owners.city_name_placeholder') }}">
                    @error('city')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="owners-form-group">
                    <label for="state">{{ __('owners.state_province') }}</label>
                    <input type="text" 
                           class="owners-form-control @error('state') is-invalid @enderror" 
                           id="state" 
                           name="state" 
                           value="{{ old('state', $owner->state) }}"
                           placeholder="{{ __('owners.state_province_placeholder') }}">
                    @error('state')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="owners-form-row">
                <div class="owners-form-group">
                    <label for="postal_code">{{ __('owners.postal_code') }}</label>
                    <input type="text" 
                           class="owners-form-control @error('postal_code') is-invalid @enderror" 
                           id="postal_code" 
                           name="postal_code" 
                           value="{{ old('postal_code', $owner->postal_code) }}"
                           placeholder="{{ __('owners.postal_code_placeholder') }}">
                    @error('postal_code')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="owners-form-group">
                    <label for="country">{{ __('owners.country') }}</label>
                    <input type="text" 
                           class="owners-form-control @error('country') is-invalid @enderror" 
                           id="country" 
                           name="country" 
                           value="{{ old('country', $owner->country) }}"
                           placeholder="{{ __('owners.country_placeholder') }}">
                    @error('country')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="owners-form-row">
                <div class="owners-form-group">
                    <label for="preferred_language">{{ __('owners.preferred_language') }}</label>
                    <select class="owners-form-control @error('preferred_language') is-invalid @enderror" 
                            id="preferred_language" 
                            name="preferred_language">
                        <option value="">{{ __('owners.select_language') }}</option>
                        <option value="en" {{ old('preferred_language', $owner->preferred_language) == 'en' ? 'selected' : '' }}>{{ __('owners.english') }}</option>
                        <option value="ar" {{ old('preferred_language', $owner->preferred_language) == 'ar' ? 'selected' : '' }}>{{ __('owners.arabic') }}</option>
                      
                    </select>
                    @error('preferred_language')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="owners-form-group">
                    <label for="status">{{ __('owners.status') }}</label>
                    <select class="owners-form-control @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status">
                        <option value="active" {{ old('status', $owner->status) == 'active' ? 'selected' : '' }}>{{ __('owners.active') }}</option>
                        <option value="inactive" {{ old('status', $owner->status) == 'inactive' ? 'selected' : '' }}>{{ __('owners.inactive') }}</option>
                    </select>
                    @error('status')
                        <div class="owners-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="owners-form-actions">
                <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('owners.back_to_owners') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    {{ __('owners.update_owner') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('owners.updating') }}';
    });

    // Auto-focus first input
    const firstInput = document.querySelector('#name');
    if (firstInput) {
        firstInput.focus();
        firstInput.select();
    }
});
</script>
@endsection
