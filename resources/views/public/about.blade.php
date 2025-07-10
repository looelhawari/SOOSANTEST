@extends('layouts.public')

@section('title', __('about.title'))
@section('description', __('about.description'))

@push('styles')
<style>
    /* Enhanced About Page Styles */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .animated-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: var(--border-radius);
        overflow: hidden;
        position: relative;
    }

    .animated-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .animated-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .animated-card:hover::before {
        left: 100%;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        font-size: 2rem;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transition: all 0.3s ease;
    }

    .feature-icon:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
    }

    .stats-counter {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
        margin-bottom: 0.5rem;
    }

    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: -2rem;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: var(--primary-color);
        box-shadow: 0 0 0 4px white, 0 0 0 6px var(--primary-color);
    }

    .timeline-item:last-child::before {
        display: none;
    }

    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-counter {
        animation: countUp 0.6s ease-out forwards;
    }
</style>
@endpush

@section('content')
    <!-- Enhanced Hero Section -->
    <!-- Enhanced Hero Section -->
<section class="hero-section" style="background-color: #000; padding: 80px 0;">
    <div class="container" style="max-width: 1140px; margin: 0 auto;">
        <div class="hero-content text-center">
            <h1 class="display-4 fw-bold mb-3 animate-counter" style="color: white; font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem;">
                {{ __('about.hero_title') }}
            </h1>
            <p class="fs-4 mb-4 animate-counter" style="color: white; font-size: 1.25rem; margin-bottom: 1.5rem; animation-delay: 0.2s;">
                {{ __('about.hero_subtitle') }}
            </p>
            <div class="row text-center mt-5" style="display: flex; justify-content: center; gap: 40px; margin-top: 3rem;">
                <div class="col-md-4 mb-3" style="flex: 1;">
                    <span class="stats-counter animate-counter" data-count="20" style="color: white; font-size: 2rem; font-weight: bold;">0</span>
                    <p class="mb-0" style="color: white; margin-top: 0.5rem;">{{ __('about.years_of_excellence') }}</p>
                </div>
                <div class="col-md-4 mb-3" style="flex: 1;">
                    <span class="stats-counter animate-counter" data-count="1000" style="color: white; font-size: 2rem; font-weight: bold; animation-delay: 0.1s;">0</span>
                    <p class="mb-0" style="color: white; margin-top: 0.5rem;">{{ __('about.projects_completed') }}</p>
                </div>
                <div class="col-md-4 mb-3" style="flex: 1;">
                    <span class="stats-counter animate-counter" data-count="50" style="color: white; font-size: 2rem; font-weight: bold; animation-delay: 0.2s;">0</span>
                    <p class="mb-0" style="color: white; margin-top: 0.5rem;">{{ __('about.countries_served') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Enhanced Content Section -->
    <div class="py-5">
        <div class="container">
            <!-- Our Story -->
            <div class="animated-card card shadow-sm mb-5">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-4 mb-md-0">
                            <div class="feature-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h2 class="h2 fw-bold mb-4">{{ __('about.our_story') }}</h2>
                            <p class="mb-4">
                                {{ __('about.our_story_description_1') }}
                            </p>
                            <p class="mb-0">
                                {{ __('about.our_story_description_2') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Our Mission -->
            <div class="animated-card card shadow-sm mb-5">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-4 mb-md-0">
                            <div class="feature-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h2 class="h2 fw-bold mb-4">{{ __('about.our_mission') }}</h2>
                            <p class="mb-0">
                                {{ __('about.our_mission_description') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="animated-card card shadow-sm mb-5">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h2 fw-bold mb-5 text-center">{{ __('about.why_choose_us') }}</h2>
                    <div class="row g-4">
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3">{{ __('about.quality_assurance') }}</h3>
                                <p>
                                    {{ __('about.quality_assurance_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3">{{ __('about.innovation') }}</h3>
                                <p>
                                    {{ __('about.innovation_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3">{{ __('about.global_support') }}</h3>
                                <p>
                                    {{ __('about.global_support_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3">{{ __('about.environmental_responsibility') }}</h3>
                                <p>
                                    {{ __('about.environmental_responsibility_description') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    
            <!-- Contact CTA -->
            <div class="animated-card card shadow-sm">
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h2 class="h2 fw-bold mb-4">{{ __('about.contact_us') }}</h2>
                    <p class="mb-4 fs-5">
                        {{ __('about.contact_cta_description') }}
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-phone me-2"></i>
                        {{ __('about.get_in_touch') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-cogs me-2"></i>
                        {{ __('about.view_products') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Counter Animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stats-counter[data-count]');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            
            // Start animation when element is in view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            observer.observe(counter);
        });
    }

    // Enhanced Card Animations
    function initAboutPageAnimations() {
        const cards = document.querySelectorAll('.animated-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    }

    // Initialize animations when page loads
    document.addEventListener('DOMContentLoaded', function() {
        animateCounters();
        initAboutPageAnimations();
    });
</script>
@endpush
