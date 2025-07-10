@extends('layouts.public')

@section('title', __('terms.title'))
@section('description', __('terms.description'))

@push('styles')
<style>
    /* Page specific enhancements */
    .terms-hero {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 6rem 0 4rem;
        margin-top: 72px;
        position: relative;
        overflow: hidden;
    }
    
    .terms-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }
    
    .terms-content {
        position: relative;
        z-index: 2;
    }
    
    .terms-section {
        background: white;
        padding: 4rem 0;
    }
    
    .terms-card {
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
    
    .terms-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    }
    
    .terms-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }
    
    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        padding-left: 1.5rem;
    }
    
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 20px;
        background: var(--accent-color);
        border-radius: 2px;
    }
    
    .terms-text {
        line-height: 1.8;
        color: var(--text-color);
        font-size: 1.1rem;
    }
    
    .updated-info {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary-color);
        margin-bottom: 2rem;
        font-size: 0.95rem;
        color: var(--text-muted);
    }
    
    .contact-cta {
        background: linear-gradient(135deg, var(--background-color), #f1f5f9);
        padding: 2rem;
        border-radius: var(--border-radius);
        text-align: center;
        border: 2px solid var(--border-color);
        margin-top: 2rem;
    }
    
    .cta-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-color);
        color: white;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .cta-button:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        color: white;
        text-decoration: none;
    }
    
    /* Animations */
    .animate-fade-in {
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .terms-hero {
            padding: 4rem 0 3rem;
            text-align: center;
        }
        
        .terms-card {
            padding: 2rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="terms-hero">
        <div class="container">
            <div class="terms-content animate-fade-in">
                <h1 class="display-4 fw-bold mb-3">{{ __('terms.terms_of_service') }}</h1>
                <p class="lead">{{ __('terms.please_read_carefully') }}</p>
            </div>
        </div>
    </section>

    <!-- Terms Content Section -->
    <section class="terms-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="updated-info animate-fade-in">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ __('terms.last_updated', ['date' => date('F j, Y')]) }}
                    </div>

                    <div class="terms-card animate-fade-in">
                        <h2 class="section-title">{{ __('terms.acceptance_of_terms') }}</h2>
                        <p class="terms-text">
                            {{ __('terms.acceptance_description_1') }}
                        </p>
                        <p class="terms-text">
                            {{ __('terms.acceptance_description_2') }}
                        </p>
                    </div>

                    <div class="terms-card animate-fade-in">
                        <h2 class="section-title">{{ __('terms.use_license') }}</h2>
                        <p class="terms-text">
                            {{ __('terms.use_license_description') }}
                        </p>
                        <ul class="terms-text ps-4">
                            <li>{{ __('terms.modify_or_copy') }}</li>
                            <li>{{ __('terms.use_for_commercial') }}</li>
                            <li>{{ __('terms.attempt_decompile') }}</li>
                            <li>{{ __('terms.remove_copyright') }}</li>
                        </ul>
                    </div>

                    <div class="terms-card animate-fade-in">
                        <h2 class="section-title">{{ __('terms.product_information') }}</h2>
                        <p class="terms-text">
                            {{ __('terms.product_info_description') }}
                        </p>
                    </div>

                    <div class="terms-card animate-fade-in">
                        <h2 class="section-title">{{ __('terms.disclaimer') }}</h2>
                        <p class="terms-text">
                            {{ __('terms.disclaimer_description') }}
                        </p>
                    </div>

                    <div class="terms-card animate-fade-in">
                        <h2 class="section-title">{{ __('terms.limitations') }}</h2>
                        <p class="terms-text">
                            {{ __('terms.limitations_description') }}
                        </p>
                    </div>

                    <div class="terms-card animate-fade-in">
                        <h2 class="section-title">{{ __('terms.governing_law') }}</h2>
                        <p class="terms-text">
                            {{ __('terms.governing_law_description') }}
                        </p>
                    </div>

                    <div class="contact-cta animate-fade-in">
                        <h3 class="mb-3">{{ __('terms.have_questions') }}</h3>
                        <p class="terms-text mb-0">
                            {{ __('terms.contact_description') }}
                        </p>
                        <a href="{{ route('contact') }}" class="cta-button">
                            <i class="fas fa-envelope"></i>
                            {{ __('terms.contact_us') }}
                        </a>
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
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.terms-card, .contact-cta').forEach(card => {
            observer.observe(card);
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
