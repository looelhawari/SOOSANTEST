@extends('layouts.admin')

@section('title', __('products.title'))
@section('page-title', __('products.title'))

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
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    /* Modern Card */
    .modern-card {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }
    .dark-mode .modern-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }

    /* Stats Cards */
    .modern-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .modern-stat-card {
        background: #FFFFFF;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        transition: all 0.3s ease;
        position: relative;
    }
    .modern-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #0077C8;
    }
    .modern-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }
    .dark-mode .modern-stat-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .dark-mode .modern-stat-card::before {
        background: #C1D82F;
    }
    .modern-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #F0F0F0;
        background: #0077C8;
    }
    .modern-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .modern-stat-content h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333333;
        margin-bottom: 0.25rem;
    }
    .dark-mode .modern-stat-content h3 {
        color: #F0F0F0;
    }
    .modern-stat-content p {
        color: #6C757D;
        font-size: 0.85rem;
        margin: 0;
    }
    .dark-mode .modern-stat-content p {
        color: #A0AEC0;
    }

    /* Search and Filter Controls */
    .modern-controls {
        background: #FFFFFF;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        margin-bottom: 2rem;
    }
    .dark-mode .modern-controls {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-controls-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #E9ECEF;
    }
    .dark-mode .modern-controls-header {
        border-bottom: 1px solid #4A4A4A;
    }
    .modern-controls-header i {
        color: #0077C8;
        font-size: 1.25rem;
    }
    .dark-mode .modern-controls-header i {
        color: #C1D82F;
    }
    .modern-controls-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #333333;
        margin: 0;
    }
    .dark-mode .modern-controls-header h3 {
        color: #F0F0F0;
    }
    .modern-filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }
    .modern-form-group label {
        font-weight: 600;
        color: #333333;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }
    .dark-mode .modern-form-group label {
        color: #F0F0F0;
    }
    .modern-form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #E9ECEF;
        border-radius: 8px;
        background: #FFFFFF;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #333333;
        transition: all 0.3s ease;
    }
    .modern-form-control:focus {
        border-color: #C1D82F;
        box-shadow: 0 0 0 0.2rem rgba(193, 216, 47, 0.25);
        outline: none;
    }
    .dark-mode .modern-form-control {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .dark-mode .modern-form-control::placeholder {
        color: #A0AEC0;
    }
    .modern-form-control.select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23333333' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em 1.25em;
        padding-right: 2.5rem;
    }
    .dark-mode .modern-form-control.select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23F0F0F0' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }

    /* Buttons */
    .modern-btn {
        background: #0077C8;
        border: none;
        color: #F0F0F0;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .modern-btn:hover {
        background: #C1D82F;
        color: #333333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193, 216, 47, 0.3);
    }
    .modern-btn-secondary {
        background: #6C757D;
        color: #F0F0F0;
        border: 1px solid #E9ECEF;
    }
    .modern-btn-secondary:hover {
        background: #C1D82F;
        color: #333333;
        box-shadow: 0 4px 12px rgba(193, 216, 47, 0.3);
    }
    .dark-mode .modern-btn-secondary {
        background: #4A4A4A;
        border-color: #4A4A4A;
    }

    /* Employee Notice */
    .modern-notice {
        background: #FFF8E1;
        border-left: 4px solid #C1D82F;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .dark-mode .modern-notice {
        background: #3B3B3B;
        border-left-color: #C1D82F;
    }
    .modern-notice i {
        color: #C1D82F;
        font-size: 1.25rem;
    }
    .modern-notice h4 {
        color: #333333;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
        font-weight: 600;
    }
    .dark-mode .modern-notice h4 {
        color: #F0F0F0;
    }
    .modern-notice p {
        color: #333333;
        margin: 0;
        font-size: 0.85rem;
    }
    .dark-mode .modern-notice p {
        color: #A0AEC0;
    }

    /* Product Grid */
    .modern-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .modern-product-card {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease forwards;
    }
    .modern-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    .dark-mode .modern-product-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-product-card:nth-child(2) { animation-delay: 0.1s; }
    .modern-product-card:nth-child(3) { animation-delay: 0.2s; }
    .modern-product-card:nth-child(4) { animation-delay: 0.3s; }
    .modern-product-card:nth-child(5) { animation-delay: 0.4s; }
    .modern-product-card:nth-child(6) { animation-delay: 0.5s; }

    /* Product Image */
    .modern-image {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #F9F9F9;
        border-radius: 8px 8px 0 0;
    }
    .dark-mode .modern-image {
        background: #2D2D2D;
    }
    .modern-image-wrapper {
        width: 100%;
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F9F9F9;
        border-radius: 8px;
    }
    .dark-mode .modern-image-wrapper {
        background: #2D2D2D;
    }
    .modern-product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    .modern-product-card:hover .modern-product-image {
        transform: scale(1.05);
    }
    .modern-image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #6C757D;
        font-size: 2.5rem;
        gap: 0.5rem;
    }
    .dark-mode .modern-image-placeholder {
        color: #A0AEC0;
    }
    .modern-image-placeholder span {
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Status Badges */
    .modern-status-badges {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .modern-status {
        padding: 0.375rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .modern-status.active {
        background: rgba(16, 185, 129, 0.9);
        color: #F0F0F0;
    }
    .modern-status.inactive {
        background: rgba(229, 57, 53, 0.9);
        color: #F0F0F0;
    }
    .modern-status.featured {
        background: rgba(193, 216, 47, 0.9);
        color: #333333;
    }

    /* Product Content */
    .modern-content {
        padding: 1.5rem;
    }
    .modern-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #333333;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dark-mode .modern-card-title {
        color: #F0F0F0;
    }
    .modern-category {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: rgba(0, 119, 200, 0.1);
        color: #0077C8;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .dark-mode .modern-category {
        background: rgba(193, 216, 47, 0.2);
        color: #C1D82F;
    }
    .modern-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin: 1rem 0;
        padding: 1rem;
        background: #F9F9F9;
        border-radius: 8px;
    }
    .dark-mode .modern-details {
        background: #2D2D2D;
    }
    .modern-detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
    }
    .modern-detail-item i {
        color: #0077C8;
        width: 16px;
        flex-shrink: 0;
    }
    .dark-mode .modern-detail-item i {
        color: #C1D82F;
    }
    .modern-detail-label {
        color: #6C757D;
        font-weight: 500;
        min-width: 50px;
    }
    .dark-mode .modern-detail-label {
        color: #A0AEC0;
    }
    .modern-detail-value {
        font-weight: 600;
        color: #333333;
    }
    .dark-mode .modern-detail-value {
        color: #F0F0F0;
    }

    /* Product Actions */
    .modern-actions {
        display: flex;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        background: #F9F9F9;
        border-top: 1px solid #E9ECEF;
    }
    .dark-mode .modern-actions {
        background: #2D2D2D;
        border-top: 1px solid #4A4A4A;
    }
    .modern-action-btn {
        flex: 1;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .modern-action-btn.view {
        background: rgba(0, 119, 200, 0.1);
        color: #0077C8;
        border: 1px solid rgba(0, 119, 200, 0.3);
    }
    .modern-action-btn.view:hover {
        background: #0077C8;
        color: #F0F0F0;
    }
    .modern-action-btn.edit {
        background: rgba(193, 216, 47, 0.1);
        color: #C1D82F;
        border: 1px solid rgba(193, 216, 47, 0.3);
    }
    .modern-action-btn.edit:hover {
        background: #C1D82F;
        color: #333333;
    }
    .modern-action-btn.delete {
        background: rgba(229, 57, 53, 0.1);
        color: #E53935;
        border: 1px solid rgba(229, 57, 53, 0.3);
    }
    .modern-action-btn.delete:hover {
        background: #E53935;
        color: #F0F0F0;
    }
    .modern-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Product Footer */
    .modern-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #E9ECEF;
        background: #F9F9F9;
    }
    .dark-mode .modern-footer {
        border-top: 1px solid #4A4A4A;
        background: #2D2D2D;
    }
    .modern-created-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6C757D;
        font-size: 0.75rem;
    }
    .dark-mode .modern-created-date {
        color: #A0AEC0;
    }
    .modern-created-date i {
        color: #0077C8;
    }
    .dark-mode .modern-created-date i {
        color: #C1D82F;
    }

    /* Pagination */
    .modern-pagination-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0;
        padding: 1.5rem;
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
    }
    .dark-mode .modern-pagination-wrapper {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.5rem;
        align-items: center;
    }
    .modern-pagination-wrapper .page-item {
        margin: 0;
        list-style: none;
    }
    .modern-pagination-wrapper .page-item.active .page-link {
        color: #F0F0F0;
        background: #0077C8;
        border-color: #0077C8;
        box-shadow: 0 4px 12px rgba(0, 119, 200, 0.3);
        font-weight: 600;
    }
    .dark-mode .modern-pagination-wrapper .page-item.active .page-link {
        background: #C1D82F;
        border-color: #C1D82F;
        color: #333333;
    }
    .modern-pagination-wrapper .page-item.disabled .page-link {
        color: #6C757D;
        pointer-events: none;
        background: #F9F9F9;
        border-color: #E9ECEF;
        opacity: 0.6;
        cursor: not-allowed;
    }
    .dark-mode .modern-pagination-wrapper .page-item.disabled .page-link {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #A0AEC0;
    }
    .modern-pagination-wrapper .page-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        color: #333333;
        text-decoration: none;
        background: #FFFFFF;
        border: 2px solid #E9ECEF;
        border-radius: 8px;
        transition: all 0.3s ease;
        min-width: 40px;
        font-weight: 500;
        justify-content: center;
    }
    .dark-mode .modern-pagination-wrapper .page-link {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .modern-pagination-wrapper .page-link:hover {
        color: #0077C8;
        background: #F9F9F9;
        border-color: #0077C8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 119, 200, 0.2);
    }
    .dark-mode .modern-pagination-wrapper .page-link:hover {
        color: #C1D82F;
        background: #3B3B3B;
        border-color: #C1D82F;
    }
    .pagination-info {
        font-size: 0.85rem;
        color: #6C757D;
        font-weight: 500;
        text-align: center;
    }
    .dark-mode .pagination-info {
        color: #A0AEC0;
    }

    /* Empty State */
    .modern-empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
    }
    .dark-mode .modern-empty-state {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: #0077C8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F0F0F0;
        font-size: 1.75rem;
    }
    .dark-mode .modern-empty-icon {
        background: #C1D82F;
        color: #333333;
    }
    .modern-empty-state h3 {
        color: #333333;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .dark-mode .modern-empty-state h3 {
        color: #F0F0F0;
    }
    .modern-empty-state p {
        color: #6C757D;
        margin-bottom: 1.5rem;
    }
    .dark-mode .modern-empty-state p {
        color: #A0AEC0;
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

    /* Responsive */
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
        .modern-filter-grid {
            grid-template-columns: 1fr;
        }
        .modern-grid {
            grid-template-columns: 1fr;
        }
        .modern-image, .modern-image-wrapper {
            height: 160px;
        }
        .modern-stats {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 576px) {
        .modern-actions {
            flex-direction: column;
        }
        .modern-action-btn {
            width: 100%;
        }
        .modern-page-header .container-fluid {
            padding: 0 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="modern-container">
    <!-- Page Header -->
    <div class="modern-page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-cubes"></i> {{ __('products.products_management') }}</h1>
                    <p>{{ __('products.manage_products') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.products.create') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-plus"></i>
                        {{ __('products.add_product') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->isEmployee())
        <!-- Employee Notice -->
        <div class="modern-notice">
            <i class="fas fa-info-circle"></i>
            <div>
                <h4>{{ __('products.employee_access') }}</h4>
                <p>{{ __('products.employee_access_desc') }}</p>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="modern-stats">
        <div class="modern-stat-card">
            <div class="modern-stat-header">
                <div class="modern-stat-icon">
                    <i class="fas fa-cubes"></i>
                </div>
            </div>
            <div class="modern-stat-content">
                <h3>{{ $products->total() }}</h3>
                <p>{{ __('products.total_products') }}</p>
            </div>
        </div>
        
        <div class="modern-stat-card">
            <div class="modern-stat-header">
                <div class="modern-stat-icon" style="background: #10B981;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="modern-stat-content">
                <h3>{{ $products->where('status', 'active')->count() }}</h3>
                <p>{{ __('products.active_products') }}</p>
            </div>
        </div>
        
        <div class="modern-stat-card">
            <div class="modern-stat-header">
                <div class="modern-stat-icon" style="background: #C1D82F;">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="modern-stat-content">
                <h3>{{ $products->where('is_featured', true)->count() }}</h3>
                <p>{{ __('products.featured_products') }}</p>
            </div>
        </div>
        
        <div class="modern-stat-card">
            <div class="modern-stat-header">
                <div class="modern-stat-icon" style="background: #0077C8;">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
            <div class="modern-stat-content">
                <h3>{{ $categories->count() }}</h3>
                <p>{{ __('products.categories') }}</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="modern-controls">
        <div class="modern-controls-header">
            <i class="fas fa-search"></i>
            <h3>{{ __('products.search_filter_products') }}</h3>
        </div>
        
        <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
            <div class="modern-filter-grid">
                <div class="modern-form-group">
                    <label for="search">{{ __('products.search_products') }}</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           class="modern-form-control" 
                           placeholder="{{ __('products.search_placeholder') }}"
                           value="{{ request('search') }}">
                </div>
                
                <div class="modern-form-group">
                    <label for="category_filter">{{ __('products.category') }}</label>
                    <select id="category_filter" name="category" class="modern-form-control select">
                        <option value="">{{ __('products.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="modern-form-group">
                    <label for="status_filter">{{ __('products.status') }}</label>
                    <select id="status_filter" name="status" class="modern-form-control select">
                        <option value="">{{ __('products.all_status') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('products.active') }}</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('products.inactive') }}</option>
                    </select>
                </div>
                
                <button type="submit" class="modern-btn">
                    <i class="fas fa-search"></i> {{ __('products.search') }}
                </button>
            </div>
        </form>
    </div>

    @if($products->count() > 0)
        <!-- Products Grid -->
        <div class="modern-grid">
            @foreach($products as $product)
                <div class="modern-product-card">
                    <!-- Product Image -->
                    <div class="modern-image">
                        @if($product->image_url)
                            <div class="modern-image-wrapper">
                                <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}" class="modern-product-image" loading="lazy">
                            </div>
                        @else
                            <div class="modern-image-placeholder">
                                <i class="fas fa-image"></i>
                                <span>{{ __('products.no_image') }}</span>
                            </div>
                        @endif
                        
                        <!-- Status Badges -->
                        <div class="modern-status-badges">
                            @if($product->is_featured)
                                <div class="modern-status featured">
                                    <i class="fas fa-star"></i>
                                    {{ __('products.featured') }}
                                </div>
                            @endif
                            <div class="modern-status {{ $product->is_active ? 'active' : 'inactive' }}">
                                {{ $product->is_active ? __('products.active') : __('products.inactive') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Content -->
                    <div class="modern-content">
                        <h4 class="modern-card-title">{{ $product->model_name }}</h4>
                        
                        @if($product->category)
                            <span class="modern-category">
                                <i class="fas fa-tag"></i>
                                {{ $product->category->name }}
                            </span>
                        @endif
                        
                        <!-- Product Details -->
                        <div class="modern-details">
                            @if($product->line)
                                <div class="modern-detail-item">
                                    <i class="fas fa-layer-group"></i>
                                    <span class="modern-detail-label">{{ __('products.line') }}:</span>
                                    <span class="modern-detail-value">{{ $product->line }}</span>
                                </div>
                            @endif
                            @if($product->type)
                                <div class="modern-detail-item">
                                    <i class="fas fa-tools"></i>
                                    <span class="modern-detail-label">{{ __('products.type') }}:</span>
                                    <span class="modern-detail-value">{{ $product->type }}</span>
                                </div>
                            @endif
                            @if($product->body_weight)
                                <div class="modern-detail-item">
                                    <i class="fas fa-weight-hanging"></i>
                                    <span class="modern-detail-label">{{ __('products.weight') }}:</span>
                                    <span class="modern-detail-value">{{ $product->body_weight }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Product Actions -->
                    <div class="modern-actions">
                        <a href="{{ route('admin.products.show', $product) }}" class="modern-action-btn view">
                            <i class="fas fa-eye"></i> {{ __('products.view') }}
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="modern-action-btn edit">
                            <i class="fas fa-edit"></i> {{ __('products.edit') }}
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                              style="display: inline; flex: 1;" 
                              onsubmit="return confirm('{{ __('products.delete_confirmation') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="modern-action-btn delete" style="width: 100%;">
                                <i class="fas fa-trash"></i> {{ __('products.delete') }}
                            </button>
                        </form>
                    </div>
                    
                    <!-- Product Footer -->
                    <div class="modern-footer">
                        <div class="modern-created-date">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $product->created_at ? $product->created_at->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
            <div class="modern-pagination-wrapper">
                <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                                {{ __('products.previous') }}
                            </span>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="page-item">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                                {{ __('products.previous') }}
                            </span>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = max($products->currentPage() - 2, 1);
                        $end = min($start + 4, $products->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    {{-- First page link --}}
                    @if($start > 1)
                        <a href="{{ $products->url(1) }}" class="page-item">
                            <span class="page-link">1</span>
                        </a>
                        @if($start > 2)
                            <span class="page-item disabled">
                                <span class="page-link">...</span>
                            </span>
                        @endif
                    @endif

                    {{-- Page links --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $products->currentPage())
                            <span class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $products->url($page) }}" class="page-item">
                                <span class="page-link">{{ $page }}</span>
                            </a>
                        @endif
                    @endfor

                    {{-- Last page link --}}
                    @if($end < $products->lastPage())
                        @if($end < $products->lastPage() - 1)
                            <span class="page-item disabled">
                                <span class="page-link">...</span>
                            </span>
                        @endif
                        <a href="{{ $products->url($products->lastPage()) }}" class="page-item">
                            <span class="page-link">{{ $products->lastPage() }}</span>
                        </a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="page-item">
                            <span class="page-link">
                                {{ __('products.next') }}
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </a>
                    @else
                        <span class="page-item disabled">
                            <span class="page-link">
                                {{ __('products.next') }}
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </span>
                    @endif
                </nav>
                
                <div class="pagination-info">
                    {{ __('products.showing_results', ['first' => $products->firstItem(), 'last' => $products->lastItem(), 'total' => $products->total()]) }}
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="modern-empty-state">
            <div class="modern-empty-icon">
                <i class="fas fa-cubes"></i>
            </div>
            <h3>{{ __('products.no_products_found') }}</h3>
            <p>{{ __('products.start_building_catalog') }}</p>
            <a href="{{ route('admin.products.create') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-plus"></i>
                {{ __('products.add_first_product') }}
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    const filterForm = document.getElementById('filterForm');
    const filterInputs = filterForm.querySelectorAll('select');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            filterForm.submit();
        });
    });

    // Add loading state to forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.dataset.noLoading) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('products.processing') }}';
            }
        });
    });

    // Confirmation for delete actions
    document.querySelectorAll('form[method="POST"]').forEach(form => {
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput && methodInput.value === 'DELETE') {
            form.addEventListener('submit', function(e) {
                if (!confirm('{{ __('products.delete_cannot_undone') }}')) {
                    e.preventDefault();
                }
            });
        }
    });

    // Auto-hide alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            if (alert.style) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);

    // Enhanced focus effects
    const inputs = document.querySelectorAll('.modern-form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
});
</script>
@endpush
@endsection