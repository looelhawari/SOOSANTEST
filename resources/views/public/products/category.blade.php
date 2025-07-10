@extends('layouts.public')

@section('title', $category->name . ' - Soosan Cebotics')
@section('description', 'Browse ' . $category->name . ' drilling equipment and machinery from Soosan Cebotics.')

@section('content')
    <div class="bg-light py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}"
                            class="text-decoration-none">{{ __('common.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}"
                            class="text-decoration-none">{{ __('common.products') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="mb-5">
                <h1 class="display-5 fw-bold mb-3">
                    {{ $category->name }}
                </h1>
                @if ($category->description)
                    <p class="lead">{{ $category->description }}</p>
                @endif
            </div>

            <!-- Products Grid -->
            @if ($products->count() > 0)
                <div class="row g-4 mb-5">
                    @foreach ($products as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm">
                                <!-- Product Image -->
                                @if ($product->getFirstMediaUrl('images'))
                                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}"
                                        class="card-img-top" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-image text-secondary" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            <path
                                                d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <!-- Product Name -->
                                    <h3 class="h5 fw-semibold mb-2 text-truncate">{{ $product->name }}</h3>

                                    <!-- Model Number -->
                                    @if ($product->model_number)
                                        <p class="small text-muted mb-2">{{ __('common.model') }}: {{ $product->model_number }}
                                        </p>
                                    @endif

                                    <!-- Description -->
                                    <p class="small mb-3"
                                        style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ Str::limit($product->description, 120) }}</p>

                                    <!-- Price -->
                                    @if ($product->price)
                                        <div class="mb-3">
                                            <span
                                                class="fs-4 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    @endif

                                    <!-- Action Button -->
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary mt-auto">
                                        {{ __('common.view_details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <!-- No Products Found -->
                <div class="text-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" fill="currentColor"
                        class="bi bi-box text-secondary mb-4" viewBox="0 0 16 16">
                        <path
                            d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                    </svg>
                    <h3 class="h4 fw-semibold mb-3">{{ __('common.no_products_found_in_category') }}</h3>
                    <p class="text-muted mb-4">{{ __('common.check_back_later_new_products') }}
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary px-4">
                        {{ __('common.browse_all_products') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
