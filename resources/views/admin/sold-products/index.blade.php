@extends('layouts.admin')

@section('title', __('sold-products.page_title'))

@section('content')
<style>
    /* CSS Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --danger-gradient: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        --card-shadow: 0 5px 15px rgba(0,0,0,0.08);
        --card-shadow-hover: 0 10px 25px rgba(0,0,0,0.15);
        --border-radius: 1rem;
        --transition: all 0.3s ease;
    }

    /* Page Header */
    .modern-page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 2rem;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        position: relative;
        overflow: hidden;
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
    }

    /* Cards */
    .modern-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: 1px solid #e9ecef;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: var(--transition);
    }
    
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
    }
    
    .modern-card .card-body {
        padding: 1.5rem;
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        text-align: center;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        transition: var(--transition);
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Form Controls */
    .input-group-text {
        background: var(--primary-gradient);
        border: none;
        color: white;
        border-radius: 0.5rem 0 0 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        font-size: 0.875rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }
    
    .form-label {
        color: #495057;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    /* Buttons */
    .modern-btn {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modern-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: var(--transition);
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    }
    
    .btn-outline-secondary {
        border: 1px solid #6c757d;
        color: #6c757d;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: var(--transition);
        background: white;
    }
    
    .btn-outline-secondary:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-1px);
    }

    /* Sale Cards */
    .sale-card {
        background: #fff;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        border: 1px solid #e9ecef;
        transition: var(--transition);
        height: 100%;
    }
    
    .sale-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
        border-color: #667eea;
    }
    
    .sale-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--success-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .sale-details {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin: 1rem 0;
        border-left: 3px solid #28a745;
        font-size: 0.875rem;
    }
    
    .price-display {
        font-size: 1.25rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 1rem;
    }

    /* Warranty Badges */
    .warranty-active {
        background: var(--success-gradient);
        color: white;
    }
    
    .warranty-expired {
        background: var(--danger-gradient);
        color: white;
    }
    
    .warranty-expiring {
        background: var(--warning-gradient);
        color: white;
    }
    
    .badge-modern {
        padding: 0.375rem 0.75rem;
        border-radius: 1rem;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Action Buttons */
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid;
        background: transparent;
        transition: var(--transition);
        margin: 0 0.25rem;
        font-size: 0.875rem;
    }
    
    .action-btn:hover {
        transform: scale(1.1);
        background: currentColor;
        color: white !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Animations */
    .collapse.show {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
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
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .modern-page-header {
            padding: 1.5rem 0;
            margin: -1rem -1rem 1.5rem;
        }
        
        .stat-card {
            padding: 1rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .sale-card {
            padding: 1rem;
        }
        
        .form-control, .form-select {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }
        
        .btn-primary, .btn-outline-secondary {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .modern-page-header {
            margin: -0.5rem -0.5rem 1rem;
            padding: 1.5rem 0;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<!-- Page Header -->
<div class="modern-page-header">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">{{ __('sold-products.page_title') }}</h1>
                <p class="mb-0 opacity-75">{{ __('sold-products.track_and_manage_description') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.sold-products.create') }}" class="modern-btn">
                    <i class="fas fa-plus"></i>
                    {{ __('sold-products.add_new_sale') }}
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 1rem; border: none; box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-label">{{ __('sold-products.total_sales') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
        <div class="stat-value">{{ $stats['this_month'] }}</div>
        <div class="stat-label">{{ __('sold-products.this_month') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
        <div class="stat-value">{{ $stats['warranty_active'] }}</div>
        <div class="stat-label">{{ __('sold-products.under_warranty') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
        <div class="stat-value">{{ $stats['warranty_expired'] }}</div>
        <div class="stat-label">{{ __('sold-products.warranty_expired') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);">
        <div class="stat-value">{{ $stats['expiring_soon'] }}</div>
        <div class="stat-label">{{ __('sold-products.expiring_soon') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #6c757d 0%, #343a40 100%);">
        <div class="stat-value">{{ $stats['voided'] }}</div>
        <div class="stat-label">{{ __('sold-products.warranty_voided') }}</div>
    </div>
</div>

<!-- Advanced Filter Section -->
<div class="modern-card mb-4">
    <div class="card-body">
        <!-- Quick Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="quickSearch"
                           placeholder="{{ __('sold-products.quick_search_placeholder') }}"
                           value="{{ request('owner_name') ?: request('serial_number') }}">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="fas fa-filter me-2 text-primary"></i>
                            {{ __('sold-products.advanced_filters') }}
                        </h5>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="toggleFilters">
                        <i class="fas fa-chevron-down" id="filterToggleIcon"></i>
                        {{ __('sold-products.toggle_filters') }}
                    </button>
                </div>
            </div>
        </div>
        
        <div id="filterSection" class="collapse">
            <form method="GET" action="{{ route('admin.sold-products.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Owner Name Filter -->
                    <div class="col-md-3">
                        <label for="owner_name" class="form-label fw-semibold">
                            <i class="fas fa-user text-muted me-1"></i>
                            {{ __('sold-products.owner_name') }}
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="owner_name" 
                               name="owner_name" 
                               value="{{ request('owner_name') }}"
                               placeholder="{{ __('sold-products.search_owner_placeholder') }}">
                    </div>

                    <!-- Serial Number Filter -->
                    <div class="col-md-3">
                        <label for="serial_number" class="form-label fw-semibold">
                            <i class="fas fa-barcode text-muted me-1"></i>
                            {{ __('sold-products.serial_number') }}
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="serial_number" 
                               name="serial_number" 
                               value="{{ request('serial_number') }}"
                               placeholder="{{ __('sold-products.search_serial_placeholder') }}">
                    </div>

                    <!-- Warranty Status Filter -->
                    <div class="col-md-3">
                        <label for="warranty_status" class="form-label fw-semibold">
                            <i class="fas fa-shield-alt text-muted me-1"></i>
                            {{ __('sold-products.warranty_status') }}
                        </label>
                        <select class="form-select" id="warranty_status" name="warranty_status">
                            <option value="">{{ __('sold-products.all_warranties') }}</option>
                            <option value="active" {{ request('warranty_status') == 'active' ? 'selected' : '' }}>
                                {{ __('sold-products.warranty_active') }}
                            </option>
                            <option value="expired" {{ request('warranty_status') == 'expired' ? 'selected' : '' }}>
                                {{ __('sold-products.warranty_expired') }}
                            </option>
                            <option value="expiring_soon" {{ request('warranty_status') == 'expiring_soon' ? 'selected' : '' }}>
                                {{ __('sold-products.warranty_expiring_soon') }}
                            </option>
                        </select>
                    </div>

                    <!-- Product Filter -->
                    <div class="col-md-3">
                        <label for="product_id" class="form-label fw-semibold">
                            <i class="fas fa-box text-muted me-1"></i>
                            {{ __('sold-products.product') }}
                        </label>
                        <select class="form-select" id="product_id" name="product_id">
                            <option value="">{{ __('sold-products.all_products') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->model_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="col-md-3">
                        <label for="date_from" class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                            {{ __('sold-products.date_from') }}
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="date_from" 
                               name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="date_to" class="form-label fw-semibold">
                            <i class="fas fa-calendar-check text-muted me-1"></i>
                            {{ __('sold-products.date_to') }}
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="date_to" 
                               name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>

                    <!-- Sort Options -->
                    <div class="col-md-3">
                        <label for="sort_by" class="form-label fw-semibold">
                            <i class="fas fa-sort text-muted me-1"></i>
                            {{ __('sold-products.sort_by') }}
                        </label>
                        <select class="form-select" id="sort_by" name="sort_by">
                            <option value="sale_date" {{ request('sort_by') == 'sale_date' ? 'selected' : '' }}>
                                {{ __('sold-products.sale_date') }}
                            </option>
                            <option value="warranty_end_date" {{ request('sort_by') == 'warranty_end_date' ? 'selected' : '' }}>
                                {{ __('sold-products.warranty_end_date') }}
                            </option>
                            <option value="serial_number" {{ request('sort_by') == 'serial_number' ? 'selected' : '' }}>
                                {{ __('sold-products.serial_number') }}
                            </option>
                            <option value="purchase_price" {{ request('sort_by') == 'purchase_price' ? 'selected' : '' }}>
                                {{ __('sold-products.purchase_price') }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="sort_order" class="form-label fw-semibold">
                            <i class="fas fa-sort-amount-down text-muted me-1"></i>
                            {{ __('sold-products.sort_order') }}
                        </label>
                        <select class="form-select" id="sort_order" name="sort_order">
                            <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>
                                {{ __('sold-products.newest_first') }}
                            </option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                                {{ __('sold-products.oldest_first') }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Filter Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            {{ __('sold-products.apply_filters') }}
                        </button>
                        <a href="{{ route('admin.sold-products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            {{ __('sold-products.clear_filters') }}
                        </a>
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ __('sold-products.showing_results', ['count' => $soldProducts->total()]) }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if(auth()->user()->isEmployee())
    <!-- Employee Notice -->
    <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; margin-bottom: 2rem; border-radius: 8px;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-info-circle" style="color: #f59e0b; font-size: 1.25rem;"></i>
            <div>
                <h4 style="color: #92400e; margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;">Employee Access</h4>
                <p style="color: #92400e; margin: 0; font-size: 0.875rem;">You can create new sales and edit existing ones. Any edits to existing sales will be submitted for admin approval before taking effect.</p>
            </div>
        </div>
    </div>
@endif

<!-- Sales Grid -->
<div class="row">
    @forelse($soldProducts as $soldProduct)
        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="sale-card">
                <div class="sale-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                
                <div class="text-center">
                    <h5 class="mb-2">{{ $soldProduct->product->model_name ?? 'N/A' }}</h5>
                    
                    <div class="sale-details">
                        <div class="mb-2">
                            <i class="fas fa-user text-primary me-2"></i>
                            <strong>{{ __('sold-products.owner') }}:</strong> {{ $soldProduct->owner->name ?? __('sold-products.na') }}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-calendar text-info me-2"></i>
                            <strong>{{ __('sold-products.sale_date') }}:</strong> {{ $soldProduct->sale_date ? $soldProduct->sale_date->format('M d, Y') : __('sold-products.na') }}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-barcode text-warning me-2"></i>
                            <strong>{{ __('sold-products.serial') }}:</strong> {{ $soldProduct->serial_number }}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-user-tie text-secondary me-2"></i>
                            <strong>{{ __('sold-products.employee') }}:</strong> {{ $soldProduct->employee->name ?? __('sold-products.na') }}
                        </div>
                    </div>
                    
                    <div class="price-display mb-3">
                        ${{ number_format($soldProduct->purchase_price ?? 0, 2) }}
                    </div>
                    
                    <div class="mb-3">
                        @php
                            $warrantyStatus = 'expired';
                            $warrantyClass = 'warranty-expired';
                            $warrantyIcon = 'fas fa-shield-alt';
                            $warrantyText = __('sold-products.warranty_expired');

                            if($soldProduct->warranty_voided) {
                                $warrantyStatus = 'voided';
                                $warrantyClass = 'warranty-expired';
                                $warrantyIcon = 'fas fa-ban';
                                $warrantyText = __('sold-products.warranty_voided');
                            } elseif($soldProduct->isUnderWarranty()) {
                                $warrantyStatus = 'active';
                                $warrantyClass = 'warranty-active';
                                $warrantyIcon = 'fas fa-shield-check';
                                $warrantyText = __('sold-products.warranty_active');
                            } elseif($soldProduct->warranty_end_date) {
                                $daysUntilExpiry = now()->diffInDays($soldProduct->warranty_end_date, false);
                                if($daysUntilExpiry > 0) {
                                    $warrantyStatus = 'expiring';
                                    $warrantyClass = 'warranty-expiring';
                                    $warrantyIcon = 'fas fa-shield-exclamation';
                                    $warrantyText = __('sold-products.warranty_expiring_soon') . ' (' . $daysUntilExpiry . ' days)';
                                }
                            }
                        @endphp
                        
                        <span class="badge badge-modern {{ $warrantyClass }}">
                            <i class="{{ $warrantyIcon }} me-1"></i>{{ $warrantyText }}
                        </span>
                        
                        @if($soldProduct->warranty_end_date)
                            <div class="text-muted small mt-1">
                                <i class="fas fa-calendar-times me-1"></i>
                                {{ __('sold-products.warranty_expires') }}: {{ $soldProduct->warranty_end_date->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('admin.sold-products.show', $soldProduct) }}" 
                           class="action-btn border-info text-info" 
                           title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.sold-products.edit', $soldProduct) }}" 
                           class="action-btn border-warning text-warning" 
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.sold-products.destroy', $soldProduct) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="action-btn border-danger text-danger" 
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this sale record? This action cannot be undone.')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-shopping-cart"></i>
                <h4>{{ __('sold-products.no_sales') }}</h4>
                <p class="mb-4">Start by recording your first sale transaction.</p>
                <a href="{{ route('admin.sold-products.create') }}" class="modern-btn">
                    <i class="fas fa-plus"></i>
                    Record First Sale
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($soldProducts->hasPages())
    <div class="modern-card">
        <div class="card-body text-center">
            {{ $soldProducts->links() }}
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle functionality
    const toggleBtn = document.getElementById('toggleFilters');
    const filterSection = document.getElementById('filterSection');
    const toggleIcon = document.getElementById('filterToggleIcon');
    
    // Check if filters are active and show them by default
    const hasActiveFilters = @json(request()->filled('owner_name') || request()->filled('serial_number') || request()->filled('warranty_status') || request()->filled('product_id') || request()->filled('date_from') || request()->filled('date_to'));
    
    if (hasActiveFilters) {
        filterSection.classList.add('show');
        toggleIcon.classList.remove('fa-chevron-down');
        toggleIcon.classList.add('fa-chevron-up');
    }
    
    toggleBtn.addEventListener('click', function() {
        filterSection.classList.toggle('show');
        
        if (filterSection.classList.contains('show')) {
            toggleIcon.classList.remove('fa-chevron-down');
            toggleIcon.classList.add('fa-chevron-up');
        } else {
            toggleIcon.classList.remove('fa-chevron-up');
            toggleIcon.classList.add('fa-chevron-down');
        }
    });
    
    // Auto-submit form on select changes for better UX
    const autoSubmitFields = ['warranty_status', 'product_id', 'sort_by', 'sort_order'];
    autoSubmitFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', function() {
                // Add a small delay to allow user to see the change
                setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 200);
            });
        }
    });
    
    // Date validation
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    
    if (dateFrom && dateTo) {
        dateFrom.addEventListener('change', function() {
            if (this.value && dateTo.value && this.value > dateTo.value) {
                dateTo.value = this.value;
            }
        });
        
        dateTo.addEventListener('change', function() {
            if (this.value && dateFrom.value && this.value < dateFrom.value) {
                dateFrom.value = this.value;
            }
        });
    }
    
    // Quick search functionality
    const quickSearch = document.getElementById('quickSearch');
    if (quickSearch) {
        let quickSearchTimeout;
        
        quickSearch.addEventListener('input', function() {
            clearTimeout(quickSearchTimeout);
            quickSearchTimeout = setTimeout(() => {
                const searchValue = this.value.trim();
                
                // Determine if it's a serial number (contains numbers) or owner name
                if (searchValue) {
                    if (/\d/.test(searchValue)) {
                        // Likely a serial number
                        document.getElementById('serial_number').value = searchValue;
                        document.getElementById('owner_name').value = '';
                    } else {
                        // Likely an owner name
                        document.getElementById('owner_name').value = searchValue;
                        document.getElementById('serial_number').value = '';
                    }
                } else {
                    // Clear both fields
                    document.getElementById('serial_number').value = '';
                    document.getElementById('owner_name').value = '';
                }
                
                // Auto-submit the form
                document.getElementById('filterForm').submit();
            }, 800);
        });
        
        quickSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(quickSearchTimeout);
                
                const searchValue = this.value.trim();
                
                if (searchValue) {
                    if (/\d/.test(searchValue)) {
                        document.getElementById('serial_number').value = searchValue;
                        document.getElementById('owner_name').value = '';
                    } else {
                        document.getElementById('owner_name').value = searchValue;
                        document.getElementById('serial_number').value = '';
                    }
                } else {
                    document.getElementById('serial_number').value = '';
                    document.getElementById('owner_name').value = '';
                }
                
                document.getElementById('filterForm').submit();
            }
        });
    }
    
    // Search input debouncing
    let searchTimeout;
    const searchFields = ['owner_name', 'serial_number'];
    
    searchFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Optional: auto-submit search after user stops typing
                    // document.getElementById('filterForm').submit();
                }, 1000);
            });
        }
    });
    
    // Enhanced styling for filter inputs
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
            this.style.boxShadow = '0 0 0 0.2rem rgba(102, 126, 234, 0.25)';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = '#ced4da';
            this.style.boxShadow = 'none';
        });
    });

    // Add smooth hover effects
    const saleCards = document.querySelectorAll('.sale-card');
    saleCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animate stat cards on load
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animate filter section
    const filterCard = document.querySelector('.modern-card');
    if (filterCard) {
        filterCard.style.opacity = '0';
        filterCard.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            filterCard.style.transition = 'all 0.6s ease';
            filterCard.style.opacity = '1';
            filterCard.style.transform = 'translateY(0)';
        }, 600);
    }
});
</script>
@endsection
