@extends('layouts.public')

@section('title', __('homepage.hero_slide_1_title') . ' - SoosanEgypt')
@section('description', __('homepage.hero_slide_1_description'))

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<!-- AOS Styles -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Override navbar styles for homepage */
    .navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.98) !important;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
    }

    /* Icon Navigation Styles */
    .icon-nav {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .nav-icon-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: var(--text-color);
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-radius: 12px;
        min-width: 60px;
    }

    .nav-icon-item:hover {
        color: var(--primary-color);
        transform: translateY(-2px);
        background: rgba(37, 99, 235, 0.05);
    }

    .nav-icon-item.active {
        color: var(--primary-color);
        background: rgba(37, 99, 235, 0.1);
    }

    .nav-icon {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-icon-item:hover .nav-icon {
        transform: scale(1.1);
        animation: iconBounce 0.6s ease;
    }

    .nav-icon-label {
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .nav-icon-item:hover .nav-icon-label {
        opacity: 1;
        transform: scale(1.05);
    }

    /* Icon specific animations */
    .nav-icon-item:hover .fa-home {
        animation: homeAnimation 0.6s ease;
    }

    .nav-icon-item:hover .fa-cogs {
        animation: gearsAnimation 1s ease;
    }

    .nav-icon-item:hover .fa-search {
        animation: searchAnimation 0.8s ease;
    }

    .nav-icon-item:hover .fa-user-shield {
        animation: shieldAnimation 0.7s ease;
    }

    /* Keyframe animations */
    @keyframes iconBounce {
        0%, 100% { transform: scale(1.1); }
        50% { transform: scale(1.25); }
    }

    @keyframes homeAnimation {
        0%, 100% { transform: scale(1.1); }
        25% { transform: scale(1.2) rotate(-5deg); }
        75% { transform: scale(1.2) rotate(5deg); }
    }

    @keyframes gearsAnimation {
        0%, 100% { transform: scale(1.1) rotate(0deg); }
        50% { transform: scale(1.25) rotate(180deg); }
    }

    @keyframes searchAnimation {
        0%, 100% { transform: scale(1.1); }
        25% { transform: scale(1.2) translateX(-2px); }
        75% { transform: scale(1.2) translateX(2px); }
    }

    @keyframes shieldAnimation {
        0%, 100% { transform: scale(1.1); }
        50% { transform: scale(1.25); }
        25% { filter: drop-shadow(0 0 10px rgba(37, 99, 235, 0.5)); }
        75% { filter: drop-shadow(0 0 15px rgba(37, 99, 235, 0.7)); }
    }

    /* Active indicator */
    .nav-icon-item::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .nav-icon-item.active::after,
    .nav-icon-item:hover::after {
        width: 24px;
    }

    /* Mobile responsive */
    @media (max-width: 991px) {
        .icon-nav {
            flex-direction: column;
            gap: 1rem;
            background: white;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }

        .nav-icon-item {
            flex-direction: row;
            justify-content: flex-start;
            width: 100%;
            padding: 0.75rem;
            gap: 1rem;
        }

        .nav-icon {
            margin-bottom: 0;
            font-size: 1.25rem;
        }

        .nav-icon-label {
            font-size: 0.9rem;
        }

        .nav-icon-item::after {
            display: none;
        }
    }

    /* Language and login adjustments */
    .navbar-nav .nav-link,
    .navbar-nav .btn {
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        transform: translateY(-1px);
    }

    .navbar-nav .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Hero section padding adjustment for fixed navbar */
    .hero-slider {
        margin-top: 0;
    }

    /* iPhone-style Language Toggle Switch */
    .language-toggle-container {
        display: flex;
        align-items: center;
        margin-left: 1rem;
    }

    .language-toggle {
        position: relative;
        width: 80px;
        height: 36px;
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        border-radius: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 2px solid #e2e8f0;
    }

    .language-toggle.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-color: var(--primary-color);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2), 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .language-toggle-slider {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 30px;
        height: 30px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
    }

    .language-toggle.active .language-toggle-slider {
        transform: translateX(44px);
        color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .language-labels {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px;
        pointer-events: none;
        font-size: 11px;
        font-weight: 600;
    }

    .lang-en {
        color: #64748b;
        transition: all 0.3s ease;
    }

    .lang-ar {
        color: #64748b;
        transition: all 0.3s ease;
    }

    .language-toggle.active .lang-en {
        color: rgba(255, 255, 255, 0.8);
    }

    .language-toggle.active .lang-ar {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Hover effects */
    .language-toggle:hover {
        transform: scale(1.02);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .language-toggle:active {
        transform: scale(0.98);
    }

    /* Animation for smooth sliding */
    @keyframes slideToggle {
        0% { transform: translateX(0); }
        100% { transform: translateX(44px); }
    }

    .language-toggle.active .language-toggle-slider {
        animation: slideToggle 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Mobile adjustments */
    @media (max-width: 991px) {
        .language-toggle-container {
            margin: 1rem 0;
            justify-content: center;
        }
        
        .language-toggle {
            width: 90px;
            height: 40px;
        }
        
        .language-toggle-slider {
            width: 34px;
            height: 34px;
        }
        
        .language-toggle.active .language-toggle-slider {
            transform: translateX(48px);
        }
    }
    :root {
        --primary-color: #2563eb;
        --secondary-color: #1d4ed8;
        --accent-color: #4ade80;
        --background-color: #f8fafc;
        --text-color: #111827;
        --text-muted: #6b7280;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --transition-duration: 0.4s;
        --border-radius: 12px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        background: var(--background-color);
        overflow-x: hidden;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: var(--border-radius);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-color);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Modern Hero Slider */
    .hero-slider {
        position: relative;
        height: 100vh;
        overflow: hidden;
    }

    .slider-container {
        position: relative;
        height: 100%;
    }

    .hero-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .slide-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            135deg, 
            rgba(0, 0, 0, 0.3) 0%, 
            rgba(0, 0, 0, 0.1) 50%, 
            rgba(0, 0, 0, 0.2) 100%
        );
        z-index: 2;
    }

    /* Modern Hero Content Section */
    .hero-content-section {
        position: relative;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 6rem 0;
        margin-top: -100px;
        z-index: 10;
        border-radius: 40px 40px 0 0;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.1);
    }

    .hero-content-section::before {
        content: '';
        position: absolute;
        top: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--secondary-color));
    }

    .hero-content {
        text-align: center;
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .hero-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
        animation: slideUp 0.8s ease-out;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: var(--text-color);
        line-height: 1.2;
        animation: slideUp 0.8s ease-out 0.2s both;
    }

    .hero-title .highlight {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: clamp(1.2rem, 2.5vw, 1.8rem);
        font-weight: 500;
        margin-bottom: 3rem;
        color: var(--text-muted);
        line-height: 1.6;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        animation: slideUp 0.8s ease-out 0.4s both;
    }

    .hero-cta {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: slideUp 0.8s ease-out 0.6s both;
    }

    .btn-primary-hero {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 1.25rem 3rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.4s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 8px 32px rgba(37, 99, 235, 0.3);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .btn-primary-hero:hover::before {
        left: 100%;
    }

    .btn-primary-hero:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(37, 99, 235, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-hero {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        padding: 1.25rem 3rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.4s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .btn-secondary-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: var(--primary-color);
        transition: width 0.4s ease;
        z-index: -1;
    }

    .btn-secondary-hero:hover::before {
        width: 100%;
    }

    .btn-secondary-hero:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
    }

    /* Modern Slider Navigation */
    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        color: var(--primary-color);
        padding: 1rem;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.4s ease;
        z-index: 3;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider-nav:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 32px rgba(37, 99, 235, 0.3);
    }

    .slider-nav.prev {
        left: 2rem;
    }

    .slider-nav.next {
        right: 2rem;
    }

    .slider-dots {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.75rem;
        z-index: 3;
    }

    .dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        border: none;
        cursor: pointer;
        transition: all 0.4s ease;
        position: relative;
    }

    .dot.active {
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }

    .dot:hover {
        background: white;
        transform: scale(1.2);
    }

    /* Modern Stats Section */
    .stats-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stats-pattern" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23stats-pattern)"/></svg>');
        opacity: 0.5;
    }

    .stats-container {
        position: relative;
        z-index: 2;
    }

    .stat-card {
        text-align: center;
        padding: 2rem 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px);
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.8));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
    }

    .stat-label {
        font-size: 1.1rem;
        font-weight: 600;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Modern Product Search Section */
    .product-search-section {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        padding: 5rem 0;
        position: relative;
    }

    .product-search-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="search-grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(37,99,235,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23search-grid)"/></svg>');
    }

    .search-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .search-intro {
        font-size: 1rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: var(--text-color);
        line-height: 1.2;
    }

    .search-subtitle {
        font-size: 1.3rem;
        margin-bottom: 3rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .search-form {
        max-width: 600px;
        margin: 0 auto 3rem;
    }

    .search-input-container {
        position: relative;
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 60px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        padding: 0.5rem;
    }

    .search-input-container:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 10px 40px rgba(37, 99, 235, 0.15);
        transform: translateY(-2px);
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 1.25rem 2rem;
        font-size: 1.1rem;
        background: transparent;
        color: var(--text-color);
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-input-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 50px;
        padding: 1.25rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 120px;
        justify-content: center;
    }

    .search-input-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
    }

    .search-tags {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .tag-label {
        font-size: 1rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .search-tag {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .search-tag:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        color: white;
        text-decoration: none;
    }

    .search-input-container:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }

    .search-input {
        flex: 1;
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        background: transparent;
        outline: none;
    }

    .search-input-btn {
        background: var(--primary-color);
        border: none;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
        cursor: pointer;
        transition: all var(--transition-duration) ease;
    }

    .search-input-btn:hover {
        background: var(--secondary-color);
    }

    .search-tags {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .tag-label {
        font-weight: 600;
        color: var(--text-color);
    }

    .search-tag {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-size: 0.9rem;
        text-decoration: none;
        transition: all var(--transition-duration) ease;
    }

    .search-tag:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
    }

    .search-filters {
        display: flex;
        gap: 1rem;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-select {
        min-width: 200px;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        background: white;
        color: var(--text-color);
        transition: all var(--transition-duration) ease;
    }

    .search-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }

    .search-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-duration) ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-btn:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
    }

    /* Modern Product Line Section */
    .product-line-section {
        background: white;
        padding: 6rem 0;
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .section-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--accent-color), #10b981);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 20px rgba(74, 222, 128, 0.3);
    }

    .section-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        color: var(--text-color);
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .section-description {
        font-size: 1.2rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .product-categories {
        display: flex;
        gap: 1rem;
        margin-bottom: 4rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .category-btn {
        background: #f1f5f9;
        color: var(--text-color);
        padding: 1rem 2rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .category-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        transition: left 0.3s ease;
        z-index: -1;
    }

    .category-btn:hover::before,
    .category-btn.active::before {
        left: 0;
    }

    .category-btn:hover,
    .category-btn.active {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f5f9;
        position: relative;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .product-card:hover::before {
        opacity: 0.03;
    }

    .product-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
    }

    .product-image {
        position: relative;
        overflow: hidden;
        height: 280px;
        background: #f8fafc;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.08);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.8), rgba(29, 78, 216, 0.8));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-link {
        background: white;
        color: var(--primary-color);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        transform: scale(0.5);
    }

    .product-card:hover .product-link {
        transform: scale(1);
    }

    .product-link:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    .product-info {
        padding: 2rem;
        position: relative;
        z-index: 2;
    }

    .product-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-color);
        line-height: 1.3;
    }

    .product-description {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .product-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .product-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .product-btn:hover::before {
        left: 100%;
    }

    .product-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        color: white;
        text-decoration: none;
    }

    .product-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all var(--transition-duration) ease;
    }

    .product-btn:hover {
        color: var(--secondary-color);
    }

    /* Features Section */
    .features-section {
        background: var(--background-color);
        padding: 4rem 0;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        text-align: center;
        transition: all var(--transition-duration) ease;
        box-shadow: 0 4px 12px var(--shadow-color);
        border: 1px solid var(--border-color);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
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
    }

    .feature-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-color);
    }

    .feature-description {
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Serial Lookup Section */
    .serial-lookup-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 4rem 0;
        text-align: center;
    }

    .serial-lookup-content .section-title {
        color: white;
        margin-bottom: 1rem;
    }

    .serial-lookup-content .section-description {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
    }

    .serial-form {
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .serial-input {
        flex: 1;
        min-width: 250px;
        padding: 1rem 1.5rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        outline: none;
    }

    .serial-btn {
        background: var(--accent-color);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-duration) ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .serial-btn:hover {
        background: #22c55e;
        transform: translateY(-2px);
    }

    /* Industries Section */
    .industries-section {
        background: white;
        padding: 4rem 0;
    }

    .industries-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .industry-card {
        text-align: center;
        padding: 2rem;
        border-radius: var(--border-radius);
        transition: all var(--transition-duration) ease;
        border: 1px solid var(--border-color);
    }

    .industry-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px var(--shadow-color);
    }

    .industry-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        background: var(--background-color);
        color: var(--primary-color);
        font-size: 2rem;
        border: 2px solid var(--border-color);
    }

    .industry-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-color);
    }

    .industry-description {
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Animations */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-content {
            padding: 0 1rem;
        }
        
        .hero-cta {
            flex-direction: column;
            align-items: center;
        }
        
        .slider-nav {
            display: none;
        }
        
        .search-filters {
            flex-direction: column;
            gap: 1rem;
        }
        
        .search-select {
            width: 100%;
            min-width: auto;
        }
        
        .product-grid {
            grid-template-columns: 1fr;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
        }
        
        .industries-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .serial-form {
            flex-direction: column;
        }
        
        .serial-input {
            min-width: auto;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .industries-grid {
            grid-template-columns: 1fr;
        }
        
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .hero-content-section {
            padding: 4rem 0;
            margin-top: -50px;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .hero-cta {
            flex-direction: column;
            gap: 1rem;
        }

        .btn-primary-hero,
        .btn-secondary-hero {
            width: 100%;
            justify-content: center;
        }

        .stats-section {
            padding: 3rem 0;
        }

        .stat-number {
            font-size: 2.5rem;
        }

        .product-search-section {
            padding: 4rem 0;
        }

        .search-title {
            font-size: 2rem;
        }

        .search-input-container {
            flex-direction: column;
            padding: 1rem;
            gap: 1rem;
        }

        .search-input {
            padding: 1rem;
            text-align: center;
        }

        .search-input-btn {
            width: 100%;
        }

        .product-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .product-categories {
            flex-direction: column;
            gap: 0.5rem;
        }

        .category-btn {
            width: 100%;
        }

        .slider-nav {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .slider-nav.prev {
            left: 1rem;
        }

        .slider-nav.next {
            right: 1rem;
        }
    }

    /* RTL Support for Modern Design */
    [dir="rtl"] .hero-content-section {
        text-align: center;
    }

    [dir="rtl"] .hero-cta {
        direction: rtl;
        justify-content: center;
    }

    [dir="rtl"] .slider-nav.prev {
        left: auto;
        right: 2rem;
    }

    [dir="rtl"] .slider-nav.next {
        right: auto;
        left: 2rem;
    }

    [dir="rtl"] .search-input-container {
        direction: rtl;
    }

    [dir="rtl"] .search-input {
        text-align: right;
    }

    [dir="rtl"] .search-tags {
        direction: rtl;
    }

    [dir="rtl"] .product-categories {
        direction: rtl;
    }

    /* Animation improvements */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Modern scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Loading states */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Modern focus states */
    .btn-primary-hero:focus,
    .btn-secondary-hero:focus,
    .search-input-btn:focus,
    .category-btn:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* Scroll Sections Styles */
    .scroll-section {
        position: relative;
        overflow: hidden;
    }

    .scroll-section .content-block {
        padding: 2rem 0;
    }

    .scroll-section .image-block {
        position: relative;
    }

    .scroll-section .image-block::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(37, 99, 235, 0.1), rgba(16, 185, 129, 0.1));
        z-index: 1;
        border-radius: 12px;
    }

    .scroll-section img {
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .scroll-section img:hover {
        transform: scale(1.05);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .feature-item {
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateX(10px);
    }

    .badge-item {
        text-align: center;
        transition: all 0.3s ease;
        background: white;
    }

    .badge-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .stat-item {
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: scale(1.1);
    }

    /* Responsive Design for Scroll Sections */
    @media (max-width: 768px) {
        .scroll-section .row {
            flex-direction: column;
        }
        
        .scroll-section .col-lg-6 {
            margin-bottom: 2rem;
        }

        .scroll-section .order-lg-1,
        .scroll-section .order-lg-2 {
            order: initial;
        }

        .scroll-section img {
            height: 250px !important;
        }

        .display-4 {
            font-size: 2rem;
        }
    }

    /* RTL Support */
    [dir="rtl"] .hero-content {
        text-align: center;
    }

    [dir="rtl"] .hero-cta {
        direction: rtl;
        justify-content: center;
    }

    [dir="rtl"] .hero-title {
        font-family: 'Arial', sans-serif;
        direction: rtl;
    }

    [dir="rtl"] .hero-subtitle,
    [dir="rtl"] .hero-description {
        direction: rtl;
        text-align: center;
    }

    [dir="rtl"] .slider-nav.prev {
        left: auto;
        right: 2rem;
    }

    [dir="rtl"] .slider-nav.next {
        right: auto;
        left: 2rem;
    }

    [dir="rtl"] .search-input-container {
        direction: rtl;
    }

    [dir="rtl"] .search-input {
        text-align: right;
    }

    [dir="rtl"] .search-tags {
        direction: rtl;
    }

    [dir="rtl"] .product-categories {
        direction: rtl;
    }

    [dir="rtl"] .feature-item {
        direction: rtl;
    }

    [dir="rtl"] .feature-item:hover {
        transform: translateX(-10px);
    }

    [dir="rtl"] .stats-grid {
        direction: rtl;
    }

    [dir="rtl"] .quality-badges {
        direction: rtl;
    }

    [dir="rtl"] .future-features {
        direction: rtl;
    }

    [dir="rtl"] .icon-nav {
        direction: rtl;
    }

    [dir="rtl"] .language-toggle-container {
        margin-right: 1rem;
        margin-left: 0;
    }

    /* Arabic font improvements */
    [dir="rtl"] .hero-title,
    [dir="rtl"] .hero-subtitle,
    [dir="rtl"] .hero-description,
    [dir="rtl"] .section-title,
    [dir="rtl"] .section-description,
    [dir="rtl"] .search-title,
    [dir="rtl"] .search-subtitle {
        font-family: 'Arial', 'Tahoma', sans-serif;
    }

    /* Responsive RTL adjustments */
    @media (max-width: 768px) {
        [dir="rtl"] .hero-cta {
            flex-direction: column;
            align-items: center;
        }

        [dir="rtl"] .slider-nav.prev {
            right: 1rem;
        }

        [dir="rtl"] .slider-nav.next {
            left: 1rem;
        }
    }

    /* Typing Effect Cursor */
    .typed-cursor {
        color: var(--primary-color);
        font-weight: 100;
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0; }
    }

    .image-block {
        width: fit-content;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-block img {
        display: block;
        width: 100%;
        height: 400px;
        object-fit: contain;
        background: #fff;
        margin: 0 auto;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.10);
    }
</style>
@endpush

@section('content')
    <!-- Modern Hero Slider Section (No Text) -->
    <section class="hero-slider" id="home">
        <div class="slider-container">
            <!-- Slide 1 -->
            <div class="hero-slide active" data-video="1">
                <video class="slide-video" muted>
                    <source src="{{ asset('videos/1751260750371.webm') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="slide-overlay"></div>
            </div>

            <!-- Slide 2 -->
            <div class="hero-slide" data-video="2">
                <video class="slide-video" muted>
                    <source src="{{ asset('videos/1751260768956.webm') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="slide-overlay"></div>
            </div>

            <!-- Slide 3 -->
            <div class="hero-slide" data-video="3">
                <video class="slide-video" muted>
                    <source src="{{ asset('videos/1751260792190.webm') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="slide-overlay"></div>
            </div>

            <!-- Slide 4 -->
            <div class="hero-slide" data-video="4">
                <video class="slide-video" muted>
                    <source src="{{ asset('videos/WhatsApp Video 2025-07-01 at 21.34.41_559c847d.webm') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="slide-overlay"></div>
            </div>
        </div>

        <!-- Modern Slider Navigation -->
        <button class="slider-nav prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-nav next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Slider Dots -->
        <div class="slider-dots">
            <button class="dot active" onclick="currentSlideIndexSet(1)"></button>
            <button class="dot" onclick="currentSlideIndexSet(2)"></button>
            <button class="dot" onclick="currentSlideIndexSet(3)"></button>
            <button class="dot" onclick="currentSlideIndexSet(4)"></button>
        </div>
    </section>

    <!-- Modern Hero Content Section -->
    <section class="hero-content-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">{{ __('homepage.product_badge') }}</div>
                <h1 class="hero-title">
                    {{ __('homepage.hero_slide_1_title') }} <span class="highlight">{{ __('homepage.hero_slide_1_subtitle') }}</span>
                </h1>
                <p class="hero-subtitle">
                    {{ __('homepage.hero_slide_1_description') }}
                </p>
                <div class="hero-cta">
                    <a href="{{ route('products.index') }}" class="btn-primary-hero">
                        <i class="fas fa-arrow-right"></i>
                        {{ __('homepage.explore_products') }}
                    </a>
                    <a href="{{ route('about') }}" class="btn-secondary-hero">
                        <i class="fas fa-info-circle"></i>
                        {{ __('homepage.learn_more') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">{{ __('homepage.countries_stat') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <span class="stat-number">1000+</span>
                            <span class="stat-label">{{ __('homepage.projects_stat') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">{{ __('homepage.support_stat') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">{{ __('homepage.years_stat') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Scroll Sections -->
    <!-- Section 1: Innovation & Technology -->
    <section class="scroll-section bg-white py-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-delay="200">
                    <div class="content-block">
                        <h2 class="display-4 fw-bold text-primary mb-4">
                            <span id="typed-innovation"></span>
                        </h2>
                        <p class="lead text-muted mb-4">
                            {{ __('homepage.innovation_section_description') }}
                        </p>
                        <div class="features-list">
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('homepage.advanced_hydraulic_tech') }}</span>
                            </div>
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('homepage.precision_engineering') }}</span>
                            </div>
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('homepage.industry_leading_performance') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2" data-aos="fade-left" data-aos-delay="400">
                    <div class="image-block">
                        <img src="{{ asset('images/img2.webp') }}" 
                             alt="Innovation & Technology" 
                             class="img-fluid"
                             style="width: 100%; height: 400px; object-fit: contain; background: none; box-shadow: none; border-radius: 0;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Global Presence -->
    <section class="scroll-section bg-light py-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2" data-aos="fade-left" data-aos-delay="200">
                    <div class="content-block">
                        <h2 class="display-4 fw-bold text-primary mb-4">
                            <span id="typed-global"></span>
                        </h2>
                        <p class="lead text-muted mb-4">
                            {{ __('homepage.global_section_description') }}
                        </p>
                        <div class="stats-grid row">
                            <div class="col-4 text-center">
                                <div class="stat-item">
                                    <h3 class="h2 fw-bold text-primary">50+</h3>
                                    <p class="text-muted">{{ __('homepage.countries_stat') }}</p>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="stat-item">
                                    <h3 class="h2 fw-bold text-primary">1000+</h3>
                                    <p class="text-muted">{{ __('homepage.projects_stat') }}</p>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="stat-item">
                                    <h3 class="h2 fw-bold text-primary">24/7</h3>
                                    <p class="text-muted">{{ __('homepage.support_stat') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-delay="400">
                    <div class="image-block">
                        <img src="{{ asset('images/img3.webp') }}" 
                             alt="Global Presence" 
                             class="img-fluid"
                             style="width: 100%; height: 400px; object-fit: contain; background: none; box-shadow: none; border-radius: 0;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Quality & Reliability -->
    <section class="scroll-section bg-white py-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-delay="200">
                    <div class="content-block">
                        <h2 class="display-4 fw-bold text-primary mb-4">
                            <span id="typed-quality"></span>
                        </h2>
                        <p class="lead text-muted mb-4">
                            {{ __('homepage.quality_section_description') }}
                        </p>
                        <div class="quality-badges row">
                            <div class="col-md-6 mb-3">
                                <div class="badge-item p-3 border rounded">
                                    <i class="fas fa-award text-warning fs-3 mb-2"></i>
                                    <h6 class="fw-bold">{{ __('homepage.iso_certified') }}</h6>
                                    <small class="text-muted">{{ __('homepage.international_standards') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="badge-item p-3 border rounded">
                                    <i class="fas fa-shield-alt text-primary fs-3 mb-2"></i>
                                    <h6 class="fw-bold">{{ __('homepage.quality_assured') }}</h6>
                                    <small class="text-muted">{{ __('homepage.rigorous_testing') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2" data-aos="fade-left" data-aos-delay="400">
                    <div class="image-block">
                        <img src="{{ asset('images/img1.webp') }}" 
                             alt="Quality & Reliability" 
                             class="img-fluid"
                             style="width: 100%; height: 400px; object-fit: contain; background: none; box-shadow: none; border-radius: 0;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Future Vision -->
    <section class="scroll-section bg-gradient-primary text-white py-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2" data-aos="fade-left" data-aos-delay="200">
                    <div class="content-block">
                        <h2 class="display-4 fw-bold mb-4">
                            <span id="typed-future"></span>
                        </h2>
                        <p class="lead mb-4">
                            {{ __('homepage.future_section_description') }}
                        </p>
                        <div class="future-features">
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="fas fa-robot me-3"></i>
                                <span>{{ __('homepage.ai_powered_automation') }}</span>
                            </div>
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="fas fa-leaf me-3"></i>
                                <span>{{ __('homepage.sustainable_solutions') }}</span>
                            </div>
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-satellite me-3"></i>
                                <span>{{ __('homepage.iot_integration') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1" data-aos="fade-right" data-aos-delay="400">
                    <div class="image-block">
                        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Future Vision" 
                             class="img-fluid"
                             style="width: 100%; height: 400px; object-fit: contain; background: none; box-shadow: none; border-radius: 0;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Product Search Section -->
    <section class="product-search-section" id="search">
        <div class="container">
            <div class="search-content">
                <p class="search-intro">{{ __('homepage.search_intro') }}</p>
                <h2 class="search-title">{{ __('homepage.search_title') }}</h2>
                <p class="search-subtitle">{{ __('homepage.search_subtitle') }}</p>
                
                <!-- Modern Search Form -->
                <form action="{{ route('products.index') }}" method="GET" class="search-form">
                    <div class="search-input-container">
                        <input type="text" name="search" class="search-input" placeholder="{{ __('homepage.search_placeholder_text') }}" value="{{ request('search') }}">
                        <button type="submit" class="search-input-btn">
                            <i class="fas fa-search"></i>
                            {{ __('homepage.search_btn') }}
                        </button>
                    </div>
                </form>

                <div class="search-tags">
                    <span class="tag-label">{{ __('homepage.popular_searches') }}</span>
                    <a href="{{ route('products.index', ['search' => 'Hydraulic Breaker']) }}" class="search-tag">{{ __('homepage.hydraulic_breaker') }}</a>
                    <a href="{{ route('products.index', ['search' => 'Rock Drill']) }}" class="search-tag">{{ __('homepage.rock_drill_title') }}</a>
                    <a href="{{ route('products.index', ['search' => 'Crusher']) }}" class="search-tag">{{ __('homepage.crusher_title') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Line Section -->
    <section class="product-line-section" id="products">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">{{ __('homepage.product_badge') }}</span>
                <h2 class="section-title">{{ __('homepage.product_section_title') }}</h2>
                <p class="section-description">{{ __('homepage.product_section_description') }}</p>
            </div>
            
            <div class="product-categories">
                <button class="category-btn active" data-category="all">{{ __('homepage.all_products') }}</button>
                <button class="category-btn" data-category="hydraulic">{{ __('homepage.hydraulic_rock_drill') }}</button>
            </div>

            <div class="product-grid">
                @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                    @foreach($featuredProducts as $product)
                        <div class="product-card" data-category="{{ $product->category ?? 'attachments' }}">
                            <div class="product-image">
                                @if(!empty($product->image_url))
                                    <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}">
                                @elseif($product->getFirstMediaUrl('images'))
                                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->model_name }}">
                                @else
                                    <img src="https://res.cloudinary.com/dikwwdtgc/image/upload/v1751662869/SB10II_side-removebg-preview_lzzibc.png" alt="{{ $product->model_name }}">
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('products.show', $product) }}" class="product-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">{{ $product->model_name }}</h3>
                                <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                                <a href="{{ route('products.show', $product) }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default products when no database products available -->
                    <div class="product-card" data-category="attachments">
                        <div class="product-image">
                            <img src="https://res.cloudinary.com/dikwwdtgc/image/upload/v1751662869/SB10II_side-removebg-preview_lzzibc.png" alt="Hydraulic Breaker">
                            <div class="product-overlay">
                                <a href="{{ route('products.index') }}" class="product-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ __('homepage.hydraulic_breaker_title') }}</h3>
                            <p class="product-description">{{ __('homepage.hydraulic_breaker_description') }}</p>
                            <a href="{{ route('products.index') }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                        </div>
                    </div>

                    <div class="product-card" data-category="attachments">
                        <div class="product-image">
                            <img src="https://res.cloudinary.com/dikwwdtgc/image/upload/v1751662872/SB20II_side-removebg-preview_xnxixz.png" alt="Crusher">
                            <div class="product-overlay">
                                <a href="{{ route('products.index') }}" class="product-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ __('homepage.crusher_title') }}</h3>
                            <p class="product-description">{{ __('homepage.crusher_description') }}</p>
                            <a href="{{ route('products.index') }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                        </div>
                    </div>

                    <div class="product-card" data-category="attachments">
                        <div class="product-image">
                            <img src="https://res.cloudinary.com/dikwwdtgc/image/upload/v1751662872/SB20II_side-removebg-preview_xnxixz.png" alt="Multi Processor">
                            <div class="product-overlay">
                                <a href="{{ route('products.index') }}" class="product-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ __('homepage.multi_processor_title') }}</h3>
                            <p class="product-description">{{ __('homepage.multi_processor_description') }}</p>
                            <a href="{{ route('products.index') }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                        </div>
                    </div>

                    <div class="product-card" data-category="hydraulic">
                        <div class="product-image">
                            <img src="https://res.cloudinary.com/dikwwdtgc/image/upload/v1751662870/SB20II_side_3-pin_removebg_preview_dzqt0r.png" alt="Rock Drill">
                            <div class="product-overlay">
                                <a href="{{ route('products.index') }}" class="product-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ __('homepage.rock_drill_title') }}</h3>
                            <p class="product-description">{{ __('homepage.rock_drill_description') }}</p>
                            <a href="{{ route('products.index') }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                        </div>
                    </div>

                    <div class="product-card" data-category="crane">
                        <div class="product-image">
                            <img src="https://images.pexels.com/photos/834892/pexels-photo-834892.jpeg?auto=compress&cs=tinysrgb&w=400&h=300&fit=crop" alt="Crane System">
                            <div class="product-overlay">
                                <a href="{{ route('products.index') }}" class="product-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ __('homepage.crane_system_title') }}</h3>
                            <p class="product-description">{{ __('homepage.crane_system_description') }}</p>
                            <a href="{{ route('products.index') }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                        </div>
                    </div>

                    <div class="product-card" data-category="aerial">
                        <div class="product-image">
                            <img src="https://images.pexels.com/photos/1108101/pexels-photo-1108101.jpeg?auto=compress&cs=tinysrgb&w=400&h=300&fit=crop" alt="Aerial Platform">
                            <div class="product-overlay">
                                <a href="{{ route('products.index') }}" class="product-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ __('homepage.aerial_platform_title') }}</h3>
                            <p class="product-description">{{ __('homepage.aerial_platform_description') }}</p>
                            <a href="{{ route('products.index') }}" class="product-btn">{{ __('homepage.learn_more_btn') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('homepage.why_choose_title') }}</h2>
                <p class="section-description">{{ __('homepage.features_section_description') }}</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">{{ __('homepage.quality_guaranteed_title') }}</h3>
                    <p class="feature-description">{{ __('homepage.quality_guaranteed_description') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="feature-title">{{ __('homepage.advanced_technology_title') }}</h3>
                    <p class="feature-description">{{ __('homepage.advanced_technology_description') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="feature-title">{{ __('homepage.global_support_title') }}</h3>
                    <p class="feature-description">{{ __('homepage.global_support_description') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">{{ __('homepage.expert_team_title') }}</h3>
                    <p class="feature-description">{{ __('homepage.expert_team_description') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="feature-title">{{ __('homepage.eco_friendly_title') }}</h3>
                    <p class="feature-description">{{ __('homepage.eco_friendly_description') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="feature-title">{{ __('homepage.service_24_7_title') }}</h3>
                    <p class="feature-description">{{ __('homepage.service_24_7_description') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Serial Lookup CTA -->
    <section class="serial-lookup-section" id="warranty">
        <div class="container">
            <div class="serial-lookup-content">
                <h2 class="section-title">{{ __('homepage.warranty_check_title') }}</h2>
                <p class="section-description">{{ __('homepage.warranty_check_description') }}</p>
                <form action="{{ route('serial-lookup.lookup') }}" method="POST" class="serial-form">
                    @csrf
                    <input type="text" name="serial_number" class="serial-input" placeholder="{{ __('homepage.serial_number_placeholder') }}">
                    <button type="submit" class="serial-btn">
                        <i class="fas fa-search"></i>
                        {{ __('homepage.warranty_check_btn') }}
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Industries Section -->
    <section class="industries-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('homepage.industries_title') }}</h2>
                <p class="section-description">{{ __('homepage.industries_description') }}</p>
            </div>

            <div class="industries-grid">
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="industry-title">{{ __('homepage.construction_title') }}</h3>
                    <p class="industry-description">{{ __('homepage.construction_description') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <h3 class="industry-title">{{ __('homepage.mining_title') }}</h3>
                    <p class="industry-description">{{ __('homepage.mining_description') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-road"></i>
                    </div>
                    <h3 class="industry-title">{{ __('homepage.infrastructure_title') }}</h3>
                    <p class="industry-description">{{ __('homepage.infrastructure_description') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="industry-title">{{ __('homepage.energy_title') }}</h3>
                    <p class="industry-description">{{ __('homepage.energy_description') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    let currentSlideIndex = 0;
    let isAutoPlaying = true;
    
    // Enhanced Navbar Scroll Effect
    function initNavbarEffects() {
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
    
    // Enhanced Icon Animations
    function initIconAnimations() {
        const iconItems = document.querySelectorAll('.nav-icon-item');
        
        iconItems.forEach((item, index) => {
            // Add staggered entrance animation
            item.style.animationDelay = `${index * 0.1}s`;
            
            // Add click ripple effect
            item.addEventListener('click', function(e) {
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
                `;
                
                this.appendChild(ripple);
                
                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
            
            // Add hover sound effect (optional)
            item.addEventListener('mouseenter', function() {
                // You can add sound effects here if desired
                this.style.filter = 'drop-shadow(0 4px 8px rgba(37, 99, 235, 0.2))';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.filter = 'none';
            });
        });
    }
    
    // Add CSS for ripple animation
    function addRippleStyles() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .nav-icon-item {
                position: relative;
                overflow: hidden;
            }
            
            @keyframes iconEnter {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.8);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
            
            .icon-nav .nav-icon-item {
                animation: iconEnter 0.6s ease-out forwards;
                opacity: 0;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Slider Navigation
    function changeSlide(direction) {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.dot');
        const videos = document.querySelectorAll('.slide-video');
        
        // Pause current video
        videos[currentSlideIndex].pause();
        
        slides[currentSlideIndex].classList.remove('active');
        dots[currentSlideIndex].classList.remove('active');

        currentSlideIndex = (currentSlideIndex + direction + slides.length) % slides.length;

        slides[currentSlideIndex].classList.add('active');
        dots[currentSlideIndex].classList.add('active');
        
        // Play new video
        playCurrentVideo();
    }

    function currentSlideIndexSet(index) {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.dot');
        const videos = document.querySelectorAll('.slide-video');
        
        // Pause current video
        videos[currentSlideIndex].pause();

        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        currentSlideIndex = index - 1;
        slides[currentSlideIndex].classList.add('active');
        dots[currentSlideIndex].classList.add('active');
        
        // Play new video
        playCurrentVideo();
    }
    
    function playCurrentVideo() {
        const videos = document.querySelectorAll('.slide-video');
        const currentVideo = videos[currentSlideIndex];
        
        if (currentVideo) {
            currentVideo.currentTime = 0; // Reset to beginning
            currentVideo.play().catch(e => {
                console.log('Video autoplay failed:', e);
                // If autoplay fails, try without sound first
                currentVideo.muted = true;
                currentVideo.play();
            });
        }
    }
    
    function nextSlide() {
        if (isAutoPlaying) {
            changeSlide(1);
        }
    }
    
    function setupVideoSlider() {
        const videos = document.querySelectorAll('.slide-video');
        
        videos.forEach((video, index) => {
            // When video ends, go to next slide
            video.addEventListener('ended', () => {
                if (index === currentSlideIndex && isAutoPlaying) {
                    setTimeout(nextSlide, 500); // Small delay before next slide
                }
            });
            
            // Handle video loading
            video.addEventListener('loadeddata', () => {
                if (index === currentSlideIndex) {
                    playCurrentVideo();
                }
            });
            
            // Handle video errors
            video.addEventListener('error', (e) => {
                console.log(`Video ${index + 1} error:`, e);
                console.log(`Video src: ${video.src}`);
                // If video fails, advance to next slide after 3 seconds
                if (index === currentSlideIndex) {
                    setTimeout(nextSlide, 3000);
                }
            });
            
            // Add load start event for debugging
            video.addEventListener('loadstart', () => {
                console.log(`Video ${index + 1} started loading`);
            });
            
            // Add can play event
            video.addEventListener('canplay', () => {
                console.log(`Video ${index + 1} can play`);
            });
        });
        
        // Start playing the first video
        playCurrentVideo();
    }

    // Product Category Filter
    function initProductFilter() {
        const categoryBtns = document.querySelectorAll('.category-btn');
        const productCards = document.querySelectorAll('.product-card');

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                categoryBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const category = btn.dataset.category;
                productCards.forEach(card => {
                    card.style.display = category === 'all' || card.dataset.category === category ? 'block' : 'none';
                });
            });
        });
    }
    
    // Pause/Resume auto-play when user interacts
    document.addEventListener('click', (e) => {
        if (e.target.closest('.slider-nav') || e.target.closest('.dot')) {
            isAutoPlaying = false;
            // Resume auto-play after 10 seconds of no interaction
            setTimeout(() => {
                isAutoPlaying = true;
            }, 10000);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        initNavbarEffects();
        initIconAnimations();
        addRippleStyles();
        initProductFilter();
        setupVideoSlider();
        
        // Handle visibility change (pause videos when tab is not active)
        document.addEventListener('visibilitychange', () => {
            const videos = document.querySelectorAll('.slide-video');
            if (document.hidden) {
                videos.forEach(video => video.pause());
                isAutoPlaying = false;
            } else {
                isAutoPlaying = true;
                playCurrentVideo();
            }
        });
    });
</script>

<!-- AOS and Typed.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Initialize Typed.js for each section
    document.addEventListener('DOMContentLoaded', function() {
        // Innovation section typing
        const innovationTyped = new Typed('#typed-innovation', {
            strings: [
                '{{ __("homepage.typing_innovation_1") }}', 
                '{{ __("homepage.typing_innovation_2") }}', 
                '{{ __("homepage.typing_innovation_3") }}'
            ],
            typeSpeed: 60,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: '|'
        });

        // Global section typing
        const globalTyped = new Typed('#typed-global', {
            strings: [
                '{{ __("homepage.typing_global_1") }}', 
                '{{ __("homepage.typing_global_2") }}', 
                '{{ __("homepage.typing_global_3") }}'
            ],
            typeSpeed: 60,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: '|',
            startDelay: 500
        });

        // Quality section typing
        const qualityTyped = new Typed('#typed-quality', {
            strings: [
                '{{ __("homepage.typing_quality_1") }}', 
                '{{ __("homepage.typing_quality_2") }}', 
                '{{ __("homepage.typing_quality_3") }}'
            ],
            typeSpeed: 60,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: '|',
            startDelay: 1000
        });

        // Future section typing
        const futureTyped = new Typed('#typed-future', {
            strings: [
                '{{ __("homepage.typing_future_1") }}', 
                '{{ __("homepage.typing_future_2") }}', 
                '{{ __("homepage.typing_future_3") }}'
            ],
            typeSpeed: 60,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: '|',
            startDelay: 1500
        });

        // Add smooth scrolling for better UX
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

        // Add scroll reveal animations
        const scrollElements = document.querySelectorAll('.scroll-section');
        
        const elementInView = (el, percentageScroll = 100) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <= 
                ((window.innerHeight || document.documentElement.clientHeight) * (percentageScroll/100))
            );
        };

        const displayScrollElement = (element) => {
            element.classList.add('scrolled');
        };

        const hideScrollElement = (element) => {
            element.classList.remove('scrolled');
        };

        const handleScrollAnimation = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 80)) {
                    displayScrollElement(el);
                } else {
                    hideScrollElement(el);
                }
            });
        };

        window.addEventListener('scroll', () => {
            handleScrollAnimation();
        });

        // Initialize on load
        handleScrollAnimation();
    });
</script>
@endpush