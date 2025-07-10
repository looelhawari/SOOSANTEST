<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SoosanEgypt - Drilling Equipment Solutions')</title>
    <meta name="description" content="@yield('description', 'Leading provider of drilling equipment and solutions. Quality machinery for construction, mining, and industrial applications.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Global Enhanced Styles -->
    <link href="{{ asset('css/global-styles.css') }}" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (app()->isLocale('ar'))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/rtl-styles.css') }}">
    @endif

    <!-- Additional head content -->
    @stack('head')
    @stack('styles')
</head>

<body class="bg-light">
    <!-- Fixed Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top" style="min-height:72px; font-size:1.15rem; padding-top: 0.7rem; padding-bottom: 0.7rem; z-index: 1050;">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
                <img src="{{ asset('images/logo.webp') }}" height="45" alt="SoosanEgypt"
                    class="{{ app()->isLocale('ar') ? 'ms-2' : 'me-2' }}">
                {{-- <span class="fs-4 fw-bold text-dark">SoosanEgypt</span> --}}
            </a>

            <!-- Mobile menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Enhanced Icon-based navigation for all pages -->
                <div class="icon-nav ms-auto">
                    <a href="{{ route('homepage') }}" 
                       class="nav-icon-item {{ request()->routeIs('homepage') ? 'active' : '' }}">
                        <i class="fas fa-home nav-icon"></i>
                        <span class="nav-icon-label">{{ __('common.home') }}</span>
                    </a>
                    
                    <a href="{{ route('products.index') }}" 
                       class="nav-icon-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs nav-icon"></i>
                        <span class="nav-icon-label">{{ __('common.products') }}</span>
                    </a>
                    
                    <a href="{{ route('serial-lookup.index') }}" 
                       class="nav-icon-item {{ request()->routeIs('serial-lookup.*') ? 'active' : '' }}">
                        <i class="fas fa-search nav-icon"></i>
                        <span class="nav-icon-label">{{ __('common.serial_lookup') }}</span>
                    </a>

                    @if(Route::has('about'))
                        <a href="{{ route('about') }}" 
                           class="nav-icon-item {{ request()->routeIs('about') ? 'active' : '' }}">
                            <i class="fas fa-info-circle nav-icon"></i>
                            <span class="nav-icon-label">{{ __('common.about') }}</span>
                        </a>
                    @endif

                    @if(Route::has('contact'))
                        <a href="{{ route('contact') }}" 
                           class="nav-icon-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                            <i class="fas fa-phone nav-icon"></i>
                            <span class="nav-icon-label">{{ __('common.contact') }}</span>
                        </a>
                    @endif

                    @if(Route::has('support'))
                        <a href="{{ route('support') }}" 
                           class="nav-icon-item {{ request()->routeIs('support') ? 'active' : '' }}">
                            <i class="fas fa-headset nav-icon"></i>
                            <span class="nav-icon-label">{{ __('common.support') }}</span>
                        </a>
                    @endif
                    
                    @auth('web')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="nav-icon-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <i class="fas fa-user-shield nav-icon"></i>
                            <span class="nav-icon-label">{{ __('common.dashboard') }}</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="nav-icon-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user-cog nav-icon"></i>
                            <span class="nav-icon-label">{{ __('common.profile') }}</span>
                        </a>
                    @endauth
                    
                    <!-- Authentication Icons -->
                    @auth('web')
                        <x-logout-button route="admin.logout" />
                    @else
                        <a href="{{ route('admin.login') }}" 
                           class="nav-icon-item {{ request()->routeIs('admin.login') ? 'active' : '' }}">
                            <i class="fas fa-sign-in-alt nav-icon"></i>
                            <span class="nav-icon-label">{{ __('common.login') }}</span>
                        </a>
                    @endauth
                </div>

                <!-- Language Toggle with Earth Icon -->
                <x-language-toggle class="ms-4" />
            </div>
        </div>
    </nav>

    <!-- Page Header/Search Slot -->
    @hasSection('page-header')
        <div class="bg-white border-bottom shadow-sm" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
            <div class="container">
                @yield('page-header')
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container py-5">
            <div class="row g-4">
                <!-- Company Info -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">SoosanEgypt</h5>
                    <p class="text-light small mb-3">{{ __('common.footer_description') }}</p>
                    <div class="d-flex gap-3">
                        <!-- Social links placeholder -->
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">{{ __('common.quick_links') }}</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('products.index') }}"
                                class="text-light text-decoration-none small">{{ __('common.products') }}</a></li>
                        <li class="mb-2"><a href="{{ route('serial-lookup.index') }}"
                                class="text-light text-decoration-none small">{{ __('common.serial_lookup') }}</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-light text-decoration-none small">{{ __('common.about') }}</a></li>
                        <li class="mb-2"><a href="{{ route('support') }}"
                                class="text-light text-decoration-none small">{{ __('common.support') }}</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">{{ __('common.legal') }}</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('privacy') }}"
                                class="text-light text-decoration-none small">{{ __('common.privacy') }}</a></li>
                        <li class="mb-2"><a href="{{ route('terms') }}"
                                class="text-light text-decoration-none small">{{ __('common.terms') }}</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">{{ __('common.contact') }}</h5>
                    <div class="text-light small">
                        <p class="mb-1">123 Industrial Avenue</p>
                        <p class="mb-1">Industrial City, Country</p>
                        <p class="mb-1">Phone: +1 (555) 123-4567</p>
                        <p class="mb-1">Email: info@soosancebotics.com</p>
                    </div>
                </div>
            </div>

            <hr class="border-secondary mt-4 mb-3">
            <div class="text-center">
                <p class="text-light small mb-0">&copy; {{ date('Y') }} SoosanEgypt.
                    {{ __('common.copyright') }}</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Global Enhanced Navigation Functions
        function initGlobalNavEffects() {
            const navbar = document.querySelector('.navbar');
            let lastScrollY = window.scrollY;
            
            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                
                // Add scrolled class when scrolling down
                if (currentScrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                // Hide/show navbar on scroll (optional enhancement)
                if (currentScrollY > lastScrollY && currentScrollY > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                
                lastScrollY = currentScrollY;
            });
        }

        // Enhanced Icon Animations for All Pages
        function initGlobalIconAnimations() {
            const iconItems = document.querySelectorAll('.nav-icon-item');
            
            iconItems.forEach((item, index) => {
                // Add staggered entrance animation
                item.style.animationDelay = `${index * 0.1}s`;
                
                // Add click ripple effect
                item.addEventListener('click', function(e) {
                    // Don't add ripple if it's a navigation click
                    if (e.target.closest('a')) return;
                    
                    // Create ripple element
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    
                    // Position ripple
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                        z-index: 1000;
                    `;
                    
                    this.appendChild(ripple);
                    
                    // Remove ripple after animation
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
                
                // Add hover effects
                item.addEventListener('mouseenter', function() {
                    this.style.filter = 'drop-shadow(0 4px 8px rgba(37, 99, 235, 0.2))';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.filter = 'none';
                });
            });
        }

        // Enhanced Button Interactions
        function initEnhancedButtons() {
            const buttons = document.querySelectorAll('.btn');
            
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Add loading class for form submissions
                    if (this.type === 'submit') {
                        this.classList.add('loading');
                    }
                });
            });
        }

        // Enhanced Form Interactions
        function initEnhancedForms() {
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                    }
                });
            });
        }

        // Enhanced Card Interactions
        function initEnhancedCards() {
            const cards = document.querySelectorAll('.card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        }

        // Unit switcher (if exists)
        function initUnitSwitcher() {
            const unitToggle = document.getElementById('unit-toggle');
            if (unitToggle) {
                unitToggle.addEventListener('click', function() {
                    const currentUnit = document.getElementById('current-unit');
                    const newUnit = currentUnit.textContent === 'SI' ? 'Imperial' : 'SI';
                    currentUnit.textContent = newUnit;

                    // Store in localStorage
                    localStorage.setItem('preferredUnit', newUnit);

                    // Trigger unit conversion on page
                    if (typeof convertUnits === 'function') {
                        convertUnits(newUnit);
                    }
                });
            }
        }

        // Page Loading Effects
        function initPageEffects() {
            // Fade in page content
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.3s ease';
            
            window.addEventListener('load', function() {
                document.body.style.opacity = '1';
            });
            
            // Initialize all enhancements after DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeEnhancements);
            } else {
                initializeEnhancements();
            }
        }

        // Initialize All Enhancements
        function initializeEnhancements() {
            // Load preferred settings
            const preferredUnit = localStorage.getItem('preferredUnit') || 'SI';
            const currentUnitElement = document.getElementById('current-unit');
            if (currentUnitElement) {
                currentUnitElement.textContent = preferredUnit;
            }

            if (typeof convertUnits === 'function') {
                convertUnits(preferredUnit);
            }
            
            // Initialize all global effects
            initGlobalNavEffects();
            initGlobalIconAnimations();
            initEnhancedButtons();
            initEnhancedForms();
            initEnhancedCards();
            initUnitSwitcher();
            
            // Initialize language toggle with entrance animation
            const languageToggle = document.getElementById('languageToggle');
            if (languageToggle) {
                languageToggle.style.opacity = '0';
                languageToggle.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    languageToggle.style.transition = 'all 0.3s ease';
                    languageToggle.style.opacity = '1';
                    languageToggle.style.transform = 'scale(1)';
                }, 100);
            }

            // Add keyboard navigation support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('keyboard-navigation');
                }
            });

            document.addEventListener('mousedown', function() {
                document.body.classList.remove('keyboard-navigation');
            });
        }

        // Initialize page effects immediately
        initPageEffects();

        // Enhanced navigation and navbar functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth navigation without refresh
            const navLinks = document.querySelectorAll('.nav-icon-item[href]');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading state
                    const icon = this.querySelector('.nav-icon');
                    const originalClass = icon.className;
                    
                    // Show loading spinner briefly
                    icon.className = 'fas fa-spinner fa-spin nav-icon';
                    
                    // Restore original icon after short delay
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 300);
                });
            });

            // Enhanced navbar scroll behavior
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                lastScrollTop = scrollTop;
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
