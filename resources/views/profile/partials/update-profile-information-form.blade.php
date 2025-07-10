<form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="row mb-4">
        <div class="col-12 text-center mb-3">
            <div class="position-relative d-inline-block">
                <img id="profileImagePreview" 
                     src="{{ $user->image_url ? asset($user->image_url) : asset('images/fallback.webp') }}" 
                     alt="Profile Image" 
                     class="rounded-circle shadow" 
                     style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--primary-color); background: #fff;"
                     onerror="this.onerror=null;this.src='{{ asset('images/fallback.webp') }}';">
                
                <!-- Image Upload Button -->
                <div class="position-absolute" style="bottom: 5px; right: 5px;">
                    <label for="profile_image" class="btn btn-primary btn-sm rounded-circle p-2" style="width: 40px; height: 40px; cursor: pointer;">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" 
                           id="profile_image" 
                           name="profile_image" 
                           class="d-none @error('profile_image') is-invalid @enderror" 
                           accept="image/*">
                </div>
            </div>
            
            <!-- Image Actions -->
            <div class="mt-3">
                @if($user->image_url)
                    <button type="button" class="btn btn-outline-danger btn-sm me-2" onclick="document.getElementById('removeImageForm').submit();">
                        <i class="fas fa-trash me-1"></i>{{ __('common.remove_photo') }}
                    </button>
                @endif
                <small class="text-muted d-block mt-2">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('common.supported_formats') }}
                </small>
            </div>
            
            @error('profile_image')
                <div class="alert alert-danger mt-2 p-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="name" class="form-label fw-bold text-dark">
                <i class="fas fa-user text-primary me-2"></i>{{ __('common.full_name') }}
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-user text-muted"></i>
                </span>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-control border-start-0 @error('name') is-invalid @enderror" 
                       value="{{ old('name', $user->name) }}" 
                       required 
                       autocomplete="name"
                       style="padding-left: 0;">
                @error('name')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="email" class="form-label fw-bold text-dark">
                <i class="fas fa-envelope text-primary me-2"></i>{{ __('common.email_address') }}
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-envelope text-muted"></i>
                </span>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                       value="{{ old('email', $user->email) }}" 
                       required 
                       autocomplete="username"
                       style="padding-left: 0;">
                @error('email')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="phone_number" class="form-label fw-bold text-dark">
                <i class="fas fa-phone text-primary me-2"></i>{{ __('common.phone_number') }}
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-phone text-muted"></i>
                </span>
                <input type="text"
                       id="phone_number"
                       name="phone_number"
                       class="form-control border-start-0 @error('phone_number') is-invalid @enderror"
                       value="{{ old('phone_number', $user->phone_number) }}"
                       maxlength="50"
                       autocomplete="tel"
                       style="padding-left: 0;">
                @error('phone_number')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <label class="form-label fw-bold text-dark">
                <i class="fas fa-user-tag text-primary me-2"></i>{{ __('common.role') }}
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-user-tag text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" value="{{ ucfirst($user->role) }}" readonly tabindex="-1" style="background: #f5f5f5;">
            </div>
        </div>
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="alert alert-warning border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #fff3cd, #ffeaa7);">
            <div class="d-flex align-items-center">
                <div class="bg-warning text-white rounded-circle p-2 {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold text-dark">{{ __('common.email_verification_required') }}</h6>
                    <p class="mb-2 text-dark">{{ __('common.email_verification_desc') }}</p>
                    <button form="send-verification" class="btn btn-warning btn-sm fw-semibold">
                        <i class="fas fa-paper-plane me-2"></i>{{ __('common.send_verification_email') }}
                    </button>
                </div>
            </div>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #d4edda, #c3e6cb);">
                <div class="d-flex align-items-center">
                    <div class="text-success {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}" style="flex-shrink: 0;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">{{ __('common.verification_email_sent') }}</h6>
                        <p class="mb-0 text-dark">{{ __('common.verification_email_sent_desc') }}</p>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
        <div class="status-message">
            @if (session('status') === 'profile-updated')
                <div class="text-success fw-bold status-message">
                    <div class="bg-success text-white rounded-circle p-1 status-icon d-flex align-items-center justify-content-center">
                        <i class="fas fa-check" style="font-size: 0.8rem;"></i>
                    </div>
                    <span>{{ __('common.profile_updated_successfully') }}</span>
                </div>
            @elseif (session('status') === 'image-removed')
                <div class="text-success fw-bold status-message">
                    <div class="bg-success text-white rounded-circle p-1 status-icon d-flex align-items-center justify-content-center">
                        <i class="fas fa-check" style="font-size: 0.8rem;"></i>
                    </div>
                    <span>{{ __('common.profile_photo_removed_successfully') }}</span>
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary btn-lg px-4 fw-semibold shadow-sm">
            <i class="fas fa-save me-2"></i>{{ __('common.save_changes') }}
        </button>
    </div>

    @if ($errors->has('profile_error'))
        <div class="alert alert-danger mt-2">{{ $errors->first('profile_error') }}</div>
    @endif
</form>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
        @csrf
    </form>
@endif

@if($user->image_url)
<form method="post" action="{{ route('profile.remove-image') }}" id="removeImageForm" style="display:none;">
    @csrf
    @method('delete')
</form>
@endif
