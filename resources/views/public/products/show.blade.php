{{--
    DO NOT INCLUDE NAVBAR OR LAYOUT HTML HERE!
    This file must only use @extends('layouts.public') at the top.
    The layout handles the navbar and footer. Remove any accidental HTML, <nav>, <footer>, <body>, <html>, or duplicate layout code from this file.
--}}
@extends('layouts.public')

@section('title', $product->model_name . ' - Soosan Cebotics')
@section('description', 'View details and specifications for ' . $product->model_name)

@section('content')
<div class="container py-5" style="min-height: 70vh;">
    <div class="row g-5 align-items-start">
        <div class="col-lg-6 text-center mb-4 mb-lg-0">
            <div class="product-image-container rounded shadow-sm p-3 fade-in" style="min-height:420px;display:flex;align-items:center;justify-content:center;">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}" style="max-width:100%;max-height:400px;object-fit:contain;" loading="lazy">
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-image" style="font-size: 4rem; opacity: 0.3;"></i>
                        <p class="mt-3 mb-0">{{ __('common.no_image') }}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <span class="badge bg-primary mb-2" style="font-size:1rem;">{{ $product->category->name ?? __('common.product_category') }}</span>
            <h1 class="fw-bold mb-3" style="font-size:2.2rem;">{{ $product->model_name }}</h1>
            <div class="d-flex justify-content-end mb-2">
                <div class="btn-group" role="group" aria-label="Unit Toggle">
                    <button type="button" class="btn btn-outline-primary{{ $unit === 'si' ? ' active' : '' }}" id="siBtn">{{ __('common.si') }}</button>
                    <button type="button" class="btn btn-outline-primary{{ $unit === 'imperial' ? ' active' : '' }}" id="imperialBtn">{{ __('common.imperial') }}</button>
                </div>
            </div>
            <div class="row mb-4 g-2">
                <div class="col-4 text-center">
                    <div class="product-specs-card rounded py-3 px-2">
                        <div class="fw-bold" style="font-size:1.2rem;">
                            @php
                                $ow = $product->operating_weight;
                                if ($ow === null || $ow === '') {
                                    $ow_si = '- kg';
                                    $ow_imperial = '- lb';
                                } else {
                                    $ow_si = number_format($ow * 0.453592, 1) . ' kg';
                                    $ow_imperial = number_format($ow, 1) . ' lb';
                                }
                            @endphp
                            <span class="unit-value" data-si="{{ $ow_si }}" data-imperial="{{ $ow_imperial }}">{{ $unit === 'si' ? $ow_si : $ow_imperial }}</span>
                        </div>
                        <div class="small text-muted">{{ __('common.operating_weight') }}</div>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="product-specs-card rounded py-3 px-2">
                        <div class="fw-bold" style="font-size:1.2rem;">
                            @php
                                $rof = $product->required_oil_flow;
                                if ($rof === null || $rof === '') {
                                    $rof_si = '- l/min';
                                    $rof_imperial = '- gal/min';
                                } elseif (preg_match('/^([\d.]+)~([\d.]+)/', $rof, $m)) {
                                    $rof_si = number_format($m[1] * 3.78541, 1) . ' ~ ' . number_format($m[2] * 3.78541, 1) . ' l/min';
                                    $rof_imperial = $rof . ' gal/min';
                                } elseif (is_numeric($rof)) {
                                    $rof_si = number_format($rof * 3.78541, 1) . ' l/min';
                                    $rof_imperial = $rof . ' gal/min';
                                } else {
                                    $rof_si = '- l/min';
                                    $rof_imperial = '- gal/min';
                                }
                            @endphp
                            <span class="unit-value" data-si="{{ $rof_si }}" data-imperial="{{ $rof_imperial }}">{{ $unit === 'si' ? $rof_si : $rof_imperial }}</span>
                        </div>
                        <div class="small text-muted">{{ __('common.required_oil_flow') }}</div>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="product-specs-card rounded py-3 px-2">
                        <div class="fw-bold" style="font-size:1.2rem;">
                            @php
                                $ac = $product->applicable_carrier;
                                if ($ac === null || $ac === '') {
                                    $ac_si = '- ton';
                                    $ac_imperial = '- lb';
                                } elseif (preg_match('/^([\d.]+)~([\d.]+)/', $ac, $m)) {
                                    $ac_si = number_format($m[1] * 0.000453592, 1) . ' ~ ' . number_format($m[2] * 0.000453592, 1) . ' ton';
                                    $ac_imperial = $ac . ' lb';
                                } elseif (is_numeric($ac)) {
                                    $ac_si = number_format($ac * 0.000453592, 1) . ' ton';
                                    $ac_imperial = $ac . ' lb';
                                } else {
                                    $ac_si = '- ton';
                                    $ac_imperial = '- lb';
                                }
                            @endphp
                            <span class="unit-value" data-si="{{ $ac_si }}" data-imperial="{{ $ac_imperial }}">{{ $unit === 'si' ? $ac_si : $ac_imperial }}</span>
                        </div>
                        <div class="small text-muted">{{ __('common.applicable_carrier') }}</div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="#quote" class="btn btn-primary flex-grow-1" style="border-radius: 8px; font-weight: 500;">
                    <i class="bi bi-chat-quote me-2"></i>{{ __('common.request_a_quote') }}
                </a>
                <a href="tel:{{ config('app.company_phone', '+123456789') }}" class="btn btn-outline-secondary flex-grow-1" style="border-radius: 8px; font-weight: 500;">
                    <i class="bi bi-telephone me-2"></i>{{ __('common.call') }}
                </a>
                <button class="btn btn-outline-secondary flex-grow-1 share-btn" style="border-radius: 8px; font-weight: 500;">
                    <i class="bi bi-share me-2"></i>{{ __('common.share') }}
                </button>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h3 class="fw-bold mb-3">{{ __('common.specifications') }}</h3>
        <div class="table-responsive">
            <table class="table table-bordered align-middle specifications-table">
                <tbody>
                    @php
                        function safe_val($val, $unit_si = '', $unit_imp = '') {
                            $is_null = ($val === null || $val === '');
                            return [
                                $is_null ? ('- ' . $unit_si) : ($unit_si ? $val . ' ' . $unit_si : $val),
                                $is_null ? ('- ' . $unit_imp) : ($unit_imp ? $val . ' ' . $unit_imp : $val)
                            ];
                        }
                        // Helper for range/fraction/number conversion
                        function convert_range($val, $factor, $unit_si, $unit_imp, $decimals = 1) {
                            if ($val === null || $val === '') {
                                return ['- ' . $unit_si, '- ' . $unit_imp];
                            }
                            if (preg_match('/^([\d.]+)~([\d.]+)/', $val, $m)) {
                                return [
                                    round($m[1] * $factor) . ' ~ ' . round($m[2] * $factor) . ' ' . $unit_si,
                                    number_format($m[1], $decimals) . ' ~ ' . number_format($m[2], $decimals) . ' ' . $unit_imp
                                ];
                            } elseif (is_numeric($val)) {
                                return [
                                    round($val * $factor) . ' ' . $unit_si,
                                    number_format($val, $decimals) . ' ' . $unit_imp
                                ];
                            } elseif (preg_match('/^(\d+)\/(\d+)$/', trim($val), $m)) {
                                $dec = $m[1] / $m[2];
                                return [
                                    round($dec * $factor) . ' ' . $unit_si,
                                    $val . ' ' . $unit_imp
                                ];
                            } else {
                                return [$val . ' ' . $unit_si, $val . ' ' . $unit_imp];
                            }
                        }
                        // Use more accurate factors and decimals
                        [$bw_si, $bw_imp] = convert_range($product->body_weight, 0.45359237, 'kg', 'lb', 1);
                        [$ow_si, $ow_imp] = convert_range($product->operating_weight, 0.45359237, 'kg', 'lb', 1);
                        [$ol_si, $ol_imp] = convert_range($product->overall_length, 25.4, 'mm', 'in', 1);
                        [$owd_si, $owd_imp] = convert_range($product->overall_width, 25.4, 'mm', 'in', 1);
                        [$oh_si, $oh_imp] = convert_range($product->overall_height, 25.4, 'mm', 'in', 1);
                        [$rof_si, $rof_imp] = convert_range($product->required_oil_flow, 3.785411784, 'l/min', 'gal/min', 1);
                        [$op_si, $op_imp] = convert_range($product->operating_pressure, 0.070306957, 'kgf/cm²', 'psi', 1);
                        [$hd_si, $hd_imp] = convert_range($product->hose_diameter, 25.4, 'mm', 'in', 1);
                        [$rd_si, $rd_imp] = convert_range($product->rod_diameter, 25.4, 'mm', 'in', 1);
                        [$ac_si, $ac_imp] = convert_range($product->applicable_carrier, 0.00045359237, 'ton', 'lb', 1);
                        [$ir_si, $ir_imp] = safe_val($product->impact_rate, 'BPM', 'BPM');
                        [$irsr_si, $irsr_imp] = safe_val($product->impact_rate_soft_rock, 'BPM', 'BPM');
                    @endphp
                    <tr><th>{{ __('common.body_weight') }}</th><td><span class="unit-value" data-si="{{ $bw_si }}" data-imperial="{{ $bw_imp }}">{{ $bw_si }}</span></td></tr>
                    <tr><th>{{ __('common.operating_weight') }}</th><td><span class="unit-value" data-si="{{ $ow_si }}" data-imperial="{{ $ow_imp }}">{{ $ow_si }}</span></td></tr>
                    <tr><th>{{ __('common.overall_length') }}</th><td><span class="unit-value" data-si="{{ $ol_si }}" data-imperial="{{ $ol_imp }}">{{ $ol_si }}</span></td></tr>
                    <tr><th>{{ __('common.overall_width') }}</th><td><span class="unit-value" data-si="{{ $owd_si }}" data-imperial="{{ $owd_imp }}">{{ $owd_si }}</span></td></tr>
                    <tr><th>{{ __('common.overall_height') }}</th><td><span class="unit-value" data-si="{{ $oh_si }}" data-imperial="{{ $oh_imp }}">{{ $oh_si }}</span></td></tr>
                    <tr><th>{{ __('common.required_oil_flow') }}</th><td><span class="unit-value" data-si="{{ $rof_si }}" data-imperial="{{ $rof_imp }}">{{ $rof_si }}</span></td></tr>
                    <tr><th>{{ __('common.operating_pressure') }}</th><td><span class="unit-value" data-si="{{ $op_si }}" data-imperial="{{ $op_imp }}">{{ $op_si }}</span></td></tr>
                    <tr><th>{{ __('common.impact_rate_std_mode') }}</th><td><span class="unit-value" data-si="{{ $ir_si }}" data-imperial="{{ $ir_imp }}">{{ $ir_si }}</span></td></tr>
                    <tr><th>{{ __('common.impact_rate_soft_rock_label') }}</th><td><span class="unit-value" data-si="{{ $irsr_si }}" data-imperial="{{ $irsr_imp }}">{{ $irsr_si }}</span></td></tr>
                    <tr><th>{{ __('common.hose_diameter') }}</th><td><span class="unit-value" data-si="{{ $hd_si }}" data-imperial="{{ $hd_imp }}">{{ $hd_si }}</span></td></tr>
                    <tr><th>{{ __('common.rod_diameter') }}</th><td><span class="unit-value" data-si="{{ $rd_si }}" data-imperial="{{ $rd_imp }}">{{ $rd_si }}</span></td></tr>
                    <tr><th>{{ __('common.applicable_carrier') }}</th><td><span class="unit-value" data-si="{{ $ac_si }}" data-imperial="{{ $ac_imp }}">{{ $ac_si }}</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Similar Products Section --}}
@php
    $similarProducts = \App\Models\Product::where(function($q) use ($product) {
        if ($product->line) $q->orWhere('line', $product->line);
        if ($product->type) $q->orWhere('type', $product->type);
    })
    ->where('id', '!=', $product->id)
    ->limit(12)
    ->get();
@endphp
@if($similarProducts->count())
<div class="container my-5">
    <h3 class="fw-bold mb-4">{{ __('common.similar_products') }}</h3>
    <div class="position-relative">
        <!-- Navigation Buttons -->
        <button id="carouselPrevBtn" class="btn btn-primary position-absolute top-50 translate-middle-y" 
                style="z-index:10; border-radius:50%; width:48px; height:48px; box-shadow:0 4px 12px rgba(0,0,0,0.15); {{ app()->getLocale() === 'ar' ? 'right: -24px;' : 'left: -24px;' }} display: none;"
                title="{{ __('common.previous_products') }}" 
                aria-label="{{ __('common.previous_products') }}">
            <i class="bi {{ app()->getLocale() === 'ar' ? 'bi-chevron-right' : 'bi-chevron-left' }}" style="font-size: 1.2rem; font-weight: bold;"></i>
        </button>
        <button id="carouselNextBtn" class="btn btn-primary position-absolute top-50 translate-middle-y" 
                style="z-index:10; border-radius:50%; width:48px; height:48px; box-shadow:0 4px 12px rgba(0,0,0,0.15); {{ app()->getLocale() === 'ar' ? 'left: -24px;' : 'right: -24px;' }}"
                title="{{ __('common.next_products') }}" 
                aria-label="{{ __('common.next_products') }}">
            <i class="bi {{ app()->getLocale() === 'ar' ? 'bi-chevron-left' : 'bi-chevron-right' }}" style="font-size: 1.2rem; font-weight: bold;"></i>
        </button>
        
        <!-- Carousel Container -->
        <div class="carousel-container" style="overflow: hidden; border-radius: 12px;">
            <div id="similarProductsCarousel" class="d-flex gap-3 pb-2" style="transition: transform 0.3s ease-in-out; {{ app()->getLocale() === 'ar' ? 'direction: rtl;' : 'direction: ltr;' }}">
                @foreach($similarProducts as $sim)
                <div class="flex-shrink-0 product-card" style="width: 320px;">
                    <a href="{{ route('products.show', $sim->id) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0 hover-card" style="min-height: 360px; border-radius: 12px; overflow: hidden; transition: all 0.3s ease; {{ app()->getLocale() === 'ar' ? 'direction: rtl;' : 'direction: ltr;' }}">
                            <div class="card-img-container" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center; height: 200px; position: relative;">
                                @if($sim->image_url)
                                    <img src="{{ $sim->image_url }}" alt="{{ $sim->model_name }}" class="card-img-top" style="max-height: 180px; max-width: 100%; object-fit: contain; width: auto; height: auto; transition: transform 0.3s ease;" loading="lazy">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">{{ __('common.no_image') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column" style="text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">
                                <h5 class="card-title fw-semibold mb-3" style="font-size: 1.1rem; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $sim->model_name }}</h5>
                                <ul class="list-unstyled mb-0 flex-grow-1">
                                    <li class="d-flex justify-content-between mb-2 small">
                                        <strong class="text-muted">{{ __('common.operating_weight') }}:</strong> 
                                        <span class="text-dark">
                                            @if($sim->operating_weight !== null && $sim->operating_weight !== '')
                                                {{ number_format($sim->operating_weight, 1) }} {{ __('common.unit_lb') }}
                                            @else
                                                - {{ __('common.unit_lb') }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-2 small">
                                        <strong class="text-muted">{{ __('common.required_oil_flow') }}:</strong> 
                                        <span class="text-dark">
                                            @if($sim->required_oil_flow !== null && $sim->required_oil_flow !== '')
                                                @if(preg_match('/^([\d.]+)~([\d.]+)/', $sim->required_oil_flow, $m))
                                                    {{ number_format($m[1], 1) }}~{{ number_format($m[2], 1) }} {{ __('common.unit_gal_min') }}
                                                @elseif(is_numeric($sim->required_oil_flow))
                                                    {{ number_format($sim->required_oil_flow, 1) }} {{ __('common.unit_gal_min') }}
                                                @else
                                                    {{ $sim->required_oil_flow }} {{ __('common.unit_gal_min') }}
                                                @endif
                                            @else
                                                - {{ __('common.unit_gal_min') }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-2 small">
                                        <strong class="text-muted">{{ __('common.applicable_carrier') }}:</strong> 
                                        <span class="text-dark">
                                            @if($sim->applicable_carrier !== null && $sim->applicable_carrier !== '')
                                                @if(preg_match('/^([\d.]+)~([\d.]+)/', $sim->applicable_carrier, $m))
                                                    {{ number_format($m[1], 1) }}~{{ number_format($m[2], 1) }} {{ __('common.unit_lb') }}
                                                @elseif(is_numeric($sim->applicable_carrier))
                                                    {{ number_format($sim->applicable_carrier, 1) }} {{ __('common.unit_lb') }}
                                                @else
                                                    {{ $sim->applicable_carrier }} {{ __('common.unit_lb') }}
                                                @endif
                                            @else
                                                - {{ __('common.unit_lb') }}
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                                <div class="mt-3 pt-2 border-top">
                                    <span class="btn btn-outline-primary btn-sm w-100">{{ __('common.view_details') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Carousel Indicators -->
        <div class="carousel-indicators mt-3 d-flex justify-content-center gap-2">
            @for($i = 0; $i < ceil($similarProducts->count() / 3); $i++)
                <button class="carousel-indicator {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}" style="width: 12px; height: 12px; border-radius: 50%; border: 2px solid #dee2e6; background: {{ $i === 0 ? '#0d6efd' : 'transparent' }}; transition: all 0.3s ease; cursor: pointer;"></button>
            @endfor
        </div>
    </div>
</div>

<style>
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.hover-card:hover .card-img-top {
    transform: scale(1.05);
}

.carousel-indicator.active {
    background: #0d6efd !important;
    border-color: #0d6efd !important;
}

.carousel-indicator:hover {
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    cursor: pointer;
}

#carouselPrevBtn:hover, #carouselNextBtn:hover {
    background: #0b5ed7 !important;
    transform: translate(-50%, -50%) scale(1.1);
}

.carousel-container {
    padding: 0 30px;
}

@media (max-width: 768px) {
    .carousel-container {
        padding: 0 15px;
    }
    
    #carouselPrevBtn, #carouselNextBtn {
        width: 40px !important;
        height: 40px !important;
    }
}

/* RTL-specific styles */
[dir="rtl"] .carousel-container {
    direction: rtl;
}

[dir="rtl"] .d-flex.justify-content-between {
    direction: rtl;
}

[dir="rtl"] #carouselPrevBtn {
    right: -24px !important;
    left: auto !important;
}

[dir="rtl"] #carouselNextBtn {
    left: -24px !important;
    right: auto !important;
}
</style>
@endif

