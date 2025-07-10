@extends('layouts.public')

@section('title', __('common.products_title') . ' - Soosan Cebotics')
@section('description', __('common.products_description'))

@section('page-header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <h1 class="display-6 fw-bold text-dark mb-0">{{ __('common.products_title') }}</h1>
        <form id="mainSearchForm" method="GET" action="{{ route('products.index') }}" class="d-flex justify-content-center" autocomplete="off">
            <div class="input-group shadow rounded-pill" style="max-width: 500px; background: #fff;">
                <span class="input-group-text bg-white border-0 rounded-start-pill px-3" style="font-size: 1.3rem; color: #888;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="hidden" name="unit" value="{{ $unit }}">
                <input type="text" name="search" id="search" class="form-control border-0 rounded-0 rounded-end-pill px-3 py-2" maxlength="100" value="{{ old('search', e($search ?? '')) }}" placeholder="{{ __('common.enter_product_model') }}" style="font-size: 1.1rem; background: #fff;">
                <button class="btn btn-primary rounded-end-pill px-4" type="submit" style="font-weight: 500;">
                    {{ __('common.search_products') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <div class="mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="btn-group ms-3" role="group" aria-label="Unit Toggle">
                    <button type="button" class="btn btn-outline-primary{{ $unit === 'si' ? ' active' : '' }}" id="siBtn">{{ __('common.si_units') }}</button>
                    <button type="button" class="btn btn-outline-primary{{ $unit === 'imperial' ? ' active' : '' }}" id="imperialBtn">{{ __('common.imperial_units') }}</button>
                </div>
            </div>
            <div class="flex-grow-1 d-none d-lg-block"></div>
        </div>
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3 mb-4">
                <form id="filterForm" method="GET" action="{{ route('products.index') }}">
                    <input type="hidden" name="unit" id="unitInput" value="{{ $unit }}">
                    <div class="card p-3 mb-3 shadow-sm border-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">{{ __('common.filter') }}</h5>
                            <button type="button" id="resetFiltersBtn" class="btn btn-link p-0 m-0 text-primary" title="{{ __('common.reset_filters') }}" style="font-size: 1.3rem;">
                                <i class="fas fa-rotate-right"></i>
                            </button>
                        </div>
                        <!-- Filter Options -->
                        @foreach ([
                            [__('common.line'), $lines, 'line'], 
                            [__('common.type'), $types, 'type'], 
                            [__('common.operating_weight'), $operating_weights, 'operating_weight'], 
                            [__('common.required_oil_flow'), $required_oil_flows, 'required_oil_flow'], 
                            [__('common.applicable_carrier'), $applicable_carriers, 'applicable_carrier']
                        ] as $i => [$label, $options, $name])
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">{{ $label }}</label>
                            @foreach ($options as $option)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="{{ $name }}[]" value="{{ $option }}" id="{{ $name }}-{{ $option }}" {{ in_array($option, (array)request($name, [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $name }}-{{ $option }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        </div>
                        @if ($i < 4)
                            <hr class="my-2" style="border-top: 1.5px solid #e5e7eb; opacity: 0.7;">
                        @endif
                        @endforeach
                    </div>
                </form>
            </div>
            <!-- Products Grid -->
            <div class="col-lg-9">
                <div id="productsGrid">
                @if ($products->count() > 0)
                    <div class="row g-4 mb-4">
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4 d-flex justify-content-center">
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                    <div class="card h-100 product-card shadow-sm border-0" style="min-height: 340px; width:320px;">
                                        @if (!empty($product->image_url))
                                            <div style="background: #fff; display: flex; align-items: center; justify-content: center; height: 200px;">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}" class="card-img-top" style="max-height: 180px; max-width: 100%; object-fit: contain; width: auto; height: auto;" loading="lazy">
                                            </div>
                                        @elseif (method_exists($product, 'getFirstMediaUrl'))
                                            <div style="background: #fff; display: flex; align-items: center; justify-content: center; height: 200px;">
                                                <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->model_name }}" class="card-img-top" style="max-height: 180px; max-width: 100%; object-fit: contain; width: auto; height: auto;" loading="lazy">
                                            </div>
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <span class="text-muted">{{ __('common.no_image') }}</span>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title fw-semibold mb-2 text-nowrap" style="font-size:1.1rem;">{{ $product->model_name }}</h5>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex justify-content-between"><strong>{{ __('common.operating_weight') }}:</strong> <span class="unit-operating-weight" data-lb="{{ $product->operating_weight }}">{{ $product->operating_weight }} {{ __('common.unit_lb') }}</span></li>
                                                <li class="d-flex justify-content-between"><strong>{{ __('common.required_oil_flow') }}:</strong> <span class="unit-oil-flow" data-galmin="{{ $product->required_oil_flow }}">{{ $product->required_oil_flow }} {{ __('common.unit_gal_min') }}</span></li>
                                                <li class="d-flex justify-content-between"><strong>{{ __('common.applicable_carrier') }}:</strong> <span class="unit-carrier" data-lb="{{ $product->applicable_carrier }}">{{ $product->applicable_carrier }} {{ __('common.unit_lb') }}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-4">
                        <div class="text-center text-muted small mb-2">
                            {{ __('common.showing_results', [
                                'first' => $products->firstItem(),
                                'last' => $products->lastItem(),
                                'total' => $products->total()
                            ]) }}
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h3 class="h4 fw-semibold text-dark mb-2">{{ __('common.no_products_found') }}</h3>
                        <p class="text-muted mb-4">{{ __('common.try_adjusting_search') }}</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">{{ __('common.view_all_products') }}</a>
                    </div>
                @endif
                </div>
                <div id="productsLoading" class="text-center py-5" style="display:none;">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">{{ __('common.loading') }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle logic
    const siBtn = document.getElementById('siBtn');
    const imperialBtn = document.getElementById('imperialBtn');
    const unitInput = document.getElementById('unitInput');
    siBtn.addEventListener('click', function() {
        unitInput.value = 'si';
        siBtn.classList.add('active');
        imperialBtn.classList.remove('active');
        document.getElementById('filterForm').dispatchEvent(new Event('submit'));
    });
    imperialBtn.addEventListener('click', function() {
        unitInput.value = 'imperial';
        imperialBtn.classList.add('active');
        siBtn.classList.remove('active');
        document.getElementById('filterForm').dispatchEvent(new Event('submit'));
    });
    // AJAX filter logic
    const filterForm = document.getElementById('filterForm');
    const checkboxes = filterForm.querySelectorAll('.filter-checkbox');
    const productsGrid = document.getElementById('productsGrid');
    const productsLoading = document.getElementById('productsLoading');
    const mainSearchForm = document.getElementById('mainSearchForm');
    const searchInput = document.getElementById('search');
    let debounceTimeout = null;
    function ajaxUpdate(url, formData) {
        productsGrid.style.display = 'none';
        productsLoading.style.display = 'block';
        fetch(url + (formData ? ('?' + formData) : ''), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
            credentials: 'same-origin',
            cache: 'no-store',
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newGrid = doc.getElementById('productsGrid');
            const newTotal = doc.getElementById('totalProducts');
            if (newGrid) {
                productsGrid.innerHTML = newGrid.innerHTML;
            }
            if (newTotal) {
                document.getElementById('totalProducts').textContent = newTotal.textContent;
            }
            productsGrid.style.display = '';
            productsLoading.style.display = 'none';
            convertUnits();
            attachPaginationAjax();
            focusFirstCard();
        })
        .catch(() => {
            productsGrid.style.display = '';
            productsLoading.style.display = 'none';
        });
    }
    // Debounced AJAX for filter checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            e.preventDefault();
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const formData = new FormData(filterForm);
                // Best practice: Use append for all values, so arrays are sent as key=value1&key=value2&key=value3
                const params = new URLSearchParams();
                for (const [key, value] of formData) {
                    params.append(key, value);
                }
                // Debug: log params to ensure all checked values are sent
                // console.log([...params.entries()]);
                ajaxUpdate(filterForm.action, params.toString());
            }, 250);
        });
    });
    // AJAX for pagination
    function attachPaginationAjax() {
        productsGrid.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.getAttribute('href'), window.location.origin);
                // Collect current filters and search state
                const filterFormData = new FormData(filterForm);
                const searchFormData = new FormData(mainSearchForm);
                // Merge filter and search form data
                for (const [key, value] of searchFormData.entries()) {
                    if (!filterFormData.has(key)) {
                        filterFormData.append(key, value);
                    }
                }
                // Set the page parameter from the clicked link
                const page = url.searchParams.get('page');
                if (page) {
                    filterFormData.set('page', page);
                }
                // Build params
                const params = new URLSearchParams();
                for (const pair of filterFormData.entries()) {
                    params.append(pair[0], pair[1]);
                }
                ajaxUpdate(filterForm.action, params.toString());
            });
        });
    }
    attachPaginationAjax();
    // AJAX for search bar
    mainSearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const formData = new FormData(mainSearchForm);
            const filterData = new FormData(filterForm);
            for (const pair of filterData.entries()) {
                if (!formData.has(pair[0])) {
                    formData.append(pair[0], pair[1]);
                }
            }
            const params = new URLSearchParams();
            for (const pair of formData.entries()) {
                params.append(pair[0], pair[1]);
            }
            ajaxUpdate(mainSearchForm.action, params.toString());
        }, 200);
    });
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            mainSearchForm.dispatchEvent(new Event('submit'));
        }
    });
    // Dynamic unit conversion
    function convertUnits() {
        const isImperial = document.getElementById('imperialBtn').classList.contains('active');
        document.querySelectorAll('.unit-operating-weight').forEach(function(el) {
            const lb = parseFloat(el.dataset.lb); // This is actually lb from database
            if (!isNaN(lb)) {
                el.textContent = isImperial ? lb.toFixed(1) + ' lb' : (lb * 0.453592).toFixed(1) + ' kg';
            } else {
                el.textContent = isImperial ? '- lb' : '- kg';
            }
        });
        document.querySelectorAll('.unit-oil-flow').forEach(function(el) {
            const galmin = el.dataset.galmin.split('~'); // This is actually gal/min from database
            if (galmin.length === 2) {
                const min = parseFloat(galmin[0]);
                const max = parseFloat(galmin[1]);
                if (!isNaN(min) && !isNaN(max)) {
                    el.textContent = isImperial ? min.toFixed(1) + '~' + max.toFixed(1) + ' gal/min' : (min * 3.78541).toFixed(1) + '~' + (max * 3.78541).toFixed(1) + ' l/min';
                } else {
                    el.textContent = isImperial ? '- gal/min' : '- l/min';
                }
            } else {
                const val = parseFloat(galmin[0]);
                if (!isNaN(val)) {
                    el.textContent = isImperial ? val.toFixed(1) + ' gal/min' : (val * 3.78541).toFixed(1) + ' l/min';
                } else {
                    el.textContent = isImperial ? '- gal/min' : '- l/min';
                }
            }
        });
        document.querySelectorAll('.unit-carrier').forEach(function(el) {
            const lb = el.dataset.lb.split('~'); // This is actually lb from database
            if (lb.length === 2) {
                const min = parseFloat(lb[0]);
                const max = parseFloat(lb[1]);
                if (!isNaN(min) && !isNaN(max))
                    el.textContent = isImperial ? min.toLocaleString(undefined, {maximumFractionDigits: 1}) + '~' + max.toLocaleString(undefined, {maximumFractionDigits: 1}) + ' lb' : (min * 0.000453592).toFixed(1) + '~' + (max * 0.000453592).toFixed(1) + ' ton';
                else
                    el.textContent = isImperial ? '- lb' : '- ton';
            } else {
                const val = parseFloat(lb[0]);
                if (!isNaN(val))
                    el.textContent = isImperial ? val.toLocaleString(undefined, {maximumFractionDigits: 1}) + ' lb' : (val * 0.000453592).toFixed(1) + ' ton';
                else
                    el.textContent = isImperial ? '- lb' : '- ton';
            }
        });
    }
    convertUnits();
    siBtn.addEventListener('click', convertUnits);
    imperialBtn.addEventListener('click', convertUnits);
    // Set initial unit state
    if ('{{ $unit }}' === 'imperial') {
        imperialBtn.classList.add('active');
        siBtn.classList.remove('active');
    } else {
        siBtn.classList.add('active');
        imperialBtn.classList.remove('active');
    }
    convertUnits();
    // Filter reset logic
    document.getElementById('resetFiltersBtn').addEventListener('click', function(e) {
        e.preventDefault();
        // Uncheck all filter checkboxes
        filterForm.querySelectorAll('.filter-checkbox').forEach(cb => { cb.checked = false; });
        // Optionally reset other filter fields here
        // Submit AJAX update with only the unit parameter
        const params = new URLSearchParams();
        params.append('unit', unitInput.value);
        ajaxUpdate(filterForm.action, params.toString());
    });
    // Accessibility: focus first product card after AJAX
    function focusFirstCard() {
        const firstCard = productsGrid.querySelector('.product-card');
        if (firstCard) {
            firstCard.setAttribute('tabindex', '-1');
            firstCard.focus({preventScroll:true});
        }
    }
    // Similar products carousel scroll logic
    const similarCarousel = document.getElementById('similarProductsCarousel');
    const rightArrow = document.getElementById('carouselRightArrow');
    if (similarCarousel && rightArrow) {
        rightArrow.addEventListener('click', function() {
            similarCarousel.scrollBy({ left: 320, behavior: 'smooth' });
        });
    }
    // Scroll to top button
    let scrollTopBtn = null;
    function createScrollTopBtn() {
        if (!scrollTopBtn) {
            scrollTopBtn = document.createElement('button');
            scrollTopBtn.id = 'scrollTopBtn';
            scrollTopBtn.className = 'btn position-fixed d-flex align-items-center justify-content-center shadow';
            scrollTopBtn.style = 'bottom: 32px; right: 32px; z-index: 1050; border-radius: 50%; width: 56px; height: 56px; font-size: 1.7rem; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: #fff; box-shadow: 0 8px 32px rgba(67,233,123,0.18); transition: box-shadow 0.2s, background 0.2s; border: none;';
            scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            scrollTopBtn.title = 'Back to top';
            scrollTopBtn.setAttribute('aria-label', 'Back to top');
            scrollTopBtn.addEventListener('mouseenter', function() {
                scrollTopBtn.style.background = 'linear-gradient(135deg, #38f9d7 0%, #43e97b 100%)';
                scrollTopBtn.style.boxShadow = '0 12px 40px rgba(67,233,123,0.28)';
            });
            scrollTopBtn.addEventListener('mouseleave', function() {
                scrollTopBtn.style.background = 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)';
                scrollTopBtn.style.boxShadow = '0 8px 32px rgba(67,233,123,0.18)';
            });
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            document.body.appendChild(scrollTopBtn);
        }
        scrollTopBtn.style.display = 'flex';
    }
    function removeScrollTopBtn() {
        if (scrollTopBtn) 
            scrollTopBtn.style.display = 'none';
    }
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            createScrollTopBtn();
        } else {
            removeScrollTopBtn();
        }
    });
    // Card hover effect
    document.querySelectorAll('.product-card').forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            card.style.boxShadow = '0 8px 32px rgba(0,0,0,0.12)';
            card.style.transform = 'translateY(-4px) scale(1.025)';
        });
        card.addEventListener('mouseleave', function() {
            card.style.boxShadow = '';
            card.style.transform = '';
        });
    });
});
</script>
@endpush
@endsection
