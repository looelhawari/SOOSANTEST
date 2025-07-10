@extends('layouts.public')

@section('title', __('common.serial_lookup_title') . ' - Soosan Cebotics')
@section('description', __('common.serial_lookup_subtitle'))

@push('meta')
<meta name="keywords" content="serial lookup, warranty check, equipment coverage, Soosan Cebotics, drilling equipment">
<meta property="og:title" content="{{ __('common.serial_lookup_title') }} - Soosan Cebotics">
<meta property="og:description" content="{{ __('common.serial_lookup_subtitle') }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary">
<meta name="robots" content="index, follow">
@endpush

@section('page-header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <h1 class="display-6 fw-bold text-dark mb-0">{{ __('common.serial_lookup_title') }}</h1>
        <div class="d-flex align-items-center gap-2 text-muted">
            <i class="fas fa-search"></i>
            <span>{{ __('common.check_coverage') }}</span>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .lookup-form {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
    }

    .serial-input {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 18px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .serial-input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .lookup-btn {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        border-radius: 10px;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .lookup-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e9ecef;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        font-size: 18px;
    }

    .sample-serials {
        background: #e3f2fd;
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid #007bff;
    }

    .sample-serial {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
        margin: 5px;
        display: inline-block;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Courier New', monospace;
        font-weight: 500;
    }

    .sample-serial:hover {
        background: #007bff;
        color: white;
        transform: translateY(-1px);
    }

    .loading-spinner {
        display: none;
    }

    .loading .loading-spinner {
        display: inline-block;
    }

    .loading .btn-text {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Main Lookup Form -->
                <div class="lookup-form p-4 p-md-5 mb-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-search text-primary mb-3" style="font-size: 3rem;"></i>
                        <h2 class="h3 fw-bold text-dark mb-3">{{ __('common.equipment_serial_lookup') }}</h2>
                        <p class="text-muted">{{ __('common.equipment_serial_lookup_desc') }}</p>
                    </div>

                    <form action="{{ route('serial-lookup.lookup') }}" method="POST" id="serialForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="serial_number" class="form-label fw-semibold">{{ __('common.serial_number') }}</label>
                            <input type="text" 
                                   class="form-control serial-input @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" 
                                   name="serial_number" 
                                   value="{{ old('serial_number') }}" 
                                   placeholder="{{ __('common.enter_equipment_serial') }}"
                                   required
                                   autocomplete="off">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ __('common.serial_found_location') }}
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn lookup-btn" id="lookupBtn">
                                <span class="btn-text">
                                    <i class="fas fa-search me-2"></i>
                                    {{ __('common.check_coverage') }}
                                </span>
                                <span class="loading-spinner">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    {{ __('common.searching') }}
                                </span>
                            </button>
                        </div>
                    </form>

                    @if($errors->any() || session('error'))
                        <div class="alert alert-danger mt-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') ?? $errors->first() }}
                        </div>
                    @endif
                </div>

                <!-- Sample Serials -->
                <div class="sample-serials mb-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2"></i>
                        {{ __('common.try_sample_serials') }}
                    </h6>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="sample-serial" onclick="fillSerial('2231')">2231</span>
                        <span class="sample-serial" onclick="fillSerial('TEST123')">TEST123</span>
                        <span class="sample-serial" onclick="fillSerial('HD1200-2025-001')">HD1200-2025-001</span>
                    </div>
                </div>

                <!-- Information Cards -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card h-100">
                            <h5 class="fw-bold mb-3 text-primary">
                                <i class="fas fa-shield-check me-2"></i>
                                {{ __('common.what_youll_get') }}
                            </h5>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <strong>{{ __('common.warranty_status') }}</strong><br>
                                    <small class="text-muted">{{ __('common.warranty_status_desc') }}</small>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <strong>{{ __('common.technical_specifications') }}</strong><br>
                                    <small class="text-muted">{{ __('common.technical_specifications_desc') }}</small>
                                </div>
                            </div>
                            <div class="feature-item mb-0">
                                <div class="feature-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div>
                                    <strong>{{ __('common.owner_information') }}</strong><br>
                                    <small class="text-muted">{{ __('common.owner_information_desc') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card h-100">
                            <h5 class="fw-bold mb-3 text-success">
                                <i class="fas fa-headset me-2"></i>
                                {{ __('common.need_help') }}
                            </h5>
                            <p class="mb-3">{{ __('common.need_help_desc') }}</p>
                            <div class="d-grid gap-2">
                                <a href="mailto:support@soosanegypt.com" class="btn btn-outline-primary">
                                    <i class="fas fa-envelope me-2"></i>
                                    {{ __('common.email_support') }}
                                </a>
                                <a href="tel:+201000000000" class="btn btn-outline-success">
                                    <i class="fas fa-phone me-2"></i>
                                    {{ __('common.call_support') }}
                                </a>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-clock me-1"></i>
                                {{ __('common.support_hours') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fillSerial(serial) {
    document.getElementById('serial_number').value = serial;
    document.getElementById('serial_number').focus();
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('serialForm');
    const btn = document.getElementById('lookupBtn');
    
    form.addEventListener('submit', function() {
        btn.classList.add('loading');
        btn.disabled = true;
    });

    // Add input validation feedback
    const serialInput = document.getElementById('serial_number');
    serialInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z0-9\-_]/g, '');
        
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });

    // Auto-focus on serial input
    serialInput.focus();
});
</script>
@endpush
