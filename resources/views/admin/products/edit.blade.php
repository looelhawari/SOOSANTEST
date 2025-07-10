@extends('layouts.admin')

@section('title', __('products.edit_product'))
@section('page-title', __('products.edit_product'))

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
    .modern-header-actions {
        display: flex;
        gap: 1rem;
    }

    /* Form Container */
    .modern-form-container {
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 0.6s ease forwards;
    }
    .modern-form {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #E9ECEF;
        overflow: hidden;
    }
    .dark-mode .modern-form {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }

    /* Form Sections */
    .modern-section {
        padding: 1.5rem;
        border-bottom: 1px solid #E9ECEF;
        animation: fadeInUp 0.6s ease forwards;
    }
    .modern-section:last-child {
        border-bottom: none;
    }
    .dark-mode .modern-section {
        border-bottom-color: #4A4A4A;
    }
    .modern-section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #E9ECEF;
    }
    .dark-mode .modern-section-header {
        border-bottom-color: #4A4A4A;
    }
    .modern-section-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #0077C8;
        color: #F0F0F0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .dark-mode .modern-section-icon {
        background: #C1D82F;
        color: #333333;
    }
    .modern-section-title h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #333333;
        margin-bottom: 0.25rem;
    }
    .dark-mode .modern-section-title h3 {
        color: #F0F0F0;
    }
    .modern-section-title p {
        color: #6C757D;
        font-size: 0.85rem;
        margin: 0;
    }
    .dark-mode .modern-section-title p {
        color: #A0AEC0;
    }

    /* Form Fields */
    .modern-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .modern-form-group {
        display: flex;
        flex-direction: column;
    }
    .modern-form-group.full-width {
        grid-column: 1 / -1;
    }
    .modern-label {
        font-weight: 600;
        color: #333333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .dark-mode .modern-label {
        color: #F0F0F0;
    }
    .modern-label .required {
        color: #E53935;
        font-size: 0.75rem;
    }
    .modern-input,
    .modern-textarea,
    .modern-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #E9ECEF;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        background: #FFFFFF;
        color: #333333;
        transition: all 0.3s ease;
    }
    .modern-input:focus,
    .modern-textarea:focus,
    .modern-select:focus {
        border-color: #C1D82F;
        box-shadow: 0 0 0 0.2rem rgba(193, 216, 47, 0.25);
        outline: none;
        transform: translateY(-1px);
    }
    .dark-mode .modern-input,
    .dark-mode .modern-textarea,
    .dark-mode .modern-select {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .dark-mode .modern-input::placeholder,
    .dark-mode .modern-textarea::placeholder,
    .dark-mode .modern-select::placeholder {
        color: #A0AEC0;
    }
    .modern-textarea {
        min-height: 120px;
        resize: vertical;
    }
    .modern-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23333333' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em;
        padding-right: 2.5rem;
    }
    .dark-mode .modern-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23F0F0F0' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }
    .modern-input.error,
    .modern-select.error {
        border-color: #E53935;
        box-shadow: 0 0 0 0.2rem rgba(229, 57, 53, 0.25);
    }
    .modern-error {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* File Upload */
    .modern-file-upload {
        position: relative;
        border: 2px dashed #E9ECEF;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        background: #F9F9F9;
        transition: all 0.3s ease;
    }
    .dark-mode .modern-file-upload {
        border-color: #4A4A4A;
        background: #2D2D2D;
    }
    .modern-file-upload:hover {
        border-color: #C1D82F;
        background: rgba(193, 216, 47, 0.05);
        transform: scale(1.02);
        animation: pulse 1s infinite;
    }
    .modern-file-upload.dragover {
        border-color: #C1D82F;
        background: rgba(193, 216, 47, 0.1);
        transform: scale(1.02);
    }
    .modern-file-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }
    .modern-file-content {
        pointer-events: none;
    }
    .modern-file-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #0077C8;
        color: #F0F0F0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto 1rem;
    }
    .dark-mode .modern-file-icon {
        background: #C1D82F;
        color: #333333;
    }
    .modern-file-text h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #333333;
        margin-bottom: 0.5rem;
    }
    .dark-mode .modern-file-text h4 {
        color: #F0F0F0;
    }
    .modern-file-text p {
        color: #6C757D;
        font-size: 0.85rem;
        margin: 0;
    }
    .dark-mode .modern-file-text p {
        color: #A0AEC0;
    }

    /* Current and Preview Images */
    .modern-current-images,
    .modern-preview-container {
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 1rem;
    }
    .modern-current-images h4,
    .modern-preview-container h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #333333;
        margin-bottom: 1rem;
    }
    .dark-mode .modern-current-images h4,
    .dark-mode .modern-preview-container h4 {
        color: #F0F0F0;
    }
    .modern-current-item,
    .modern-preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        background: #F9F9F9;
        aspect-ratio: 1;
        border: 2px solid #E9ECEF;
    }
    .dark-mode .modern-current-item,
    .dark-mode .modern-preview-item {
        background: #2D2D2D;
        border-color: #4A4A4A;
    }
    .modern-current-item img,
    .modern-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .modern-current-remove,
    .modern-preview-remove {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(229, 57, 53, 0.9);
        color: #F0F0F0;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }
    .modern-current-remove:hover,
    .modern-preview-remove:hover {
        background: #E53935;
        transform: scale(1.1);
    }

    /* Checkbox */
    .modern-checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .modern-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid #E9ECEF;
        border-radius: 4px;
        position: relative;
        cursor: pointer;
    }
    .dark-mode .modern-checkbox {
        border-color: #4A4A4A;
    }
    .modern-checkbox input {
        opacity: 0;
        position: absolute;
        inset: 0;
        cursor: pointer;
    }
    .modern-checkbox input:checked + .modern-checkmark {
        background: #0077C8;
        border-color: #0077C8;
    }
    .dark-mode .modern-checkbox input:checked + .modern-checkmark {
        background: #C1D82F;
        border-color: #C1D82F;
    }
    .modern-checkmark {
        position: absolute;
        inset: 0;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    .modern-checkmark::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #F0F0F0;
        font-size: 0.75rem;
        font-weight: bold;
        opacity: 0;
        transition: all 0.3s ease;
    }
    .dark-mode .modern-checkmark::after {
        color: #333333;
    }
    .modern-checkbox input:checked + .modern-checkmark::after {
        opacity: 1;
    }
    .modern-checkbox-label {
        font-weight: 500;
        color: #333333;
        cursor: pointer;
    }
    .dark-mode .modern-checkbox-label {
        color: #F0F0F0;
    }
    .modern-checkbox-note {
        color: #6C757D;
        font-size: 0.75rem;
        margin-top: 0.5rem;
    }
    .dark-mode .modern-checkbox-note {
        color: #A0AEC0;
    }

    /* Form Actions */
    .modern-actions {
        padding: 1.5rem;
        background: #F9F9F9;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    .dark-mode .modern-actions {
        background: #2D2D2D;
    }
    .modern-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
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

    /* Alerts */
    .modern-alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        animation: fadeInUp 0.6s ease forwards;
    }
    .modern-alert.success {
        background: rgba(16, 185, 129, 0.1);
        color: #065F46;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .dark-mode .modern-alert.success {
        background: rgba(16, 185, 129, 0.2);
        color: #10B981;
    }
    .modern-alert.error {
        background: rgba(229, 57, 53, 0.1);
        color: #991B1B;
        border: 1px solid rgba(229, 57, 53, 0.3);
    }
    .dark-mode .modern-alert.error {
        background: rgba(229, 57, 53, 0.2);
        color: #E53935;
    }

    /* Loading State */
    .modern-btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    .modern-btn.loading::after {
        content: '';
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 0.5rem;
    }
    @keyframes spin {
        to {
            transform: rotate(360deg);
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
        .modern-header-actions {
            flex-direction: column;
            width: 100%;
        }
        .modern-btn {
            width: 100%;
            justify-content: center;
        }
        .modern-form-grid {
            grid-template-columns: 1fr;
        }
        .modern-actions {
            flex-direction: column;
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
                    <h1><i class="fas fa-edit"></i> {{ __('products.edit_product') }}</h1>
                    <p>{{ __('products.update_product_info') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="modern-header-actions">
                        <a href="{{ route('admin.products.show', $product) }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-eye"></i>
                            {{ __('products.view_product') }}
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            {{ __('products.back_to_products') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="modern-alert success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="modern-alert error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Form -->
    <div class="modern-form-container">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="modern-form" id="productEditForm">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="modern-section">
                <div class="modern-section-header">
                    <div class="modern-section-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="modern-section-title">
                        <h3>{{ __('products.basic_information') }}</h3>
                        <p>{{ __('products.essential_product_details') }}</p>
                    </div>
                </div>
                <div class="modern-form-grid">
                    <div class="modern-form-group">
                        <label for="model_name" class="modern-label">
                            {{ __('products.model_name') }} <span class="required">{{ __('products.required') }}</span>
                        </label>
                        <input type="text" 
                               id="model_name" 
                               name="model_name" 
                               class="modern-input @error('model_name') error @enderror" 
                               value="{{ old('model_name', $product->model_name) }}" 
                               placeholder="{{ __('products.enter_model_name') }}"
                               required>
                        @error('model_name')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="price" class="modern-label">
                            {{ __('products.price') }} <span class="required">{{ __('products.required') }}</span>
                        </label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               class="modern-input @error('price') error @enderror" 
                               value="{{ old('price', $product->price) }}" 
                               step="0.01"
                               min="0"
                               placeholder="0.00"
                               required>
                        @error('price')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="category_id" class="modern-label">
                            {{ __('products.category') }} <span class="required">{{ __('products.required') }}</span>
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                class="modern-select @error('category_id') error @enderror"
                                required>
                            <option value="">{{ __('products.select_category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="line" class="modern-label">
                            {{ __('products.line') }}
                        </label>
                        <input type="text" 
                               id="line" 
                               name="line" 
                               class="modern-input @error('line') error @enderror" 
                               value="{{ old('line', $product->line) }}" 
                               placeholder="{{ __('products.enter_product_line') }}">
                        @error('line')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="type" class="modern-label">
                            {{ __('products.type') }}
                        </label>
                        <input type="text" 
                               id="type" 
                               name="type" 
                               class="modern-input @error('type') error @enderror" 
                               value="{{ old('type', $product->type) }}" 
                               placeholder="{{ __('products.enter_product_type') }}">
                        @error('type')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Specifications Section -->
            <div class="modern-section">
                <div class="modern-section-header">
                    <div class="modern-section-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="modern-section-title">
                        <h3>{{ __('products.technical_specifications') }}</h3>
                        <p>{{ __('products.technical_specifications_desc') }}</p>
                    </div>
                </div>
                <div class="modern-form-grid">
                    <div class="modern-form-group">
                        <label for="body_weight" class="modern-label">
                            {{ __('products.body_weight') }}
                        </label>
                        <input type="text" 
                               id="body_weight" 
                               name="body_weight" 
                               class="modern-input @error('body_weight') error @enderror" 
                               value="{{ old('body_weight', $product->body_weight) }}" 
                               placeholder="e.g., 500 kg">
                        @error('body_weight')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="operating_weight" class="modern-label">
                            {{ __('products.operating_weight') }}
                        </label>
                        <input type="text" 
                               id="operating_weight" 
                               name="operating_weight" 
                               class="modern-input @error('operating_weight') error @enderror" 
                               value="{{ old('operating_weight', $product->operating_weight) }}" 
                               placeholder="e.g., 600 kg">
                        @error('operating_weight')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="overall_length" class="modern-label">
                            {{ __('products.overall_length') }}
                        </label>
                        <input type="text" 
                               id="overall_length" 
                               name="overall_length" 
                               class="modern-input @error('overall_length') error @enderror" 
                               value="{{ old('overall_length', $product->overall_length) }}" 
                               placeholder="e.g., 2500 mm">
                        @error('overall_length')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="overall_width" class="modern-label">
                            {{ __('products.overall_width') }}
                        </label>
                        <input type="text" 
                               id="overall_width" 
                               name="overall_width" 
                               class="modern-input @error('overall_width') error @enderror" 
                               value="{{ old('overall_width', $product->overall_width) }}" 
                               placeholder="e.g., 800 mm">
                        @error('overall_width')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="overall_height" class="modern-label">
                            {{ __('products.overall_height') }}
                        </label>
                        <input type="text" 
                               id="overall_height" 
                               name="overall_height" 
                               class="modern-input @error('overall_height') error @enderror" 
                               value="{{ old('overall_height', $product->overall_height) }}" 
                               placeholder="e.g., 1200 mm">
                        @error('overall_height')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="required_oil_flow" class="modern-label">
                            {{ __('products.required_oil_flow') }}
                        </label>
                        <input type="text" 
                               id="required_oil_flow" 
                               name="required_oil_flow" 
                               class="modern-input @error('required_oil_flow') error @enderror" 
                               value="{{ old('required_oil_flow', $product->required_oil_flow) }}" 
                               placeholder="e.g., 45-80 L/min">
                        @error('required_oil_flow')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="operating_pressure" class="modern-label">
                            {{ __('products.operating_pressure') }}
                        </label>
                        <input type="text" 
                               id="operating_pressure" 
                               name="operating_pressure" 
                               class="modern-input @error('operating_pressure') error @enderror" 
                               value="{{ old('operating_pressure', $product->operating_pressure) }}" 
                               placeholder="e.g., 130-160 bar">
                        @error('operating_pressure')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="impact_rate" class="modern-label">
                            {{ __('products.impact_rate') }}
                        </label>
                        <input type="text" 
                               id="impact_rate" 
                               name="impact_rate" 
                               class="modern-input @error('impact_rate') error @enderror" 
                               value="{{ old('impact_rate', $product->impact_rate) }}" 
                               placeholder="e.g., 450-1000 BPM">
                        @error('impact_rate')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="impact_rate_soft_rock" class="modern-label">
                            {{ __('products.impact_rate_soft_rock') }}
                        </label>
                        <input type="text" 
                               id="impact_rate_soft_rock" 
                               name="impact_rate_soft_rock" 
                               class="modern-input @error('impact_rate_soft_rock') error @enderror" 
                               value="{{ old('impact_rate_soft_rock', $product->impact_rate_soft_rock) }}" 
                               placeholder="e.g., 800-1200 BPM">
                        @error('impact_rate_soft_rock')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="hose_diameter" class="modern-label">
                            {{ __('products.hose_diameter') }}
                        </label>
                        <input type="text" 
                               id="hose_diameter" 
                               name="hose_diameter" 
                               class="modern-input @error('hose_diameter') error @enderror" 
                               value="{{ old('hose_diameter', $product->hose_diameter) }}" 
                               placeholder="e.g., 19 mm">
                        @error('hose_diameter')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="rod_diameter" class="modern-label">
                            {{ __('products.rod_diameter') }}
                        </label>
                        <input type="text" 
                               id="rod_diameter" 
                               name="rod_diameter" 
                               class="modern-input @error('rod_diameter') error @enderror" 
                               value="{{ old('rod_diameter', $product->rod_diameter) }}" 
                               placeholder="e.g., 120 mm">
                        @error('rod_diameter')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <label for="applicable_carrier" class="modern-label">
                            {{ __('products.applicable_carrier') }}
                        </label>
                        <input type="text" 
                               id="applicable_carrier" 
                               name="applicable_carrier" 
                               class="modern-input @error('applicable_carrier') error @enderror" 
                               value="{{ old('applicable_carrier', $product->applicable_carrier) }}" 
                               placeholder="e.g., 8-15 ton excavator">
                        @error('applicable_carrier')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Product Images Section -->
            <div class="modern-section">
                <div class="modern-section-header">
                    <div class="modern-section-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="modern-section-title">
                        <h3>{{ __('products.product_images') }}</h3>
                        
                    </div>
                </div>
                @if($product->images && count($product->images) > 0)
                    <div class="modern-current-images">
                        <h4>{{ __('products.current_images') }}</h4>
                        <div class="modern-current-grid" id="currentImages">
                            @foreach($product->images as $index => $image)
                                <div class="modern-current-item" data-image-index="{{ $index }}">
                                    <img src="{{ $image }}" alt="{{ __('products.product_image') }} {{ $index + 1 }}">
                                    <button type="button" class="modern-current-remove" onclick="removeCurrentImage({{ $index }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="removedImages" name="removed_images" value="">
                    </div>
                @endif
                <div class="modern-form-group full-width">
                    <label for="images" class="modern-label">
                       
                    </label>
                    <div class="modern-file-upload" id="fileUpload">
                        <input type="file" 
                               id="images" 
                               name="images[]" 
                               class="modern-file-input @error('images') error @enderror" 
                               multiple 
                               accept="image/*">
                        <div class="modern-file-content">
                            <div class="modern-file-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="modern-file-text">
                                <h4>click to upload</h4>
                                
                            </div>
                        </div>
                        <div class="modern-preview-container" id="imagePreview"></div>
                    </div>
                    @error('images')
                        <span class="modern-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Product Settings Section -->
            <div class="modern-section">
                <div class="modern-section-header">
                    <div class="modern-section-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    
                </div>
                <div class="modern-form-grid">
                    <div class="modern-form-group">
                        <label for="status" class="modern-label">
                            {{ __('products.status') }} <span class="required">{{ __('products.required') }}</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="modern-select @error('status') error @enderror"
                                required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>{{ __('products.active') }}</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>{{ __('products.inactive') }}</option>
                        </select>
                        @error('status')
                            <span class="modern-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="modern-form-group">
                        <div class="modern-checkbox-group">
                            <label class="modern-checkbox">
                                <input type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <span class="modern-checkmark"></span>
                            </label>
                            <label for="is_featured" class="modern-checkbox-label">
                                {{ __('products.featured_product') }}
                            </label>
                        </div>
                       
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="modern-actions">
                <a href="{{ route('admin.products.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-times"></i>
                    {{ __('products.cancel') }}
                </a>
                <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    {{ __('products.update_product') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Keep track of removed images
    let removedImages = [];
    let selectedFiles = [];

    // File upload handling
    const fileUpload = document.getElementById('fileUpload');
    const fileInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');

    // Click to trigger file input
    fileUpload.addEventListener('click', function(e) {
        if (e.target === fileInput) return;
        fileInput.click();
    });

    // Drag and drop functionality
    fileUpload.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUpload.classList.add('dragover');
    });

    fileUpload.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileUpload.classList.remove('dragover');
    });

    fileUpload.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUpload.classList.remove('dragover');
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    fileInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        handleFiles(files);
    });

    function handleFiles(files) {
        files.forEach(file => {
            if (!file.type.startsWith('image/')) {
                alert('{{ __('products.invalid_file_type') }}');
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('{{ __('products.file_too_large') }}');
                return;
            }
            selectedFiles.push(file);
            displayImagePreview(file);
        });
        updateFileInput();
    }

    function displayImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'modern-preview-item';
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="modern-preview-remove" onclick="removeNewImage(this, '${file.name}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            imagePreview.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    }

    window.removeNewImage = function(button, fileName) {
        selectedFiles = selectedFiles.filter(file => file.name !== fileName);
        button.closest('.modern-preview-item').remove();
        updateFileInput();
    };

    window.removeCurrentImage = function(index) {
        removedImages.push(index);
        document.getElementById('removedImages').value = JSON.stringify(removedImages);
        document.querySelector(`[data-image-index="${index}"]`).remove();
    };

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    // Form validation
    const form = document.getElementById('productEditForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            const modelName = document.getElementById('model_name');
            const categoryId = document.getElementById('category_id');
            const price = document.getElementById('price');
            const status = document.getElementById('status');

            if (!modelName.value.trim()) {
                e.preventDefault();
                modelName.focus();
                alert('{{ __('products.enter_model_name') }}');
                return;
            }

            if (!categoryId.value) {
                e.preventDefault();
                categoryId.focus();
                alert('{{ __('products.select_category') }}');
                return;
            }

            if (!price.value || price.value < 0) {
                e.preventDefault();
                price.focus();
                alert('{{ __('products.enter_valid_price') }}');
                return;
            }

            if (!status.value) {
                e.preventDefault();
                status.focus();
                alert('{{ __('products.select_status') }}');
                return;
            }

            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }

    // Clear error styling on input
    const inputs = document.querySelectorAll('.modern-input, .modern-select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('error') && this.value.trim()) {
                this.classList.remove('error');
                const errorMsg = this.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('modern-error')) {
                    errorMsg.style.display = 'none';
                }
            }
        });
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