@extends('layouts.admin')

@section('title', __('product_categories.categories'))
@section('page-title', __('product_categories.categories'))
@section('page-subtitle', __('product_categories.categories_management'))

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ __('product_categories.categories') }}</h5>
                <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary float-end"><i class="fas fa-plus me-2"></i>{{ __('product_categories.add_category') }}</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('global.close') }}"></button>
                </div>
            @endif

            <div class="row">
                @forelse($categories as $category)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm category-card">
                            <a href="{{ route('admin.product-categories.show', $category) }}">
                                @php $iconUrl = $category->icon_url; @endphp
                                <img src="{{ $iconUrl && $iconUrl !== '' ? asset($iconUrl) : 'https://via.placeholder.com/400x300' }}"
                                     class="card-img-top"
                                     alt="{{ $category->name }}"
                                     style="height: 200px; object-fit: cover;"
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300';">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <p class="card-text text-muted small">
                                    @if($category->parent)
                                        {{ __('product_categories.parent_category') }}: <a href="{{ route('admin.product-categories.show', $category->parent_id) }}">{{ $category->parent->name }}</a>
                                    @else
                                        {{ __('product_categories.parent_category') }}: {{ __('product_categories.none') }}
                                    @endif
                                </p>
                                <div class="mt-auto">
                                    <span class="badge bg-primary">{{ $category->products_count }} {{ __('product_categories.products_count') }}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ optional($category->created_at)->format('d/m/Y') }}</small>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.product-categories.show', $category) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.product-categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" 
                                              onsubmit="return confirm('{{ __('product_categories.confirm_delete') }}');" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            {{ __('product_categories.no_categories') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
