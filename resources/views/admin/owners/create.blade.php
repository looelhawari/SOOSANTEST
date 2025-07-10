@extends('layouts.admin')

@section('title', __('owners.create_owner'))

@section('content')
<style>
/* Reset and prevent inheritance from global styles */
.owners-create-container * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.owners-create-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem;
    color: #1f2937;
    line-height: 1.6;
}

/* Modern Header */
.owners-create-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin: -2rem -2rem 2rem -2rem;
    border-radius: 0 0 1.5rem 1.5rem;
    position: relative;
    overflow: hidden;
}

.owners-create-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.owners-create-header-content {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.owners-create-title-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.owners-create-title-section p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.owners-back-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 1rem 2rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.owners-back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    color: white;
    border-color: rgba(255, 255, 255, 0.5);
}

/* Form Card */
.owners-form-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.owners-form-header {
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.owners-form-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.owners-form-header i {
    color: #667eea;
    font-size: 1.25rem;
}

.owners-form-body {
    padding: 2rem;
}

.owners-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.owners-form-group {
    display: flex;
    flex-direction: column;
}

.owners-form-group label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.owners-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: white;
}

.owners-form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.owners-form-control.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.owners-invalid-feedback {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    font-weight: 500;
}

.owners-form-section {
    background: #f8fafc;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid #667eea;
}

.owners-form-section h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.owners-form-section i {
    color: #667eea;
}

.owners-form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding: 2rem;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    margin: 0 -2rem -2rem -2rem;
}

.owners-btn {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.owners-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.owners-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    color: white;
}

.owners-btn.secondary {
    background: #6b7280;
    color: white;
}

.owners-btn.secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    color: white;
}

/* Required asterisk */
.owners-required {
    color: #ef4444;
    margin-left: 0.25rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .owners-create-container {
        padding: 1rem;
    }
    
    .owners-create-header {
        margin: -1rem -1rem 2rem -1rem;
        padding: 2rem 0;
    }
    
    .owners-create-header-content {
        flex-direction: column;
        text-align: center;
        padding: 0 1rem;
    }
    
    .owners-create-title-section h1 {
        font-size: 2rem;
    }
    
    .owners-form-grid {
        grid-template-columns: 1fr;
    }
    
    .owners-form-actions {
        flex-direction: column;
    }
}
</style>

