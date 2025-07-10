@extends('layouts.admin')

@section('title', __('owners.title'))

@section('content')
<style>
/* Reset and prevent inheritance from global styles */
.owners-admin-container * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.owners-admin-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem;
    color: #1f2937;
    line-height: 1.6;
}

/* Modern Header */
.owners-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin: -2rem -2rem 2rem -2rem;
    border-radius: 0 0 1.5rem 1.5rem;
    position: relative;
    overflow: hidden;
}

.owners-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.owners-header-content {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.owners-title-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.owners-title-section p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.owners-add-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 1rem 2rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.owners-add-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    color: white;
    border-color: rgba(255, 255, 255, 0.5);
}

/* Stats Grid */
.owners-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.owners-stat-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.owners-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.owners-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.owners-stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.owners-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.owners-stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.owners-stat-content p {
    color: #6b7280;
    font-size: 0.875rem;
    margin: 0;
}

/* Search and Filter Section */
.owners-controls {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.owners-controls-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.owners-controls-header i {
    color: #667eea;
    font-size: 1.25rem;
}

.owners-controls-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.owners-filter-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr auto;
    gap: 1rem;
    align-items: end;
}

.owners-form-group label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.owners-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: white;
}

.owners-form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.owners-search-btn {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.owners-search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}
/* Owners Grid */
.owners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.owners-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
    position: relative;
}

.owners-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.owners-avatar-section {
    position: relative;
    height: 120px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
}

.owners-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: transform 0.3s ease;
}

.owners-card:hover .owners-avatar {
    transform: scale(1.05);
}

.owners-content {
    padding: 1.5rem;
}

.owners-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    text-align: center;
}

.owners-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin: 1rem 0;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.owners-detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.owners-detail-item i {
    color: #667eea;
    width: 16px;
    flex-shrink: 0;
}

.owners-detail-label {
    color: #6b7280;
    font-weight: 500;
    min-width: 50px;
}

.owners-detail-value {
    font-weight: 600;
    color: #1f2937;
}

.owners-actions {
    display: flex;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
}

.owners-action-btn {
    flex: 1;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.owners-action-btn.view {
    background: rgba(6, 182, 212, 0.1);
    color: #06b6d4;
    border: 1px solid rgba(6, 182, 212, 0.3);
}

.owners-action-btn.edit {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.owners-action-btn.delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.owners-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.owners-action-btn.view:hover {
    background: #06b6d4;
    color: white;
}

.owners-action-btn.edit:hover {
    background: #f59e0b;
    color: white;
}

.owners-action-btn.delete:hover {
    background: #ef4444;
    color: white;
}

.owners-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #fafbfc;
}

.owners-created-date {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.75rem;
}

.owners-created-date i {
    color: #667eea;
}

/* Empty State */
.owners-empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
}

.owners-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.owners-empty-state h3 {
    color: #1f2937;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.owners-empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
}

/* Alert Styles */
.owners-alert {
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    border: none;
    box-shadow: 0 4px 20px rgba(40, 167, 69, 0.15);
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.owners-alert.success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    color: #047857;
    border-left: 4px solid #10b981;
}

