@extends('layouts.admin')

@section('title', __('sold-products.edit_sale'))
@section('page-title', __('sold-products.edit_sale'))

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
    .modern-form-group {
        margin-bottom: 1.5rem;
    }
    .modern-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
    }
    .modern-input, .modern-select {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid #e9ecef;
        border-radius: 0.75rem;
        background: #fff;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .modern-input:focus, .modern-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-1px);
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
    .sale-icon-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        margin: 0 auto 1rem;
        box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
    }
</style>

<!-- Page Header -->
<div class="modern-page-header">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">{{ __('sold-products.edit_sale') }}</h1>
                <p class="mb-0 opacity-75">{{ __('sold-products.update_information') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="btn-group">
                    <a href="{{ route('admin.sold-products.show', $soldProduct) }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-eye me-2"></i>
                        {{ __('sold-products.view_sale') }}
                    </a>
                    <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        {{ __('sold-products.back_to_sales') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="modern-card">
            <div class="card-header bg-white border-bottom p-4">
                <div class="text-center">
                    <div class="sale-icon-large">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4 class="mb-1">{{ __('sold-products.sale_number', ['id' => $soldProduct->id]) }}</h4>
                    <p class="text-muted">{{ $soldProduct->product->model_name ?? __('sold-products.na') }} - {{ $soldProduct->owner->name ?? __('sold-products.na') }}</p>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.sold-products.update', $soldProduct) }}" method="POST" id="editSaleForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Product Selection -->
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="product_id" class="modern-label">Product <span class="text-danger">*</span></label>
                                <select class="modern-select @error('product_id') is-invalid @enderror" 
                                        id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id', $soldProduct->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->model_name }} - {{ $product->category->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Owner Selection -->
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="owner_id" class="modern-label">{{ __('sold-products.owner') }} <span class="text-danger">*</span></label>
                                <select class="modern-select @error('owner_id') is-invalid @enderror" 
                                        id="owner_id" name="owner_id" required>
                                    <option value="">{{ __('sold-products.select_owner') }}</option>
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ old('owner_id', $soldProduct->owner_id) == $owner->id ? 'selected' : '' }}>
                                            {{ $owner->name }} - {{ $owner->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('owner_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Employee Selection -->
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="employee_id" class="modern-label">{{ __('sold-products.employee') }} <span class="text-danger">*</span></label>
                                <select class="modern-select @error('employee_id') is-invalid @enderror" 
                                        id="employee_id" name="employee_id" required>
                                    <option value="">{{ __('sold-products.select_employee') }}</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $soldProduct->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ ucfirst($employee->role) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="serial_number" class="modern-label">{{ __('sold-products.serial_number') }} <span class="text-danger">*</span></label>
                                <input type="text" class="modern-input @error('serial_number') is-invalid @enderror" 
                                       id="serial_number" name="serial_number" 
                                       value="{{ old('serial_number', $soldProduct->serial_number) }}" 
                                       placeholder="{{ __('sold-products.enter_serial_number') }}" required>
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sale Date -->
                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label for="sale_date" class="modern-label">{{ __('sold-products.sale_date') }} <span class="text-danger">*</span></label>
                                <input type="date" class="modern-input @error('sale_date') is-invalid @enderror" 
                                       id="sale_date" name="sale_date" 
                                       value="{{ old('sale_date', $soldProduct->sale_date ? $soldProduct->sale_date->format('Y-m-d') : '') }}" required>
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Warranty Start Date -->
                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label for="warranty_start_date" class="modern-label">{{ __('sold-products.warranty_start') }} <span class="text-danger">*</span></label>
                                <input type="date" class="modern-input @error('warranty_start_date') is-invalid @enderror" 
                                       id="warranty_start_date" name="warranty_start_date" 
                                       value="{{ old('warranty_start_date', $soldProduct->warranty_start_date ? $soldProduct->warranty_start_date->format('Y-m-d') : '') }}" required>
                                @error('warranty_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Warranty End Date -->
                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label for="warranty_end_date" class="modern-label">{{ __('sold-products.warranty_end') }} <span class="text-danger">*</span></label>
                                <input type="date" class="modern-input @error('warranty_end_date') is-invalid @enderror" 
                                       id="warranty_end_date" name="warranty_end_date" 
                                       value="{{ old('warranty_end_date', $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('Y-m-d') : '') }}" required>
                                @error('warranty_end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Purchase Price -->
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label for="purchase_price" class="modern-label">{{ __('sold-products.purchase_price') }}</label>
                                <input type="number" step="0.01" min="0" class="modern-input @error('purchase_price') is-invalid @enderror" 
                                       id="purchase_price" name="purchase_price" 
                                       value="{{ old('purchase_price', $soldProduct->purchase_price) }}" 
                                       placeholder="0.00">
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <div class="modern-form-group">
                                <label for="notes" class="modern-label">{{ __('sold-products.notes') }}</label>
                                <textarea class="modern-input @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="4" 
                                          placeholder="{{ __('sold-products.additional_notes_placeholder') }}">{{ old('notes', $soldProduct->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            {{ __('sold-products.cancel') }}
                        </a>
                        <button type="submit" class="modern-btn">
                            <i class="fas fa-save me-2"></i>
                            {{ __('sold-products.update_sale') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate warranty end date when warranty start date changes
    const warrantyStartInput = document.getElementById('warranty_start_date');
    const warrantyEndInput = document.getElementById('warranty_end_date');
    
    warrantyStartInput.addEventListener('change', function() {
        if (this.value && !warrantyEndInput.value) {
            // Default to 1 year warranty
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setFullYear(endDate.getFullYear() + 1);
            warrantyEndInput.value = endDate.toISOString().split('T')[0];
        }
    });
});
</script>
@endsection
