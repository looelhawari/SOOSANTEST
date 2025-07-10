<form method="post" action="{{ route('profile.password.update') }}" class="needs-validation" novalidate autocomplete="off">
    @csrf
    @method('patch')
    <div class="mb-4">
        <label for="current_password" class="form-label fw-bold text-dark">
            <i class="fas fa-lock text-primary me-2"></i>{{ __('common.current_password') }}
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-muted"></i>
            </span>
            <input type="password" id="current_password" name="current_password" class="form-control border-start-0 @error('current_password') is-invalid @enderror" required autocomplete="current-password" minlength="8">
        </div>
        @error('current_password')
            <div class="invalid-feedback d-block mt-1">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-4">
        <label for="password" class="form-label fw-bold text-dark">
            <i class="fas fa-key text-primary me-2"></i>{{ __('common.new_password') }}
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-key text-muted"></i>
            </span>
            <input type="password" id="password" name="password" class="form-control border-start-0 @error('password') is-invalid @enderror" required minlength="8" autocomplete="new-password">
        </div>
        @error('password')
            <div class="invalid-feedback d-block mt-1">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-bold text-dark">
            <i class="fas fa-key text-primary me-2"></i>{{ __('common.confirm_password') }}
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-key text-muted"></i>
            </span>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror" required minlength="8" autocomplete="new-password">
        </div>
        @error('password_confirmation')
            <div class="invalid-feedback d-block mt-1">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="d-flex justify-content-end align-items-center pt-3 border-top">
        <button type="submit" class="btn btn-success btn-lg px-4 fw-semibold shadow-sm">
            <i class="fas fa-save me-2"></i>{{ __('common.update_password_btn') }}
        </button>
    </div>
</form>
