@extends('layouts.public')

@section('title', __('common.get_in_touch') . ' - Soosan Cebotics')
@section('description', __('common.get_in_touch') . ' - ' . __('common.ready_to_transform'))

@push('styles')
<style>
    /* Modern Contact Page Styles */
    .contact-hero {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #1e3a8a 100%);
        color: white;
        padding: 6rem 0 4rem;
        position: relative;
        overflow: hidden;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-stats {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
    }

    .stat-item {
        text-align: center;
        position: relative;
    }

    .stat-item::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .stat-item:last-child::after {
        display: none;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
        background: linear-gradient(45deg, #fbbf24, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Contact Methods Grid */
    .contact-methods {
        padding: 5rem 0 3rem;
        background: linear-gradient(to bottom, #f8fafc, #ffffff);
    }

    .contact-method-card {
        background: white;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .contact-method-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .contact-method-card:hover::before {
        transform: scaleX(1);
    }

    .contact-method-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 48px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .method-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
        transition: all 0.4s ease;
    }

    .contact-method-card:hover .method-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 32px rgba(37, 99, 235, 0.35);
    }

    .method-action {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .method-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        color: white;
    }

    /* Contact Form Section */
    .contact-form-section {
        padding: 4rem 0;
        background: white;
    }

    .contact-form-container {
        background: white;
        border-radius: 24px;
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        padding: 3rem 3rem 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    }

    .form-body {
        padding: 3rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: white;
        transform: translateY(-1px);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    /* Department Cards */
    .departments-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .department-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
    }

    .department-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .dept-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
    }

    /* FAQ Section */
    .faq-section {
        padding: 4rem 0;
        background: white;
    }

    .faq-item {
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .faq-question {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        display: flex;
        justify-content: between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        background: rgba(37, 99, 235, 0.05);
    }

    .faq-answer {
        padding: 0 1.5rem 1.25rem;
        color: #6b7280;
        line-height: 1.6;
        display: none;
    }

    .faq-answer.active {
        display: block;
        animation: fadeInDown 0.3s ease;
    }

    /* Floating Elements */
    .floating-contact {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
    }

    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        animation: pulse 2s infinite;
    }

    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 32px rgba(16, 185, 129, 0.5);
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .contact-hero {
            padding: 4rem 0 3rem;
        }
        
        .hero-stats {
            margin-top: 2rem;
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .contact-methods {
            padding: 3rem 0 2rem;
        }
        
        .contact-method-card {
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-header,
        .form-body {
            padding: 2rem 1.5rem;
        }
        
        .floating-contact {
            bottom: 1rem;
            right: 1rem;
        }
        
        .floating-btn {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Modern Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="hero-content text-center">
                        <h1 class="display-3 fw-bold mb-4">
                            {{ __('common.get_in_touch') }}
                        </h1>
                        <p class="fs-4 mb-4 opacity-90">
                            {{ __('common.ready_to_transform') }}
                        </p>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center mb-4">
                            <a href="#contact-form" class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('common.send_message') }}
                            </a>
                            <a href="tel:+1234567890" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="fas fa-phone me-2"></i>{{ __('common.call_now') }}
                            </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="hero-stats">
                            <div class="row g-4">
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">24/7</span>
                                        <span class="fw-semibold">{{ __('common.support') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">500+</span>
                                        <span class="fw-semibold">{{ __('common.projects') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">50+</span>
                                        <span class="fw-semibold">{{ __('common.countries') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">15+</span>
                                        <span class="fw-semibold">{{ __('common.years') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Methods -->
    <section class="contact-methods">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">{{ __('common.multiple_ways_to_reach_us') }}</h2>
                    <p class="fs-5 text-muted">{{ __('common.choose_contact_method') }}</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card text-center">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.call_us') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.speak_directly_with_experts') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">+1 (555) 123-4567</strong>
                            <small class="text-muted">{{ __('common.emergency_support') }}</small>
                        </div>
                        <a href="tel:+15551234567" class="method-action">
                            <i class="fas fa-phone me-2"></i>{{ __('common.call_now') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card text-center">
                        <div class="method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.email_us') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.send_detailed_inquiries') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">info@soosancebotics.com</strong>
                            <small class="text-muted">{{ __('common.response_within_24_hours') }}</small>
                        </div>
                        <a href="mailto:info@soosancebotics.com" class="method-action">
                            <i class="fas fa-envelope me-2"></i>{{ __('common.send_email') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card text-center">
                        <div class="method-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.whatsapp') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.quick_messaging') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">+1 (555) 123-4567</strong>
                            <small class="text-muted">{{ __('common.mon_fri_8am_6pm') }}</small>
                        </div>
                        <a href="https://wa.me/15551234567" class="method-action" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>{{ __('common.chat_now') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card text-center">
                        <div class="method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.visit_us') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.come_see_showroom') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">{{ __('common.industrial_district') }}</strong>
                            <small class="text-muted">{{ __('common.main_street_city') }}</small>
                        </div>
                        <a href="#location-map" class="method-action">
                            <i class="fas fa-directions me-2"></i>{{ __('common.get_directions') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="contact-form-section" id="contact-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-form-container">
                        <div class="form-header">
                            <h2 class="display-6 fw-bold mb-3">{{ __('common.send_us_a_message') }}</h2>
                            <p class="fs-5 text-muted mb-0">{{ __('common.fill_out_form_24_hours') }}</p>
                        </div>
                        <div class="form-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ __('common.contact_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">
                                                {{ __('common.first_name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="first_name" name="first_name" required
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name') }}"
                                                placeholder="{{ __('common.enter_first_name') }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" class="form-label">
                                                {{ __('common.last_name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="last_name" name="last_name" required
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name') }}"
                                                placeholder="{{ __('common.enter_last_name') }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                {{ __('common.email_address') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" required
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}"
                                                placeholder="{{ __('common.your_email_placeholder') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">
                                                {{ __('common.phone_number') }}
                                            </label>
                                            <input type="tel" id="phone" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}"
                                                placeholder="{{ __('common.phone_placeholder') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company" class="form-label">
                                                {{ __('common.company_name') }}
                                            </label>
                                            <input type="text" id="company" name="company"
                                                class="form-control @error('company') is-invalid @enderror"
                                                value="{{ old('company') }}"
                                                placeholder="{{ __('common.your_company_name') }}">
                                            @error('company')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="form-label">
                                                {{ __('common.subject') }} <span class="text-danger">*</span>
                                            </label>
                                            <select id="subject" name="subject" required
                                                class="form-select @error('subject') is-invalid @enderror">
                                                <option value="">{{ __('common.choose_a_subject') }}</option>
                                                <option value="sales" {{ old('subject') == 'sales' ? 'selected' : '' }}>
                                                    {{ __('common.sales_inquiry') }}</option>
                                                <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>
                                                    {{ __('common.technical_support') }}</option>
                                                <option value="parts" {{ old('subject') == 'parts' ? 'selected' : '' }}>
                                                    {{ __('common.parts_service') }}</option>
                                                <option value="warranty" {{ old('subject') == 'warranty' ? 'selected' : '' }}>
                                                    {{ __('common.warranty_claim') }}</option>
                                                <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>
                                                    {{ __('common.partnership_opportunity') }}</option>
                                                <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>
                                                    {{ __('common.other') }}</option>
                                            </select>
                                            @error('subject')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="message" class="form-label">
                                                {{ __('common.message') }} <span class="text-danger">*</span>
                                            </label>
                                            <textarea id="message" name="message" rows="6" required
                                                placeholder="{{ __('common.message_placeholder') }}"
                                                class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-semibold">
                                                <i class="fas fa-paper-plane me-2"></i>{{ __('common.send_message') }}
                                            </button>
                                        </div>
                                        <p class="text-center text-muted mt-3 mb-0">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            {{ __('common.information_secure') }}
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Departments -->
    <section class="departments-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">{{ __('common.specialized_departments') }}</h2>
                    <p class="fs-5 text-muted">{{ __('common.connect_directly_with_teams') }}</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.sales_team') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.equipment_quotes_pricing') }}</p>
                        <a href="mailto:sales@soosancebotics.com" class="btn btn-outline-primary btn-sm">
                            sales@soosancebotics.com
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.technical_support') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.equipment_troubleshooting') }}</p>
                        <a href="mailto:support@soosancebotics.com" class="btn btn-outline-primary btn-sm">
                            support@soosancebotics.com
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.parts_service') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.spare_parts_maintenance') }}</p>
                        <a href="mailto:parts@soosancebotics.com" class="btn btn-outline-primary btn-sm">
                            parts@soosancebotics.com
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.customer_service') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.general_inquiries_account') }}</p>
                        <a href="mailto:service@soosancebotics.com" class="btn btn-outline-primary btn-sm">
                            service@soosancebotics.com
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold mb-3">{{ __('common.frequently_asked_questions') }}</h2>
                        <p class="fs-5 text-muted">{{ __('common.quick_answers_common_questions') }}</p>
                    </div>
                    
                    <div class="faq-container">
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_types_drilling_equipment') }}</span>
                                <i class="fas fa-chevron-down ms-auto"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.we_offer_comprehensive_range') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.do_you_provide_international_shipping') }}</span>
                                <i class="fas fa-chevron-down ms-auto"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.yes_we_ship_worldwide') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_warranty_do_you_offer') }}</span>
                                <i class="fas fa-chevron-down ms-auto"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.all_equipment_comes_with_warranty') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.do_you_provide_training') }}</span>
                                <i class="fas fa-chevron-down ms-auto"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.absolutely_we_provide_training') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.how_can_i_get_quote') }}</span>
                                <i class="fas fa-chevron-down ms-auto"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.you_can_request_quote') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Contact Button -->
    <div class="floating-contact">
        <button class="floating-btn" onclick="scrollToForm()" title="{{ __('common.send_message') }}">
            <i class="fas fa-comment"></i>
        </button>
    </div>

@push('scripts')
<script>
    // FAQ Toggle
    function toggleFAQ(button) {
        const answer = button.nextElementSibling;
        const icon = button.querySelector('i');
        const isActive = answer.classList.contains('active');
        
        // Close all other FAQ items
        document.querySelectorAll('.faq-answer.active').forEach(item => {
            if (item !== answer) {
                item.classList.remove('active');
                item.previousElementSibling.querySelector('i').style.transform = 'rotate(0deg)';
            }
        });
        
        // Toggle current item
        if (isActive) {
            answer.classList.remove('active');
            icon.style.transform = 'rotate(0deg)';
        } else {
            answer.classList.add('active');
            icon.style.transform = 'rotate(180deg)';
        }
    }
    
    // Scroll to form
    function scrollToForm() {
        document.getElementById('contact-form').scrollIntoView({
            behavior: 'smooth'
        });
    }
    
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    });
</script>
@endpush
@endsection