<div class="owners-create-container">
    <!-- Page Header -->
    <div class="owners-create-header">
        <div class="owners-create-header-content">
            <div class="owners-create-title-section">
                <h1><i class="fas fa-user-plus"></i> {{ __('owners.create_new_owner') }}</h1>
                <p>{{ __('owners.add_new_owner') }}</p>
            </div>
            <a href="{{ route('admin.owners.index') }}" class="owners-back-btn">
                <i class="fas fa-arrow-left"></i>
                {{ __('owners.back_to_owners') }}
            </a>
        </div>
    </div>
    <!-- Owner Form -->
    <div class="owners-form-card">
        <div class="owners-form-header">
            <h2><i class="fas fa-user-edit"></i> {{ __('owners.owner_information') }}</h2>
        </div>
        
        <form action="{{ route('admin.owners.store') }}" method="POST">
            @csrf
            
            <div class="owners-form-body">
                <!-- Basic Information Section -->
                <div class="owners-form-section">
                    <h3><i class="fas fa-user"></i> {{ __('owners.basic_information') }}</h3>
                    <div class="owners-form-grid">
                        <div class="owners-form-group">
                            <label for="name">{{ __('owners.name') }} <span class="owners-required">{{ __('owners.required') }}</span></label>
                            <input type="text" 
                                   class="owners-form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="{{ __('owners.enter_name') }}"
                                   required>
                            @error('name')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="owners-form-group">
                            <label for="email">{{ __('owners.email') }}</label>
                            <input type="email" 
                                   class="owners-form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="{{ __('owners.enter_email') }}"
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="owners-form-section">
                    <h3><i class="fas fa-address-book"></i> {{ __('owners.contact_information') }}</h3>
                    <div class="owners-form-grid">
                        <div class="owners-form-group">
                            <label for="phone_number">{{ __('owners.phone') }}</label>
                            <input type="text" 
                                   class="owners-form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" 
                                   name="phone_number" 
                                   value="{{ old('phone_number') }}"
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
                                   placeholder="{{ __('owners.enter_company') }}"
                                   value="{{ old('company') }}">
                            @error('company')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location Information Section -->
                <div class="owners-form-section">
                    <h3><i class="fas fa-map-marker-alt"></i> {{ __('owners.location_information') }}</h3>
                    <div class="owners-form-grid">
                        <div class="owners-form-group">
                            <label for="address">{{ __('owners.address') }}</label>
                            <textarea class="owners-form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      placeholder="{{ __('owners.enter_address') }}"
                                      rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="owners-form-group">
                            <label for="city">{{ __('owners.city') }}</label>
                            <input type="text" 
                                   class="owners-form-control @error('city') is-invalid @enderror" 
                                   id="city" 
                                   name="city" 
                                   placeholder="{{ __('owners.enter_city') }}"
                                   value="{{ old('city') }}">
                            @error('city')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="owners-form-group">
                            <label for="country">{{ __('owners.country') }}</label>
                            <input type="text" 
                                   class="owners-form-control @error('country') is-invalid @enderror" 
                                   id="country" 
                                   name="country" 
                                   placeholder="{{ __('owners.enter_country') }}"
                                   value="{{ old('country') }}">
                            @error('country')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Preferences Section -->
                <div class="owners-form-section">
                    <h3><i class="fas fa-cog"></i> {{ __('owners.preferences') }}</h3>
                    <div class="owners-form-grid">
                        <div class="owners-form-group">
                            <label for="preferred_language">{{ __('owners.preferred_language') }}</label>
                            <select class="owners-form-control @error('preferred_language') is-invalid @enderror" 
                                    id="preferred_language" 
                                    name="preferred_language">
                                <option value="">{{ __('owners.select_language') }}</option>
                                <option value="en" {{ old('preferred_language') == 'en' ? 'selected' : '' }}>{{ __('owners.english') }}</option>
                                <option value="ar" {{ old('preferred_language') == 'ar' ? 'selected' : '' }}>{{ __('owners.arabic') }}</option>
                                <option value="es" {{ old('preferred_language') == 'es' ? 'selected' : '' }}>{{ __('owners.spanish') }}</option>
                                <option value="fr" {{ old('preferred_language') == 'fr' ? 'selected' : '' }}>{{ __('owners.french') }}</option>
                                <option value="de" {{ old('preferred_language') == 'de' ? 'selected' : '' }}>{{ __('owners.german') }}</option>
                                <option value="zh" {{ old('preferred_language') == 'zh' ? 'selected' : '' }}>{{ __('owners.chinese') }}</option>
                                <option value="ja" {{ old('preferred_language') == 'ja' ? 'selected' : '' }}>{{ __('owners.japanese') }}</option>
                                <option value="ru" {{ old('preferred_language') == 'ru' ? 'selected' : '' }}>{{ __('owners.russian') }}</option>
                            </select>
                            @error('preferred_language')
                                <div class="owners-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="owners-form-actions">
                <a href="{{ route('admin.owners.index') }}" class="owners-btn secondary">
                    <i class="fas fa-times"></i>
                    {{ __('owners.cancel') }}
                </a>
                <button type="submit" class="owners-btn primary">
                    <i class="fas fa-save"></i>
                    {{ __('owners.create_owner') }}
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
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('owners.creating') }}';
    });

    // Auto-focus first input
    const firstInput = document.querySelector('#name');
    if (firstInput) {
        firstInput.focus();
    }
});
</script>
@endsection
