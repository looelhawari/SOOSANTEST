@extends('layouts.public')

@section('title', 'Support & Service - SoosanEgypt')
@section('description', 'Comprehensive support services, maintenance, and technical assistance for SoosanEgypt equipment worldwide')

@push('styles')
<style>
    /* Modern Support Page Styles */
    .support-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 75%, #475569 100%);
        color: white;
        padding: 6rem 0 4rem;
        position: relative;
        overflow: hidden;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }
    
    .support-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badges {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
    }

    .badge-item {
        text-align: center;
        position: relative;
    }

    .badge-item::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .badge-item:last-child::after {
        display: none;
    }

    .badge-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: linear-gradient(135deg, var(--accent-color), #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
    }

    .badge-item:hover .badge-icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* Support Categories */
    .support-categories {
        padding: 5rem 0 3rem;
        background: linear-gradient(to bottom, #f8fafc, #ffffff);
    }

    .category-card {
        background: white;
        border-radius: 24px;
        padding: 3rem 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
        text-align: center;
    }

    .category-card::before {
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

    .category-card:hover::before {
        transform: scaleX(1);
    }

    .category-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 48px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .category-icon {
        width: 100px;
        height: 100px;
        border-radius: 25px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin: 0 auto 2rem;
        box-shadow: 0 12px 32px rgba(37, 99, 235, 0.25);
        transition: all 0.4s ease;
        position: relative;
    }

    .category-card:hover .category-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.35);
    }

    .category-icon::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border: 2px solid transparent;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        background-clip: padding-box;
        border-radius: 29px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card:hover .category-icon::after {
        opacity: 0.3;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
        text-align: left;
    }

    .feature-list li {
        padding: 0.75rem 0;
        position: relative;
        padding-left: 2rem;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }

    .feature-list li:last-child {
        border-bottom: none;
    }

    .feature-list li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-color), #10b981);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .feature-list li:hover {
        color: var(--primary-color);
        padding-left: 2.5rem;
    }

    .action-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 16px;
        padding: 1rem 2rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        color: white;
    }

    /* Emergency Support */
    .emergency-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .emergency-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 30% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="emergency-pattern" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M20,0 L40,20 L20,40 L0,20 Z" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23emergency-pattern)"/></svg>');
    }

    .emergency-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .emergency-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        padding: 3rem;
        margin-top: 2rem;
        transition: all 0.3s ease;
    }

    .emergency-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-4px);
    }

    .emergency-btn {
        background: white;
        color: #dc2626;
        border: none;
        border-radius: 16px;
        padding: 1.25rem 2.5rem;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        animation: emergencyPulse 2s infinite;
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.2);
    }

    .emergency-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(255, 255, 255, 0.3);
        color: #dc2626;
        animation: none;
    }

    @keyframes emergencyPulse {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 8px 24px rgba(255, 255, 255, 0.2);
        }
        50% { 
            transform: scale(1.02);
            box-shadow: 0 12px 32px rgba(255, 255, 255, 0.3);
        }
    }

    /* Statistics Section */
    .stats-section {
        padding: 4rem 0;
        background: white;
    }

    .stats-container {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .stat-card {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        display: block;
    }

    .stat-label {
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    /* Contact Methods */
    .contact-methods {
        padding: 4rem 0;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .contact-method-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        text-align: center;
        transition: all 0.4s ease;
        height: 100%;
    }

    .contact-method-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .contact-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.1);
        transition: all 0.4s ease;
    }

    .contact-method-card:hover .contact-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 32px rgba(255, 255, 255, 0.2);
    }

    .contact-action {
        background: white;
        color: var(--primary-color);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .contact-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.3);
        color: var(--primary-color);
    }

    /* FAQ Section */
    .faq-section {
        padding: 4rem 0;
        background: white;
    }

    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .faq-item {
        background: #f8fafc;
        border-radius: 16px;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        border-color: var(--primary-color);
    }

    .faq-question {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        padding: 1.5rem 2rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .faq-question:hover {
        background: rgba(37, 99, 235, 0.05);
        color: var(--primary-color);
    }

    .faq-answer {
        padding: 0 2rem 1.5rem;
        color: #6b7280;
        line-height: 1.8;
        display: none;
        font-size: 1.05rem;
    }

    .faq-answer.active {
        display: block;
        animation: fadeInDown 0.3s ease;
    }

    .faq-icon {
        transition: transform 0.3s ease;
        color: var(--primary-color);
    }

    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }

    /* Animations */
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

    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .support-hero {
            padding: 4rem 0 3rem;
        }
        
        .hero-badges {
            margin-top: 2rem;
            padding: 1.5rem;
        }
        
        .badge-item::after {
            display: none;
        }
        
        .category-card {
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }
        
        .emergency-card {
            padding: 2rem;
        }
        
        .stats-container {
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
        
        .contact-method-card {
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .faq-question {
            padding: 1.25rem 1.5rem;
            font-size: 1rem;
        }
        
        .faq-answer {
            padding: 0 1.5rem 1.25rem;
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Modern Hero Section -->
    <section class="support-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="hero-content text-center">
                        <h1 class="display-3 fw-bold mb-4">
                            {{ __('common.expert_support_service') }}
                        </h1>
                        <p class="fs-4 mb-4 opacity-90">
                            {{ __('common.comprehensive_support_solutions') }}
                        </p>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <a href="#emergency" class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ __('common.emergency_support') }}
                            </a>
                            <a href="#contact-support" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="fas fa-headset me-2"></i>{{ __('common.contact_support') }}
                            </a>
                        </div>
                        
                        <!-- Hero Badges -->
                        <div class="hero-badges">
                            <div class="row g-4">
                                <div class="col-md-3 col-6">
                                    <div class="badge-item">
                                        <div class="badge-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">{{ __('common.available_24_7') }}</h6>
                                        <small class="opacity-75">{{ __('common.round_the_clock') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="badge-item">
                                        <div class="badge-icon">
                                            <i class="fas fa-globe-americas"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">{{ __('common.global_coverage') }}</h6>
                                        <small class="opacity-75">{{ __('common.150_countries') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="badge-item">
                                        <div class="badge-icon">
                                            <i class="fas fa-lightning-bolt"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">{{ __('common.fast_response') }}</h6>
                                        <small class="opacity-75">{{ __('common.less_than_4_hours') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="badge-item">
                                        <div class="badge-icon">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">{{ __('common.certified_experts') }}</h6>
                                        <small class="opacity-75">{{ __('common.professional_team') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Support Categories -->
    <section class="support-categories">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">{{ __('common.comprehensive_support_services') }}</h2>
                    <p class="fs-5 text-muted">{{ __('common.emergency_repairs_to_preventive') }}</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="category-card animate-on-scroll">
                        <div class="category-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">{{ __('common.technical_support_24_7') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.round_the_clock_technical_assistance') }}</p>
                        <ul class="feature-list">
                            <li>{{ __('common.multilingual_support_team') }}</li>
                            <li>{{ __('common.remote_diagnostics_troubleshooting') }}</li>
                            <li>{{ __('common.live_chat_video_assistance') }}</li>
                            <li>{{ __('common.priority_emergency_response') }}</li>
                            <li>{{ __('common.equipment_optimization_guidance') }}</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="action-btn">
                            <i class="fas fa-phone"></i>{{ __('common.get_support') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="category-card animate-on-scroll">
                        <div class="category-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">{{ __('common.onsite_service_maintenance') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.professional_field_service') }}</p>
                        <ul class="feature-list">
                            <li>{{ __('common.preventive_maintenance_programs') }}</li>
                            <li>{{ __('common.emergency_repair_services') }}</li>
                            <li>{{ __('common.equipment_inspections_audits') }}</li>
                            <li>{{ __('common.performance_optimization') }}</li>
                            <li>{{ __('common.upgrade_modernization') }}</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="action-btn">
                            <i class="fas fa-calendar-check"></i>{{ __('common.schedule_service') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="category-card animate-on-scroll">
                        <div class="category-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">{{ __('common.genuine_parts_components') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.authentic_oem_parts') }}</p>
                        <ul class="feature-list">
                            <li>{{ __('common.100_genuine_oem_parts') }}</li>
                            <li>{{ __('common.global_inventory_network') }}</li>
                            <li>{{ __('common.express_shipping_worldwide') }}</li>
                            <li>{{ __('common.parts_warranty_coverage') }}</li>
                            <li>{{ __('common.technical_documentation') }}</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="action-btn">
                            <i class="fas fa-shopping-cart"></i>{{ __('common.order_parts') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="category-card animate-on-scroll">
                        <div class="category-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">{{ __('common.training_certification') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.comprehensive_training_programs') }}</p>
                        <ul class="feature-list">
                            <li>{{ __('common.operator_certification_programs') }}</li>
                            <li>{{ __('common.technical_training_courses') }}</li>
                            <li>{{ __('common.safety_training_protocols') }}</li>
                            <li>{{ __('common.online_learning_platform') }}</li>
                            <li>{{ __('common.continuing_education_credits') }}</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="action-btn">
                            <i class="fas fa-book-open"></i>{{ __('common.view_training') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="category-card animate-on-scroll">
                        <div class="category-icon">
                            <i class="fas fa-laptop-medical"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">{{ __('common.remote_monitoring_diagnostics') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.advanced_iot_monitoring') }}</p>
                        <ul class="feature-list">
                            <li>{{ __('common.real_time_equipment_monitoring') }}</li>
                            <li>{{ __('common.predictive_maintenance_alerts') }}</li>
                            <li>{{ __('common.performance_analytics_reports') }}</li>
                            <li>{{ __('common.usage_optimization_insights') }}</li>
                            <li>{{ __('common.customizable_dashboards') }}</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="action-btn">
                            <i class="fas fa-chart-line"></i>{{ __('common.learn_more') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="category-card animate-on-scroll">
                        <div class="category-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">{{ __('common.warranty_protection_plans') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.comprehensive_warranty_coverage') }}</p>
                        <ul class="feature-list">
                            <li>{{ __('common.standard_warranty_coverage') }}</li>
                            <li>{{ __('common.extended_warranty_options') }}</li>
                            <li>{{ __('common.total_care_protection_plans') }}</li>
                            <li>{{ __('common.warranty_claim_assistance') }}</li>
                            <li>{{ __('common.insurance_coordination') }}</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="action-btn">
                            <i class="fas fa-umbrella"></i>{{ __('common.check_coverage') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Emergency Support -->
    <section class="emergency-section" id="emergency">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="emergency-content">
                        <h2 class="display-5 fw-bold mb-3">
                            <i class="fas fa-exclamation-triangle me-3"></i>
                            {{ __('common.emergency_support_available') }}
                        </h2>
                        <p class="fs-5 mb-4">
                            {{ __('common.equipment_breakdown_costs') }}
                        </p>
                        
                        <div class="emergency-card">
                            <div class="row g-4">
                                <div class="col-md-4 text-center">
                                    <div class="badge-icon mx-auto mb-3">
                                        <i class="fas fa-stopwatch"></i>
                                    </div>
                                    <h5 class="fw-bold">{{ __('common.less_than_1_hour') }}</h5>
                                    <p class="mb-0">{{ __('common.emergency_response_time') }}</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="badge-icon mx-auto mb-3">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <h5 class="fw-bold">{{ __('common.expert_team') }}</h5>
                                    <p class="mb-0">{{ __('common.certified_emergency_technicians') }}</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="badge-icon mx-auto mb-3">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <h5 class="fw-bold">{{ __('common.global_coverage') }}</h5>
                                    <p class="mb-0">{{ __('common.worldwide_service_network') }}</p>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="tel:+18005667261" class="emergency-btn">
                                    <i class="fas fa-phone-alt"></i>
                                    {{ __('common.emergency_hotline') }}
                                </a>
                                <p class="mt-3 mb-0 opacity-75">
                                    {{ __('common.available_24_7_365') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="stats-container">
                        <div class="text-center mb-4">
                            <h2 class="display-6 fw-bold mb-3">{{ __('common.support_by_numbers') }}</h2>
                            <p class="fs-5 text-muted">{{ __('common.commitment_excellence_metrics') }}</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <span class="stat-number" data-target="24">0</span>
                                    <div class="stat-label">{{ __('common.hours_support') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <span class="stat-number" data-target="150">0</span>
                                    <div class="stat-label">{{ __('common.countries_served') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <span class="stat-number" data-target="98">0</span>
                                    <div class="stat-label">{{ __('common.customer_satisfaction') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="stat-card">
                                    <span class="stat-number" data-target="4">0</span>
                                    <div class="stat-label">{{ __('common.avg_response_hours') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Methods -->
    <section class="contact-methods" id="contact-support">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">{{ __('common.multiple_ways_get_support') }}</h2>
                    <p class="fs-5 opacity-90">{{ __('common.choose_support_channel') }}</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ __('common.phone_support') }}</h4>
                        <p class="mb-3 opacity-90">{{ __('common.speak_directly_technical_experts') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">+1-800-SOOSAN-1</strong>
                            <small class="opacity-75">{{ __('common.available_24_7') }}</small>
                        </div>
                        <a href="tel:+18005667261" class="contact-action">
                            <i class="fas fa-phone me-2"></i>{{ __('common.call_now') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ __('common.email_support') }}</h4>
                        <p class="mb-3 opacity-90">{{ __('common.send_detailed_technical_questions') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">support@soosanegypt.com</strong>
                            <small class="opacity-75">{{ __('common.hour_response') }}</small>
                        </div>
                        <a href="mailto:support@soosanegypt.com" class="contact-action">
                            <i class="fas fa-envelope me-2"></i>{{ __('common.send_email') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ __('common.live_chat') }}</h4>
                        <p class="mb-3 opacity-90">{{ __('common.get_instant_answers') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">{{ __('common.instant_response') }}</strong>
                            <small class="opacity-75">{{ __('common.mon_fri_8am_8pm') }}</small>
                        </div>
                        <a href="#" class="contact-action" onclick="openLiveChat()">
                            <i class="fas fa-comments me-2"></i>{{ __('common.start_chat') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ __('common.support_portal') }}</h4>
                        <p class="mb-3 opacity-90">{{ __('common.submit_detailed_support_tickets') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">{{ __('common.ticket_system') }}</strong>
                            <small class="opacity-75">{{ __('common.track_progress') }}</small>
                        </div>
                        <a href="{{ route('contact') }}" class="contact-action">
                            <i class="fas fa-ticket-alt me-2"></i>{{ __('common.create_ticket') }}
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
                        <p class="fs-5 text-muted">{{ __('common.quick_answers_support_questions') }}</p>
                    </div>
                    
                    <div class="faq-container">
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_average_response_time') }}</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.standard_response_time_4_hours') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.do_you_provide_onsite_worldwide') }}</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.yes_certified_technicians_150_countries') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_training_programs_offer') }}</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.comprehensive_training_operator_certification') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.how_order_genuine_parts') }}</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.order_parts_support_team') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_remote_monitoring_capabilities') }}</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.advanced_iot_monitoring_system') }}
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_warranty_coverage_included') }}</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.all_equipment_comprehensive_warranty') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('scripts')
<script>
    // FAQ Toggle functionality
    function toggleFAQ(button) {
        const faqItem = button.closest('.faq-item');
        const answer = button.nextElementSibling;
        const icon = button.querySelector('.faq-icon');
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
            item.querySelector('.faq-answer').classList.remove('active');
            item.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
            answer.classList.add('active');
            icon.style.transform = 'rotate(180deg)';
        }
    }
    
    // Animate numbers on scroll
    function animateNumber(element, start, end, duration) {
        const range = end - start;
        const startTime = performance.now();
        
        function updateNumber(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(start + (range * progress));
            
            if (element.dataset.target === '98') {
                element.textContent = current + '%';
            } else if (element.dataset.target === '24') {
                element.textContent = current + '/7';
            } else if (element.dataset.target === '150') {
                element.textContent = current + '+';
            } else {
                element.textContent = current;
            }
            
            if (progress < 1) {
                requestAnimationFrame(updateNumber);
            }
        }
        
        requestAnimationFrame(updateNumber);
    }
    
    // Intersection Observer for animations
    function initAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    
                    // Animate stat numbers if this is a stats section
                    if (entry.target.classList.contains('stats-container')) {
                        const statNumbers = entry.target.querySelectorAll('.stat-number');
                        statNumbers.forEach((stat, index) => {
                            setTimeout(() => {
                                const target = parseInt(stat.dataset.target);
                                animateNumber(stat, 0, target, 2000);
                            }, index * 200);
                        });
                    }
                }
            });
        }, observerOptions);
        
        // Observe all animated elements
        document.querySelectorAll('.animate-on-scroll, .stats-container').forEach(element => {
            observer.observe(element);
        });
    }
    
    // Live chat function (placeholder)
    function openLiveChat() {
        // This would integrate with your live chat system
        alert('Live chat would open here. Integration with your preferred chat system needed.');
    }
    
    // Enhanced card interactions
    function initCardInteractions() {
        document.querySelectorAll('.category-card, .contact-method-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }
    
    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initAnimations();
        initCardInteractions();
        
        // Add staggered animation to category cards
        document.querySelectorAll('.category-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
        
        // Emergency button pulse effect
        const emergencyBtn = document.querySelector('.emergency-btn');
        if (emergencyBtn) {
            setInterval(() => {
                emergencyBtn.style.boxShadow = '0 12px 32px rgba(255, 255, 255, 0.4)';
                setTimeout(() => {
                    emergencyBtn.style.boxShadow = '0 8px 24px rgba(255, 255, 255, 0.2)';
                }, 500);
            }, 3000);
        }
    });
</script>
@endpush
@endsection
