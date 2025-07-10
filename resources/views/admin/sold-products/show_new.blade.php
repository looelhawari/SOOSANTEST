@extends('layouts.admin')

@section('title', __('sold-products.sale_details'))
@section('page-title', __('sold-products.sale_details'))

@section('content')
<style>
    .modern-page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        margin: -2rem -2rem 2rem;
        border-radius: 0 0 1rem 1rem;
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
    .modern-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    .modern-btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }
    .modern-btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    .sale-icon-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 15px 40px rgba(40, 167, 69, 0.3);
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
    }
    .info-value {
        color: #6c757d;
    }
    .warranty-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .warranty-active {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    .warranty-expired {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
    }
</style>

<!-- Page Header -->
<div class="modern-page-header">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">{{ __('sold-products.sale_details') }}</h1>
                <p class="mb-0 opacity-75">{{ __('sold-products.complete_information') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="btn-group">
                    <a href="{{ route('admin.sold-products.edit', $soldProduct) }}" class="modern-btn modern-btn-warning">
                        <i class="fas fa-edit me-2"></i>{{ __('sold-products.edit_sale') }}
                    </a>
                    <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('sold-products.back_to_sales') }}
                    </a>
                </div>
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

<div class="row">
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="card-header bg-white border-bottom p-4">
                <div class="text-center">
                    <div class="sale-icon-large">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="mb-1">{{ __('sold-products.sale_number', ['id' => $soldProduct->id]) }}</h3>
                    <p class="text-muted mb-0">{{ $soldProduct->product->model_name ?? __('sold-products.na') }}</p>
                    <div class="mt-3">
                        @if($soldProduct->warranty_end_date && $soldProduct->warranty_end_date >= now())
                            <span class="warranty-badge warranty-active">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('sold-products.under_warranty') }}
                            </span>
                        @else
                            <span class="warranty-badge warranty-expired">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('sold-products.warranty_expired') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.product') }}:</span>
                            <span class="info-value">
                                @if($soldProduct->product)
                                    <a href="{{ route('admin.products.show', $soldProduct->product) }}" class="text-decoration-none">
                                        {{ $soldProduct->product->model_name }}
                                    </a>
                                @else
                                    {{ __('sold-products.na') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.owner') }}:</span>
                            <span class="info-value">
                                @if($soldProduct->owner)
                                    <a href="{{ route('admin.owners.show', $soldProduct->owner) }}" class="text-decoration-none">
                                        {{ $soldProduct->owner->name }}
                                    </a>
                                @else
                                    {{ __('sold-products.na') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.employee') }}:</span>
                            <span class="info-value">
                                @if($soldProduct->employee)
                                    {{ $soldProduct->employee->name }} ({{ ucfirst($soldProduct->employee->role) }})
                                @else
                                    {{ __('sold-products.na') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.serial_number') }}:</span>
                            <span class="info-value">
                                <strong>{{ $soldProduct->serial_number }}</strong>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.purchase_price') }}:</span>
                            <span class="info-value">
                                <strong class="text-success">${{ number_format($soldProduct->purchase_price ?? 0, 2) }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.sale_date') }}:</span>
                            <span class="info-value">{{ $soldProduct->sale_date ? $soldProduct->sale_date->format('M d, Y') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.warranty_start') }}:</span>
                            <span class="info-value">{{ $soldProduct->warranty_start_date ? $soldProduct->warranty_start_date->format('M d, Y') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.warranty_end') }}:</span>
                            <span class="info-value">{{ $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('M d, Y') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.created') }}:</span>
                            <span class="info-value">{{ $soldProduct->created_at ? $soldProduct->created_at->format('M d, Y H:i') : __('sold-products.na') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">{{ __('sold-products.updated') }}:</span>
                            <span class="info-value">{{ $soldProduct->updated_at ? $soldProduct->updated_at->format('M d, Y H:i') : __('sold-products.na') }}</span>
                        </div>
                    </div>
                </div>

                @if($soldProduct->notes)
                <div class="mt-4">
                    <h6 class="info-label mb-3">{{ __('sold-products.additional_notes') }}:</h6>
                    <div class="p-3" style="background: #f8f9fa; border-radius: 0.75rem; border-left: 4px solid #667eea;">
                        {{ $soldProduct->notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="modern-card">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('sold-products.quick_actions') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.sold-products.edit', $soldProduct) }}" class="modern-btn modern-btn-warning w-100">
                        <i class="fas fa-edit me-2"></i>
                        {{ __('sold-products.edit_sale') }}
                    </a>
                    
                    @if($soldProduct->product)
                        <a href="{{ route('admin.products.show', $soldProduct->product) }}" class="modern-btn modern-btn-secondary w-100">
                            <i class="fas fa-cube me-2"></i>
                            {{ __('sold-products.view_product') }}
                        </a>
                    @endif
                    
                    @if($soldProduct->owner)
                        <a href="{{ route('admin.owners.show', $soldProduct->owner) }}" class="modern-btn modern-btn-secondary w-100">
                            <i class="fas fa-user me-2"></i>
                            {{ __('sold-products.view_owner') }}
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.sold-products.destroy', $soldProduct) }}" class="d-inline" 
                          onsubmit="return confirm('{{ __('sold-products.confirm_delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modern-btn w-100" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                            <i class="fas fa-trash me-2"></i>
                            {{ __('sold-products.delete_sale') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($soldProduct->warranty_start_date && $soldProduct->warranty_end_date)
        <div class="modern-card">
            <div class="card-header bg-white border-bottom p-3">
                <h5 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    {{ __('sold-products.warranty_information') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="text-center">
                    @php
                        $warrantyStart = $soldProduct->warranty_start_date;
                        $warrantyEnd = $soldProduct->warranty_end_date;
                        $now = now();
                        $isActive = $now->between($warrantyStart, $warrantyEnd);
                        $daysRemaining = $isActive ? $now->diffInDays($warrantyEnd) : 0;
                        $totalDays = $warrantyStart->diffInDays($warrantyEnd);
                        $daysUsed = $warrantyStart->diffInDays($now);
                        $percentage = $totalDays > 0 ? min(100, ($daysUsed / $totalDays) * 100) : 0;
                    @endphp
                    
                    @if($isActive)
                        <div class="warranty-badge warranty-active mb-3">
                            <i class="fas fa-shield-alt"></i>
                            {{ __('sold-products.active_warranty') }}
                        </div>
                        <p class="mb-2"><strong>{{ __('sold-products.days_remaining', ['days' => $daysRemaining]) }}</strong></p>
                        <div class="progress mb-3" style="height: 10px; border-radius: 10px;">
                            <div class="progress-bar" style="width: {{ $percentage }}%; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);" role="progressbar"></div>
                        </div>
                    @else
                        <div class="warranty-badge warranty-expired mb-3">
                            <i class="fas fa-shield-alt"></i>
                            {{ __('sold-products.warranty_expired') }}
                        </div>
                        @if($now < $warrantyStart)
                            <p class="text-muted">{{ __('sold-products.warranty_not_started') }}</p>
                        @else
                            <p class="text-muted">{{ __('sold-products.expired_time_ago', ['time' => $warrantyEnd->diffForHumans()]) }}</p>
                        @endif
                    @endif
                    
                    <small class="text-muted d-block">
                        {{ $warrantyStart->format('M d, Y') }} - {{ $warrantyEnd->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
