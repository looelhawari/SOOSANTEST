@extends('layouts.admin')

@section('title', __('products.product_details'))
@section('page-title', __('products.product_details'))

@push('styles')
<style>
    /* Reset and Base Styles */
    .modern-container * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    .modern-container {
        font-family: 'Poppins', sans-serif;
        background: #F9F9F9;
        min-height: 100vh;
        padding: 1.5rem;
        color: #333333;
        line-height: 1.6;
    }
    .dark-mode .modern-container {
        background: #212121;
        color: #F0F0F0;
    }

    /* Page Header */
    .modern-page-header {
        background: #0077C8;
        color: #F0F0F0;
        padding: 2.5rem 0;
        margin: -1.5rem -1.5rem 2rem;
        border-radius: 0 0 12px 12px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .modern-page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        z-index: 0;
    }
    .modern-page-header .container-fluid {
        position: relative;
        z-index: 1;
    }
    .modern-page-header h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: #F0F0F0;
        margin-bottom: 0.5rem;
    }
    .modern-page-header p {
        font-size: 1rem;
        color: #F0F0F0;
        opacity: 0.9;
        margin-bottom: 0;
    }
    .dark-mode .modern-page-header {
        background: #005B99;
    }
    .modern-header-actions {
        display: flex;
        gap: 1rem;
    }

    /* Main Content */
    .modern-content {
        max-width: 1200px;
        margin: 0 auto;
        animation: fadeInUp 0.6s ease forwards;
    }
    .modern-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Card Styles */
    .modern-card {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    .dark-mode .modern-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-card-header {
        background: #F9F9F9;
        padding: 1.5rem;
        border-bottom: 1px solid #E9ECEF;
    }
    .dark-mode .modern-card-header {
        background: #2D2D2D;
        border-bottom-color: #4A4A4A;
    }
    .modern-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #333333;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .dark-mode .modern-card-title {
        color: #F0F0F0;
    }
    .modern-card-icon {
        width: 24px;
        height: 24px;
        color: #0077C8;
    }
    .dark-mode .modern-card-icon {
        color: #C1D82F;
    }
    .modern-card-body {
        padding: 1.5rem;
    }

    /* Specifications Grid */
    .modern-specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .modern-spec-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .modern-spec-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #E9ECEF;
    }
    .dark-mode .modern-spec-item {
        border-bottom-color: #4A4A4A;
    }
    .modern-spec-item:last-child {
        border-bottom: none;
    }
    .modern-spec-label {
        font-weight: 600;
        color: #6C757D;
        font-size: 0.9rem;
    }
    .dark-mode .modern-spec-label {
        color: #A0AEC0;
    }
    .modern-spec-value {
        color: #333333;
        font-weight: 500;
        text-align: right;
    }
    .dark-mode .modern-spec-value {
        color: #F0F0F0;
    }

    /* Status Badges */
    .modern-status-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .modern-status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
    }
    .modern-status-badge:hover {
        transform: scale(1.05);
    }
    .modern-status-badge.active {
        background: #10B981;
        color: #FFFFFF;
    }
    .dark-mode .modern-status-badge.active {
        background: #34D399;
    }
    .modern-status-badge.inactive {
        background: #E53935;
        color: #FFFFFF;
    }
    .modern-status-badge.featured {
        background: #C1D82F;
        color: #333333;
    }
    .modern-status-badge.normal {
        background: #E9ECEF;
        color: #6C757D;
    }
    .dark-mode .modern-status-badge.normal {
        background: #4A4A4A;
        color: #A0AEC0;
    }

    /* Image Container */
    .modern-image-container {
        background: #F9F9F9;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1.5rem;
        text-align: center;
    }
    .dark-mode .modern-image-container {
        background: #2D2D2D;
    }
    .modern-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .modern-image:hover {
        transform: scale(1.02);
    }
    .modern-no-image {
        padding: 2rem 1rem;
        color: #6C757D;
        background: #F9F9F9;
        border-radius: 8px;
        border: 2px dashed #E9ECEF;
        text-align: center;
    }
    .dark-mode .modern-no-image {
        color: #A0AEC0;
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-no-image-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        color: #E9ECEF;
    }
    .dark-mode .modern-no-image-icon {
        color: #4A4A4A;
    }
    .modern-image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    .modern-image-grid img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .modern-image-grid img:hover {
        transform: scale(1.05);
    }

    /* Metadata */
    .modern-metadata {
        padding: 1rem 0;
        border-top: 1px solid #E9ECEF;
        margin-top: 1rem;
    }
    .dark-mode .modern-metadata {
        border-top-color: #4A4A4A;
    }
    .modern-metadata-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }
    .modern-metadata-label {
        color: #6C757D;
        font-weight: 500;
    }
    .dark-mode .modern-metadata-label {
        color: #A0AEC0;
    }
    .modern-metadata-value {
        color: #333333;
        font-weight: 500;
    }
    .dark-mode .modern-metadata-value {
        color: #F0F0F0;
    }

    /* Buttons */
    .modern-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
    }
    .modern-btn-primary {
        background: #0077C8;
        color: #F0F0F0;
        box-shadow: 0 4px 12px rgba(0, 119, 200, 0.3);
    }
    .modern-btn-primary:hover {
        background: #C1D82F;
        color: #333333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193, 216, 47, 0.3);
    }
    .modern-btn-secondary {
        background: #FFFFFF;
        color: #6C757D;
        border: 2px solid #E9ECEF;
    }
    .dark-mode .modern-btn-secondary {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #A0AEC0;
    }
    .modern-btn-secondary:hover {
        background: #C1D82F;
        color: #333333;
        border-color: #C1D82F;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(193, 216, 47, 0.3);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(193, 216, 47, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(193, 216, 47, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(193, 216, 47, 0);
        }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .modern-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        .modern-specs-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .modern-container {
            padding: 1rem;
        }
        .modern-page-header {
            margin: -1rem -1rem 1.5rem;
            padding: 1.5rem 0;
        }
        .modern-page-header h1 {
            font-size: 1.5rem;
        }
        .modern-header-actions {
            flex-direction: column;
            width: 100%;
        }
        .modern-btn {
            width: 100%;
            justify-content: center;
        }
        .modern-status-badges {
            flex-direction: column;
            align-items: stretch;
        }
        .modern-status-badge {
            text-align: center;
        }
    }
    @media (max-width: 576px) {
        .modern-page-header h1 {
            font-size: 1.25rem;
        }
        .modern-page-header p {
            font-size: 0.9rem;
        }
        .modern-card-title {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="modern-container">
    <!-- Header -->
    <div class="modern-page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>{{ $product->model_name }}</h1>
                    <p>{{ __('products.product_details_specifications') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="modern-header-actions">
                        <a href="{{ route('admin.products.edit', $product) }}" class="modern-btn modern-btn-primary">
                            <svg class="modern-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('products.edit_product') }}
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="modern-btn modern-btn-secondary">
                            <svg class="modern-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('products.back_to_products') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="modern-content">
        <div class="modern-grid">
            <!-- Product Information -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <h2 class="modern-card-title">
                        <svg class="modern-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('products.product_specifications') }}
                    </h2>
                </div>
                <div class="modern-card-body">
                    <div class="modern-specs-grid">
                        <div class="modern-spec-group">
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.model_name') }}</span>
                                <span class="modern-spec-value">{{ $product->model_name }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.price') }}</span>
                                <span class="modern-spec-value">{{ $product->price ? number_format($product->price, 2) : __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.line') }}</span>
                                <span class="modern-spec-value">{{ $product->line ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.type') }}</span>
                                <span class="modern-spec-value">{{ $product->type ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.category') }}</span>
                                <span class="modern-spec-value">{{ $product->category->name ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.body_weight') }}</span>
                                <span class="modern-spec-value">{{ $product->body_weight ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.operating_weight') }}</span>
                                <span class="modern-spec-value">{{ $product->operating_weight ?? __('products.n_a') }}</span>
                            </div>
                        </div>
                        <div class="modern-spec-group">
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.overall_length') }}</span>
                                <span class="modern-spec-value">{{ $product->overall_length ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.overall_width') }}</span>
                                <span class="modern-spec-value">{{ $product->overall_width ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.overall_height') }}</span>
                                <span class="modern-spec-value">{{ $product->overall_height ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.required_oil_flow') }}</span>
                                <span class="modern-spec-value">{{ $product->required_oil_flow ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.operating_pressure') }}</span>
                                <span class="modern-spec-value">{{ $product->operating_pressure ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.impact_rate') }}</span>
                                <span class="modern-spec-value">{{ $product->impact_rate ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.impact_rate_soft_rock') }}</span>
                                <span class="modern-spec-value">{{ $product->impact_rate_soft_rock ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.hose_diameter') }}</span>
                                <span class="modern-spec-value">{{ $product->hose_diameter ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.rod_diameter') }}</span>
                                <span class="modern-spec-value">{{ $product->rod_diameter ?? __('products.n_a') }}</span>
                            </div>
                            <div class="modern-spec-item">
                                <span class="modern-spec-label">{{ __('products.applicable_carrier') }}</span>
                                <span class="modern-spec-value">{{ $product->applicable_carrier ?? __('products.n_a') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Images -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <h2 class="modern-card-title">
                        <svg class="modern-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('products.status_details') }}
                    </h2>
                </div>
                <div class="modern-card-body">
                    <div class="modern-status-badges">
                        <span class="modern-status-badge {{ $product->status == 'active' ? 'active' : 'inactive' }}">
                            {{ $product->status == 'active' ? __('products.active') : __('products.inactive') }}
                        </span>
                        <span class="modern-status-badge {{ $product->is_featured ? 'featured' : 'normal' }}">
                            {{ $product->is_featured ? __('products.featured') : __('products.normal') }}
                        </span>
                    </div>
                    <div class="modern-metadata">
                        <div class="modern-metadata-item">
                            <span class="modern-metadata-label">{{ __('products.created') }}</span>
                            <span class="modern-metadata-value">{{ $product->created_at ? $product->created_at->format('M d, Y H:i') : __('products.n_a') }}</span>
                        </div>
                        <div class="modern-metadata-item">
                            <span class="modern-metadata-label">{{ __('products.updated') }}</span>
                            <span class="modern-metadata-value">{{ $product->updated_at ? $product->updated_at->format('M d, Y H:i') : __('products.n_a') }}</span>
                        </div>
                    </div>
                    <div class="modern-image-container">
                       @if($product->image_url)
                            <div class="modern-image-wrapper">
                                <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}" class="modern-product-image" loading="lazy">
                            </div>
                        @else
                            <div class="modern-no-image">
                                <svg class="modern-no-image-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p>{{ __('products.no_image_available') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection