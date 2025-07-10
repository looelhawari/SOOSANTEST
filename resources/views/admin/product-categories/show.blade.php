@extends('layouts.admin')

@section('title', __('product_categories.view_category'))
@section('page-title', __('product_categories.view_category') . ': ' . $category->name)

@push('styles')
<style>
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
    .modern-card-header {
        background: #FFFFFF;
        border-bottom: 1px solid #E9ECEF;
        padding: 1rem 1.25rem;
    }
    .modern-card-title {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 0;
    }
    .modern-btn {
        background: #0077C8;
        border: none;
        color: #F0F0F0;
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        font-weight: 600;
        transition: background 0.2s;
    }
    .modern-btn:hover {
        background: #005B99;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="modern-page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>{{ __('product_categories.view_category') }}: {{ $category->name }}</h1>
            </div>
            <a href="{{ route('admin.product-categories.index') }}" class="modern-btn">
                <i class="fas fa-arrow-left"></i> {{ __('product_categories.categories') }}
            </a>
        </div>
    </div>
</div>
<div class="row">
    <!-- Category Details Column -->
    <div class="col-lg-5">
        <div class="modern-card shadow-sm mb-4">
            <div class="modern-card-header d-flex justify-content-between align-items-center">
                <h5 class="modern-card-title mb-0">{{ $category->name }}</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ $category->icon_url ?: 'https://via.placeholder.com/200' }}" 
                         alt="{{ $category->name }}" 
                         class="img-fluid rounded-3 shadow-sm"
                         style="width: 100%; max-height: 300px; object-fit: cover;">
                </div>
                <p class="text-muted">{{ $category->description ?? __('product_categories.description') }}</p>
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ __('product_categories.slug') }}</span>
                        <span class="badge bg-secondary">{{ $category->slug }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ __('product_categories.parent_category') }}</span>
                        @if($category->parent)
                            <a href="{{ route('admin.product-categories.show', $category->parent_id) }}" class="badge bg-info text-dark text-decoration-none">{{ $category->parent->name }}</a>
                        @else
                            <span class="text-muted">{{ __('product_categories.none') }}</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ __('product_categories.products_count') }}</span>
                        <span class="badge bg-primary">{{ $category->products_count }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ __('product_categories.created_at') }}</span>
                        <small class="text-muted">{{ optional($category->created_at)->format('d M, Y') }}</small>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ __('product_categories.updated_at') }}</span>
                        <small class="text-muted">{{ optional($category->updated_at)->format('d M, Y') }}</small>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center bg-white border-top-0">
                <a href="{{ route('admin.product-categories.edit', $category) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> {{ __('product_categories.edit_category') }}
                </a>
            </div>
        </div>
    </div>
    <!-- Sub-categories and Products Column -->
    <div class="col-lg-7">
        <!-- Sub-categories Card -->
        <div class="modern-card shadow-sm mb-4">
            <div class="modern-card-header">
                <h6 class="mb-0"><i class="fas fa-sitemap me-2"></i>{{ __('product_categories.sub_categories') }}</h6>
            </div>
            <div class="card-body">
                @if(optional($category->children)->count() > 0)
                    <div class="list-group">
                        @foreach($category->children as $child)
                            <a href="{{ route('admin.product-categories.show', $child) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <img src="{{ $child->icon_url ?: 'https://via.placeholder.com/30' }}" class="rounded-circle me-2" width="30" height="30" alt="{{ $child->name }}">
                                    {{ $child->name }}
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $child->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center mb-0">
                        {{ __('product_categories.no_sub_categories') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