/* Pagination Styles */
.owners-pagination-wrapper {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 1rem !important;
    margin: 2rem 0 !important;
    padding: 1.5rem !important;
    background: white !important;
    border-radius: 1rem !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid #e5e7eb !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .owners-admin-container {
        padding: 1rem;
    }
    
    .owners-header {
        margin: -1rem -1rem 2rem -1rem;
        padding: 2rem 0;
    }
    
    .owners-header-content {
        flex-direction: column;
        text-align: center;
        padding: 0 1rem;
    }
    
    .owners-title-section h1 {
        font-size: 2rem;
    }
    
    .owners-filter-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .owners-grid {
        grid-template-columns: 1fr;
    }
    
    .owners-stats {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .owners-header-content {
        padding: 0 0.5rem;
    }
    
    .owners-actions {
        flex-direction: column;
    }
    
    .owners-action-btn {
        width: 100%;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.owners-card {
    animation: fadeInUp 0.6s ease forwards;
}

.owners-card:nth-child(2) { animation-delay: 0.1s; }
.owners-card:nth-child(3) { animation-delay: 0.2s; }
.owners-card:nth-child(4) { animation-delay: 0.3s; }
.owners-card:nth-child(5) { animation-delay: 0.4s; }
.owners-card:nth-child(6) { animation-delay: 0.5s; }
</style>

<div class="owners-admin-container">
    <!-- Page Header -->
    <div class="owners-header">
        <div class="owners-header-content">
            <div class="owners-title-section">
                <h1><i class="fas fa-user-tie"></i> {{ __('owners.owners_management') }}</h1>
                <p>{{ __('owners.manage_owners') }}</p>
            </div>
            <a href="{{ route('admin.owners.create') }}" class="owners-add-btn">
                <i class="fas fa-plus"></i>
                {{ __('owners.add_owner') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="owners-alert success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(auth()->user()->isEmployee())
        <!-- Employee Notice -->
        <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; margin-bottom: 2rem; border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-info-circle" style="color: #f59e0b; font-size: 1.25rem;"></i>
                <div>
                    <h4 style="color: #92400e; margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;">{{ __('owners.employee_access') }}</h4>
                    <p style="color: #92400e; margin: 0; font-size: 0.875rem;">{{ __('owners.employee_access_desc') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="owners-stats">
        <div class="owners-stat-card">
            <div class="owners-stat-header">
                <div class="owners-stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            <div class="owners-stat-content">
                <h3>{{ $totalOwners }}</h3>
                <p>{{ __('owners.total_owners') }}</p>
            </div>
        </div>
        
        <div class="owners-stat-card">
            <div class="owners-stat-header">
                <div class="owners-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
            <div class="owners-stat-content">
                <h3>{{ $ownersWithEmail }}</h3>
                <p>{{ __('owners.with_email') }}</p>
            </div>
        </div>
        
        <div class="owners-stat-card">
            <div class="owners-stat-header">
                <div class="owners-stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-phone"></i>
                </div>
            </div>
            <div class="owners-stat-content">
                <h3>{{ $owners->whereNotNull('phone_number')->count() }}</h3>
                <p>{{ __('owners.with_phone') }}</p>
            </div>
        </div>
        
        <div class="owners-stat-card">
            <div class="owners-stat-header">
                <div class="owners-stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <div class="owners-stat-content">
                <h3>{{ $ownersWithCompany }}</h3>
                <p>{{ __('owners.with_company') }}</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="owners-controls">
        <div class="owners-controls-header">
            <i class="fas fa-search"></i>
            <h3>{{ __('owners.search_filter_owners') }}</h3>
        </div>
        
        <form method="GET" action="{{ route('admin.owners.index') }}" id="filterForm">
            <div class="owners-filter-grid">
                <div class="owners-form-group">
                    <label for="search">{{ __('owners.search_owners') }}</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           class="owners-form-control" 
                           placeholder="{{ __('owners.search_placeholder') }}"
                           value="{{ request('search') }}">
                </div>
                
                <div class="owners-form-group">
                    <label for="country_filter">{{ __('owners.country') }}</label>
                    <select id="country_filter" name="country" class="owners-form-control">
                        <option value="">{{ __('owners.all_countries') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="owners-form-group">
                    <label for="city_filter">{{ __('owners.city') }}</label>
                    <select id="city_filter" name="city" class="owners-form-control">
                        <option value="">{{ __('owners.all_cities') }}</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="owners-search-btn">
                    <i class="fas fa-search"></i> {{ __('owners.search') }}
                </button>
            </div>
        </form>
    </div>
    @if($owners->count() > 0)
        <!-- Owners Grid -->
        <div class="owners-grid">
            @foreach($owners as $owner)
                <div class="owners-card">
                    <!-- Owner Avatar -->
                    <div class="owners-avatar-section">
                        @php $userImg = $owner->image_url; @endphp
                        @if($userImg)
                            <img src="{{ asset($userImg) }}" alt="{{ $owner->name }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                        @else
                            <div class="avatar-circle bg-primary text-white">
                                {{ substr($owner->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Owner Content -->
                    <div class="owners-content">
                        <h4 class="owners-card-title">{{ $owner->name }}</h4>
                        
                        <!-- Owner Details -->
                        <div class="owners-details">
                            @if($owner->email)
                                <div class="owners-detail-item">
                                    <i class="fas fa-envelope"></i>
                                    <span class="owners-detail-value">{{ $owner->email }}</span>
                                </div>
                            @endif
                            @if($owner->phone_number)
                                <div class="owners-detail-item">
                                    <i class="fas fa-phone"></i>
                                    <span class="owners-detail-value">{{ $owner->phone_number }}</span>
                                </div>
                            @endif
                            @if($owner->company)
                                <div class="owners-detail-item">
                                    <i class="fas fa-building"></i>
                                    <span class="owners-detail-value">{{ $owner->company }}</span>
                                </div>
                            @endif
                            @if($owner->city || $owner->country)
                                <div class="owners-detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="owners-detail-value">
                                        @if($owner->city && $owner->country)
                                            {{ $owner->city }}, {{ $owner->country }}
                                        @elseif($owner->city)
                                            {{ $owner->city }}
                                        @else
                                            {{ $owner->country }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            @if($owner->preferred_language)
                                <div class="owners-detail-item">
                                    <i class="fas fa-language"></i>
                                    <span class="owners-detail-value">{{ strtoupper($owner->preferred_language) }}</span>
                                </div>
                            @endif
                            @if(!$owner->email && !$owner->phone_number && !$owner->company && !$owner->city && !$owner->country)
                                <div class="owners-detail-item">
                                    <i class="fas fa-info-circle"></i>
                                    <span class="owners-detail-value">{{ __('owners.no_contact_information') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Owner Actions -->
                    <div class="owners-actions">
                        <a href="{{ route('admin.owners.show', $owner) }}" class="owners-action-btn view">
                            <i class="fas fa-eye"></i> {{ __('owners.view') }}
                        </a>
                        <a href="{{ route('admin.owners.edit', $owner) }}" class="owners-action-btn edit">
                            <i class="fas fa-edit"></i> {{ __('owners.edit') }}
                        </a>
                        <form method="POST" action="{{ route('admin.owners.destroy', $owner) }}" 
                              style="display: inline; flex: 1;" 
                              onsubmit="return confirm('{{ __('owners.delete_cannot_undone') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="owners-action-btn delete" style="width: 100%;">
                                <i class="fas fa-trash"></i> {{ __('owners.delete') }}
                            </button>
                        </form>
                    </div>
                    
                    <!-- Owner Footer -->
                    <div class="owners-footer">
                        <div class="owners-created-date">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $owner->created_at ? $owner->created_at->format('M d, Y') : __('owners.n_a') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($owners->hasPages())
            <div class="owners-pagination-wrapper">
                {{ $owners->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="owners-empty-state">
            <div class="owners-empty-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <h3>{{ __('owners.no_owners_found') }}</h3>
            <p>{{ __('owners.start_adding_owners') }}</p>
            <a href="{{ route('admin.owners.create') }}" class="owners-add-btn">
                <i class="fas fa-plus"></i>
                {{ __('owners.add_first_owner') }}
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    const filterForm = document.getElementById('filterForm');
    const filterInputs = filterForm.querySelectorAll('select');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            filterForm.submit();
        });
    });

    // Add loading state to forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.dataset.noLoading) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('owners.processing') }}';
            }
        });
    });

    // Confirmation for delete actions
    document.querySelectorAll('form[method="POST"]').forEach(form => {
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput && methodInput.value === 'DELETE') {
            form.addEventListener('submit', function(e) {
                if (!confirm('{{ __('owners.delete_cannot_undone') }}')) {
                    e.preventDefault();
                }
            });
        }
    });

    // Auto-hide alerts
    setTimeout(() => {
        document.querySelectorAll('.owners-alert').forEach(alert => {
            if (alert.style) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);
});
</script>
@endsection