{{-- Scroll to Top Button --}}
<style>
/* Product Show Page Enhancements */
.product-image-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.product-image-container:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.product-specs-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.product-specs-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0b5ed7 0%, #0a58ca 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.specifications-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.specifications-table th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    color: #495057;
    padding: 16px;
    border-bottom: 2px solid #dee2e6;
}

.specifications-table td {
    padding: 16px;
    border-bottom: 1px solid #f8f9fa;
}

.specifications-table tr:last-child td {
    border-bottom: none;
}

.specifications-table tr:hover {
    background: #f8f9fa;
}

/* Carousel Enhancements */
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.hover-card:hover .card-img-top {
    transform: scale(1.05);
}

.carousel-indicator.active {
    background: #0d6efd !important;
    border-color: #0d6efd !important;
}

.carousel-indicator:hover {
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    cursor: pointer;
}

#carouselLeftArrow:hover, #carouselRightArrow:hover {
    background: linear-gradient(135deg, #0b5ed7 0%, #0a58ca 100%) !important;
    transform: translate(-50%, -50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4) !important;
}

.carousel-container {
    padding: 0 30px;
}

/* Scroll to Top Button */
#scrollTopBtn {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 999;
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    color: #fff;
    border: none;
    border-radius: 50px;
    min-width: 64px;
    height: 48px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0 1.5rem;
}

#scrollTopBtn:hover {
    background: linear-gradient(135deg, #0b5ed7 0%, #0a58ca 100%);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
}

/* Unit Toggle Enhancements */
.btn-group .btn {
    border: 2px solid #0d6efd;
    transition: all 0.3s ease;
}

.btn-group .btn.active {
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    border-color: #0d6efd;
    color: white;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

/* Badge Enhancements */
.badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .carousel-container {
        padding: 0 15px;
    }
    
    #carouselLeftArrow, #carouselRightArrow {
        width: 40px !important;
        height: 40px !important;
        margin-left: -20px !important;
        margin-right: -20px !important;
    }
    
    .btn-group .btn {
        padding: 6px 12px;
        font-size: 0.875rem;
    }
    
    .specifications-table th,
    .specifications-table td {
        padding: 12px;
    }
}

/* RTL Support */
[dir="rtl"] .carousel-container {
    padding: 0 30px 0 30px;
}

[dir="rtl"] #carouselLeftArrow {
    right: -24px;
    left: auto;
}

[dir="rtl"] #carouselRightArrow {
    left: -24px;
    right: auto;
}

[dir="rtl"] #scrollTopBtn {
    left: 32px;
    right: auto;
}

/* Animation for loading states */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

/* Enhanced unit value transitions */
.unit-value {
    transition: all 0.3s ease;
    display: inline-block;
}

.unit-value.updating {
    opacity: 0.6;
    transform: scale(0.95);
}
</style>
<button id="scrollTopBtn" title="{{ __('common.back_to_top') }}" style="display:none;">{{ __('common.top') }}</button>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Unit toggle functionality
    const siBtn = document.getElementById('siBtn');
    const imperialBtn = document.getElementById('imperialBtn');
    const unitValues = document.querySelectorAll('.unit-value');
    
    function setUnit(mode) {
        // Add updating class for smooth transition
        unitValues.forEach(function(el) {
            el.classList.add('updating');
        });
        
        setTimeout(() => {
            unitValues.forEach(function(el) {
                el.textContent = el.dataset[mode];
                el.classList.remove('updating');
            });
        }, 150);
        
        if (mode === 'si') {
            siBtn.classList.add('active');
            imperialBtn.classList.remove('active');
        } else {
            imperialBtn.classList.add('active');
            siBtn.classList.remove('active');
        }
    }
    
    if (siBtn && imperialBtn) {
        siBtn.addEventListener('click', function() { setUnit('si'); });
        imperialBtn.addEventListener('click', function() { setUnit('imperial'); });
        setUnit('{{ $unit ?? 'imperial' }}');
    }

    // Scroll to top button
    const scrollBtn = document.getElementById('scrollTopBtn');
    if (scrollBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollBtn.style.display = 'flex';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Modern carousel functionality
    const carousel = document.getElementById('similarProductsCarousel');
    const prevBtn = document.getElementById('carouselPrevBtn');
    const nextBtn = document.getElementById('carouselNextBtn');
    const indicators = document.querySelectorAll('.carousel-indicator');
    
    if (carousel && prevBtn && nextBtn) {
        let currentSlide = 0;
        const cardWidth = 320 + 12; // card width + gap
        const visibleCards = window.innerWidth >= 992 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
        const totalCards = carousel.children.length;
        const maxSlide = Math.max(0, Math.ceil(totalCards / visibleCards) - 1);
        const isRTL = document.documentElement.dir === 'rtl' || '{{ app()->getLocale() }}' === 'ar';
        
        function updateCarousel() {
            let translateX;
            if (isRTL) {
                // For RTL, we need to calculate differently
                translateX = currentSlide * cardWidth * visibleCards;
            } else {
                translateX = -(currentSlide * cardWidth * visibleCards);
            }
            
            carousel.style.transform = `translateX(${translateX}px)`;
            
            // Update button visibility
            prevBtn.style.display = currentSlide > 0 ? 'flex' : 'none';
            nextBtn.style.display = currentSlide < maxSlide ? 'flex' : 'none';
            
            // Update indicators
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlide);
            });
        }
        
        function nextSlide() {
            if (currentSlide < maxSlide) {
                currentSlide++;
                updateCarousel();
            }
        }
        
        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        }
        
        function goToSlide(slide) {
            currentSlide = Math.max(0, Math.min(slide, maxSlide));
            updateCarousel();
        }
        
        // Event listeners - note the logic is reversed for RTL
        if (isRTL) {
            nextBtn.addEventListener('click', prevSlide); // In RTL, right button goes to previous
            prevBtn.addEventListener('click', nextSlide); // In RTL, left button goes to next
        } else {
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);
        }
        
        // Indicator clicks
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => goToSlide(index));
        });
        
        // Touch/swipe support
        let startX = 0;
        let isDragging = false;
        
        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });
        
        carousel.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        });
        
        carousel.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            
            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            
            if (Math.abs(diff) > 50) {
                if (isRTL) {
                    // Reverse swipe logic for RTL
                    if (diff > 0) {
                        prevSlide();
                    } else {
                        nextSlide();
                    }
                } else {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
            }
        });
        
        // Mouse drag support
        let mouseStartX = 0;
        let isMouseDragging = false;
        
        carousel.addEventListener('mousedown', (e) => {
            mouseStartX = e.clientX;
            isMouseDragging = true;
            carousel.style.cursor = 'grabbing';
        });
        
        carousel.addEventListener('mousemove', (e) => {
            if (!isMouseDragging) return;
            e.preventDefault();
        });
        
        carousel.addEventListener('mouseup', (e) => {
            if (!isMouseDragging) return;
            isMouseDragging = false;
            carousel.style.cursor = 'grab';
            
            const endX = e.clientX;
            const diff = mouseStartX - endX;
            
            if (Math.abs(diff) > 50) {
                if (isRTL) {
                    // Reverse drag logic for RTL
                    if (diff > 0) {
                        prevSlide();
                    } else {
                        nextSlide();
                    }
                } else {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
            }
        });
        
        carousel.addEventListener('mouseleave', () => {
            isMouseDragging = false;
            carousel.style.cursor = 'grab';
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (isRTL) {
                // Reverse arrow keys for RTL
                if (e.key === 'ArrowLeft') {
                    nextSlide();
                } else if (e.key === 'ArrowRight') {
                    prevSlide();
                }
            } else {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                }
            }
        });
        
        // Auto-play (optional)
        let autoPlayInterval;
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                if (currentSlide < maxSlide) {
                    nextSlide();
                } else {
                    currentSlide = 0;
                    updateCarousel();
                }
            }, 5000);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        // Start auto-play and pause on hover
        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', startAutoPlay);
        
        // Responsive handling
        window.addEventListener('resize', () => {
            const newVisibleCards = window.innerWidth >= 992 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
            if (newVisibleCards !== visibleCards) {
                location.reload(); // Simple solution for responsive changes
            }
        });
        
        // Initialize
        updateCarousel();
        startAutoPlay();
    }

    // Enhanced share functionality
    const shareBtn = document.querySelector('.share-btn');
    if (shareBtn) {
        shareBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    text: '{{ $product->model_name }} - Check out this drilling equipment',
                    url: window.location.href
                }).catch(err => console.log('Error sharing:', err));
            } else {
                // Fallback for browsers that don't support native sharing
                navigator.clipboard.writeText(window.location.href).then(() => {
                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'toast-notification';
                    toast.innerHTML = `
                        <div class="toast-content">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            {{ __('common.link_copied') }}
                        </div>
                    `;
                    toast.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: white;
                        border: 1px solid #dee2e6;
                        border-radius: 8px;
                        padding: 12px 20px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        z-index: 1000;
                        transform: translateX(100%);
                        transition: transform 0.3s ease;
                    `;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.style.transform = 'translateX(0)';
                    }, 100);
                    
                    setTimeout(() => {
                        toast.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 300);
                    }, 3000);
                }).catch(err => {
                    console.log('Clipboard not supported:', err);
                    alert('Copy the URL to share: ' + window.location.href);
                });
            }
        });
    }
});
</script>
@endpush
