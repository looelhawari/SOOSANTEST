@extends('layouts.admin')

@section('title', __('product_categories.edit_category'))
@section('page-title', __('product_categories.categories'))
@section('page-subtitle', __('product_categories.edit_category'))

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
    .modern-form-group {
        margin-bottom: 1.5rem;
    }
    .modern-label {
        font-weight: 600;
        color: #333333;
        margin-bottom: 0.5rem;
        display: block;
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
                    <h1>{{ __('product_categories.edit_category') }}: {{ $productCategory->name }}</h1>
                    <p class="mb-0">{{ __('product_categories.edit_category') }}</p>
                </div>
                <a href="{{ route('admin.product-categories.index') }}" class="modern-btn">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('product_categories.categories') }}
                </a>
            </div>
        </div>
    </div>
    <div class="modern-card">
        <div class="modern-card-header">
            <span class="modern-card-title">{{ __('product_categories.edit_category') }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product-categories.update', $productCategory) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="modern-form-group">
                            <label for="name" class="modern-label">{{ __('product_categories.name') }} *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $productCategory->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="slug" class="modern-label">{{ __('product_categories.slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $productCategory->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="description" class="modern-label">{{ __('product_categories.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $productCategory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="modern-form-group">
                            <label for="parent_id" class="modern-label">{{ __('product_categories.parent_category') }}</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">{{ __('product_categories.none') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_id', $productCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="icon" class="modern-label">{{ __('product_categories.icon') }}</label>
                            @if($productCategory->icon_url)
                                <div class="mb-2">
                                    <img src="{{ $productCategory->icon_url }}" alt="Current Icon" style="max-width: 120px; max-height: 120px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" accept="image/*">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="modern-btn">
                        <i class="fas fa-save me-1"></i> {{ __('product_categories.save_category') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon-preview');

        let slugManuallyEdited = slugInput.value.trim() !== '';

        nameInput.addEventListener('input', function() {
            if (!slugManuallyEdited) {
                slugInput.value = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '');
            }
        });

        slugInput.addEventListener('input', function() {
            slugManuallyEdited = true;
        });

        iconInput.addEventListener('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    iconPreview.src = e.target.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    });
</script>
@endpush

