@extends('layouts.public')

@section('title', __('common.profile_settings') . ' - SoosanEgypt')
@section('description', __('common.profile_settings_desc'))

@section('page-header')
<div class="d-flex align-items-center">
    <div class="bg-primary text-white rounded-circle p-3 me-4 shadow" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-user-circle" style="font-size: 1.8rem;"></i>
    </div>
    <div>
        <h1 class="h2 mb-1 text-dark fw-bold">{{ __('common.profile_settings') }}</h1>
        <p class="text-muted mb-0 fs-6">{{ __('common.profile_settings_desc') }}</p>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .profile-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }
    
    .profile-section-header {
        background: linear-gradient(135deg, var(--background-color), #ffffff);
        padding: 2rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        position: relative;
    }
    
    .profile-section-header::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
    }
    
    .profile-section-header h3 {
        margin: 0;
        color: var(--text-color);
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }
    
    .profile-section-header p {
        margin: 0.5rem 0 0;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .profile-section-body {
        padding: 2.5rem;
        background: #fafbfc;
    }
    
    .profile-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.25rem;
        font-size: 1.3rem;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }
    
    .profile-icon.success {
        background: linear-gradient(135deg, var(--accent-color), #22c55e);
        box-shadow: 0 4px 15px rgba(74, 222, 128, 0.3);
    }
    
    .profile-icon.danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .input-group-text {
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .form-control {
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .input-group:focus-within .input-group-text {
        border-color: var(--primary-color);
        background: rgba(37, 99, 235, 0.05);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
    }
    
    .btn-success {
        background: linear-gradient(135deg, var(--accent-color), #22c55e);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(74, 222, 128, 0.4);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
    }
    
    /* RTL specific fixes for icons and spacing */
    [dir="rtl"] .profile-icon {
        margin-left: 1.25rem;
        margin-right: 0;
    }
    
    [dir="rtl"] .text-success .bg-success,
    [dir="rtl"] .text-success .text-success {
        margin-left: 0.5rem;
        margin-right: 0;
    }
    
    /* Ensure status messages don't overlap */
    .status-message {
        min-height: 40px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
    }
</style>
@endpush

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <!-- Profile Information Section -->
                <div class="profile-section">
                    <div class="profile-section-header">
                        <div class="d-flex align-items-center">
                            <div class="profile-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h3>{{ __('common.profile_information') }}</h3>
                                <p>{{ __('common.profile_information_desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-section-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Section -->
                <div class="profile-section">
                    <div class="profile-section-header">
                        <div class="d-flex align-items-center">
                            <div class="profile-icon success">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h3>{{ __('common.update_password') }}</h3>
                                <p>{{ __('common.update_password_desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-section-body">
                        @if (session('status') === 'password-updated')
                            <div class="text-success fw-bold status-message mb-3">
                                <div class="bg-success text-white rounded-circle p-1 status-icon d-flex align-items-center justify-content-center">
                                    <i class="fas fa-check" style="font-size: 0.8rem;"></i>
                                </div>
                                <span>{{ __('common.password_updated_successfully') }}</span>
                            </div>
                        @endif
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="profile-section">
                    <div class="profile-section-header">
                        <div class="d-flex align-items-center">
                            <div class="profile-icon danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h3>{{ __('common.delete_account') }}</h3>
                                <p>{{ __('common.delete_account_desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-section-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('profile_image');
    const imagePreview = document.getElementById('profileImagePreview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, JPG, GIF, WEBP)');
                    this.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Function to confirm image removal
function confirmRemoveImage() {
    if (confirm('{{ __('common.are_you_sure_remove_photo') }}')) {
        document.getElementById('removeImageForm').submit();
    }
}
</script>
@endpush
@endsection
