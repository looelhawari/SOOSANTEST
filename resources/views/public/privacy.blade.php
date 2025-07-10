@extends('layouts.public')

@section('title', __('privacy.title'))
@section('description', __('privacy.description'))

@push('styles')
<style>
    /* Privacy page specific enhancements */
    .privacy-hero {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        color: white;
        padding: 6rem 0 4rem;
        margin-top: 72px;
        position: relative;
        overflow: hidden;
    }
    
    .privacy-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 70%),
                    radial-gradient(circle at 70% 80%, rgba(255,255,255,0.05) 0%, transparent 70%);
    }
    
    .privacy-content {
        position: relative;
        z-index: 2;
    }
    
    .privacy-section {
        background: var(--background-color);
        padding: 4rem 0;
    }
    
    .privacy-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
        padding: 3rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .privacy-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
    }
    
    .privacy-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }
    
    .section-title {
        color: var(--secondary-color);
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        padding-left: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title::before {
        content: '';
        width: 8px;
        height: 8px;
        background: var(--accent-color);
        border-radius: 50%;
        flex-shrink: 0;
    }
    
    .privacy-text {
        line-height: 1.8;
        color: var(--text-color);
        font-size: 1.1rem;
    }
    
    .updated-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--secondary-color);
        margin-bottom: 2rem;
        font-size: 0.95rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .privacy-highlight {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--accent-color);
        margin: 1.5rem 0;
    }
    
    .privacy-list {
        list-style: none;
        padding: 0;
    }
    
    .privacy-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
        position: relative;
        padding-left: 2rem;
    }
    
    .privacy-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        top: 0.75rem;
        color: var(--accent-color);
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .privacy-list li:last-child {
        border-bottom: none;
    }
    
    .contact-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 3rem 0;
        text-align: center;
        border-radius: var(--border-radius);
        margin-top: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .contact-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    }
    
    .contact-content {
        position: relative;
        z-index: 2;
    }
    
    .cta-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--accent-color);
        color: white;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 1rem;
        border: 2px solid transparent;
    }
    
    .cta-button:hover {
        background: transparent;
        border-color: var(--accent-color);
        color: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(74, 222, 128, 0.3);
        text-decoration: none;
    }
    
    /* Icon styles */
    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }
    
    /* Animations */
    .animate-slide-in {
        animation: slideInLeft 0.8s ease-out;
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .privacy-hero {
            padding: 4rem 0 3rem;
            text-align: center;
        }
        
        .privacy-card {
            padding: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="privacy-hero">
        <div class="container">
            <div class="privacy-content animate-slide-in">
                <h1 class="display-4 fw-bold mb-3">{{ __('privacy.privacy_policy') }}</h1>
                <p class="lead">{{ __('privacy.privacy_important') }}</p>
            </div>
        </div>
    </section>

    <!-- Privacy Content Section -->
    <section class="privacy-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="updated-info animate-slide-in">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ __('privacy.last_updated', ['date' => date('F j, Y')]) }}</span>
                    </div>

                    <div class="privacy-card animate-slide-in">
                        <div class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h2 class="section-title">{{ __('privacy.information_we_collect') }}</h2>
                        <p class="privacy-text">
                            {{ __('privacy.information_collect_description') }}
                        </p>
                        
                        <div class="privacy-highlight">
                            <h4 class="mb-3">{{ __('privacy.types_of_information') }}</h4>
                            <ul class="privacy-list">
                                <li>{{ __('privacy.personal_identification') }}</li>
                                <li>{{ __('privacy.business_information') }}</li>
                                <li>{{ __('privacy.equipment_information') }}</li>
                                <li>{{ __('privacy.service_requests') }}</li>
                                <li>{{ __('privacy.website_usage') }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="privacy-card animate-slide-in">
                        <div class="section-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h2 class="section-title">{{ __('privacy.how_we_use_info') }}</h2>
                        <p class="privacy-text">
                            {{ __('privacy.use_info_description') }}
                        </p>
                        
                        <ul class="privacy-list">
                            <li>{{ __('privacy.process_orders') }}</li>
                            <li>{{ __('privacy.provide_support') }}</li>
                            <li>{{ __('privacy.send_updates') }}</li>
                            <li>{{ __('privacy.improve_products') }}</li>
                            <li>{{ __('privacy.comply_legal') }}</li>
                        </ul>
                    </div>

                    <div class="privacy-card animate-slide-in">
                        <div class="section-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <h2 class="section-title">{{ __('privacy.information_sharing') }}</h2>
                        <p class="privacy-text">
                            {{ __('privacy.sharing_description') }}
                        </p>
                        
                        <div class="privacy-highlight">
                            <h4 class="mb-3">{{ __('privacy.may_share_with') }}</h4>
                            <ul class="privacy-list">
                                <li>{{ __('privacy.service_providers') }}</li>
                                <li>{{ __('privacy.business_partners') }}</li>
                                <li>{{ __('privacy.legal_requirements') }}</li>
                                <li>{{ __('privacy.business_transfers') }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="privacy-card animate-slide-in">
                        <div class="section-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h2 class="section-title">{{ __('privacy.data_security_title') }}</h2>
                        <p class="privacy-text">
                            {{ __('privacy.data_security_description') }}
                        </p>
                        
                        <ul class="privacy-list">
                            <li>{{ __('privacy.ssl_encryption') }}</li>
                            <li>{{ __('privacy.secure_storage') }}</li>
                            <li>{{ __('privacy.security_audits') }}</li>
                            <li>{{ __('privacy.employee_training_security') }}</li>
                        </ul>
                    </div>

                    <div class="privacy-card animate-slide-in">
                        <div class="section-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h2 class="section-title">{{ __('privacy.your_rights_title') }}</h2>
                        <p class="privacy-text">
                            {{ __('privacy.your_rights_description') }}
                        </p>
                        
                        <ul class="privacy-list">
                            <li>{{ __('privacy.access_personal_data') }}</li>
                            <li>{{ __('privacy.request_correction') }}</li>
                            <li>{{ __('privacy.request_deletion') }}</li>
                            <li>{{ __('privacy.opt_out_marketing') }}</li>
                            <li>{{ __('privacy.data_portability_right') }}</li>
                        </ul>
                    </div>

                    <div class="privacy-card animate-slide-in">
                        <div class="section-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h2 class="section-title">{{ __('privacy.international_transfers') }}</h2>
                        <p class="privacy-text">
                            {{ __('privacy.international_description') }}
                        </p>
                    </div>

                    <div class="contact-section animate-slide-in">
                        <div class="contact-content">
                            <h3 class="mb-3">{{ __('privacy.questions_privacy') }}</h3>
                            <p class="mb-0">
                                {{ __('privacy.questions_description') }}
                            </p>
                            <a href="{{ route('contact') }}" class="cta-button">
                                <i class="fas fa-envelope"></i>
                                {{ __('privacy.contact_privacy_team') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = `${Math.random() * 0.3}s`;
                    entry.target.classList.add('animate-slide-in');
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.privacy-card, .contact-section').forEach(card => {
            observer.observe(card);
        });

        // Add click handlers for better UX
        document.querySelectorAll('.privacy-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.borderLeftColor = 'var(--primary-color)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.borderLeftColor = 'var(--border-color)';
            });
        });

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush
