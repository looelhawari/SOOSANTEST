@extends('layouts.admin')

@section('title', __('users.staff_management'))
@section('page-title', __('users.staff_management'))

@push('styles')
<style>
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
    .dark-mode .modern-page-header {
        background: #005B99;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #0077C8;
        color: #F0F0F0;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 6px 20px rgba(0, 119, 200, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 119, 200, 0.3);
    }
    .stat-card.success {
        background: #2F855A;
    }
    .stat-card.danger {
        background: #E53935;
    }
    .stat-card.info {
        background: #3182CE;
    }
    .dark-mode .stat-card {
        background: #2D2D2D;
    }
    .dark-mode .stat-card.success {
        background: #276749;
    }
    .dark-mode .stat-card.danger {
        background: #B91C1C;
    }
    .dark-mode .stat-card.info {
        background: #2B6CB0;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.85;
        font-weight: 500;
    }

    /* Modern Card */
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
    .dark-mode .modern-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }

    /* User Card */
    .user-card {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #E9ECEF;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        border-color: #C1D82F;
    }
    .dark-mode .user-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #0077C8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F0F0F0;
        font-weight: 600;
        font-size: 1.25rem;
        margin-right: 1rem;
        box-shadow: 0 4px 12px rgba(0, 119, 200, 0.2);
    }
    .dark-mode .user-avatar {
        background: #005B99;
    }

    /* Buttons */
    .modern-btn {
        background: #0077C8;
        border: none;
        color: #F0F0F0;
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modern-btn:hover {
        background: #C1D82F;
        color: #333333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193, 216, 47, 0.3);
    }
    .modern-btn-secondary {
        background: #F9F9F9;
        color: #333333;
        border: 1px solid #E9ECEF;
    }
    .modern-btn-secondary:hover {
        color: #0077C8;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid;
        background: transparent;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
        font-size: 0.9rem;
    }
    .action-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .action-btn.border-info {
        border-color: #3182CE;
        color: #3182CE;
    }
    .action-btn.border-info:hover {
        background: #C1D82F;
        border-color: #C1D82F;
        color: #333333;
    }
    .action-btn.border-warning {
        border-color: #C1D82F;
        color: #C1D82F;
    }
    .action-btn.border-warning:hover {
        background: #C1D82F;
        color: #333333;
    }
    .action-btn.border-success {
        border-color: #2F855A;
        color: #2F855A;
    }
    .action-btn.border-success:hover {
        background: #C1D82F;
        border-color: #C1D82F;
        color: #333333;
    }
    .action-btn.border-danger {
        border-color: #E53935;
        color: #E53935;
    }
    .action-btn.border-danger:hover {
        background: #E53935;
        border-color: #E53935;
        color: #F0F0F0;
    }
    .action-btn.border-secondary {
        border-color: #6C757D;
        color: #6C757D;
    }
    .action-btn.border-secondary:hover {
        background: #C1D82F;
        border-color: #C1D82F;
        color: #333333;
    }
    .dark-mode .action-btn {
        background: #4A4A4A;
    }

    /* Inputs and Selects */
    .modern-search, .modern-select {
        background: #FFFFFF;
        border: 2px solid #E9ECEF;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: #333333;
        transition: all 0.3s ease;
        width: 100%;
    }
    .modern-search:focus, .modern-select:focus {
        border-color: #C1D82F;
        box-shadow: 0 0 0 0.2rem rgba(193, 216, 47, 0.25);
        outline: none;
    }
    .dark-mode .modern-search, .dark-mode .modern-select {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .dark-mode .modern-search::placeholder {
        color: #A0AEC0;
    }

    /* Badges */
    .badge-modern {
        padding: 0.4rem 0.9rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-modern.bg-primary {
        background: #0077C8;
        color: #F0F0F0;
    }
    .badge-modern.bg-success {
        background: #2F855A;
        color: #F0F0F0;
    }
    .badge-modern.bg-warning {
        background: #C1D82F;
        color: #333333;
    }
    .badge-modern.bg-danger {
        background: #E53935;
        color: #F0F0F0;
    }
    .dark-mode .badge-modern {
        opacity: 0.9;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6C757D;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        opacity: 0.4;
    }
    .empty-state h4 {
        color: #E53935;
        font-weight: 700;
    }
    .dark-mode .empty-state {
        color: #A0AEC0;
    }
    .dark-mode .empty-state h4 {
        color: #E53935;
    }

    /* Pagination */
    .pagination .page-link {
        border-radius: 8px;
        margin: 0 0.2rem;
        color: #333333;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .pagination .page-link:hover {
        background: #C1D82F;
        color: #333333;
        border-color: #C1D82F;
    }
    .pagination .page-item.active .page-link {
        background: #0077C8;
        border-color: #0077C8;
        color: #F0F0F0;
    }
    .dark-mode .pagination .page-link {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .dark-mode .pagination .page-link:hover {
        background: #C1D82F;
        color: #333333;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .modern-page-header {
            padding: 1.5rem 0;
            margin: -1rem -1rem 1.5rem;
        }
        .modern-page-header h1 {
            font-size: 1.5rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .user-card {
            padding: 1rem;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="modern-page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>{{ __('users.staff_management') }}</h1>
                <p>{{ __('users.manage_staff') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.users.create') }}" class="modern-btn">
                    <i class="fas fa-plus"></i> {{ __('users.add_user') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="container-fluid">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value" data-counter="{{ $users->total() }}">{{ $users->total() }}</div>
            <div class="stat-label">{{ __('users.total_staff') }}</div>
        </div>
        <div class="stat-card success">
            <div class="stat-value" data-counter="{{ $users->where('is_verified', true)->count() }}">{{ $users->where('is_verified', true)->count() }}</div>
            <div class="stat-label">{{ __('users.verified') }} {{ __('users.staff') }}</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-value" data-counter="{{ $users->where('role', 'admin')->count() }}">{{ $users->where('role', 'admin')->count() }}</div>
            <div class="stat-label">{{ __('users.admin') }} {{ __('users.staff') }}</div>
        </div>
        <div class="stat-card info">
            <div class="stat-value" data-counter="{{ $users->where('role', 'employee')->count() }}">{{ $users->where('role', 'employee')->count() }}</div>
            <div class="stat-label">{{ __('users.employee') }} {{ __('users.staff') }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="modern-card">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">{{ __('users.search_staff') }}</label>
                        <input 
                            type="text" 
                            class="modern-search" 
                            id="search" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="{{ __('users.search_placeholder') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <label for="role" class="form-label fw-semibold">{{ __('users.role') }}</label>
                        <select class="modern-select" id="role" name="role">
                            <option value="">{{ __('users.all_roles') }}</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>{{ __('users.admin') }}</option>
                            <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>{{ __('users.employee') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="verified" class="form-label fw-semibold">{{ __('users.status') }}</label>
                        <select class="modern-select" id="verified" name="verified">
                            <option value="">{{ __('users.all_statuses') }}</option>
                            <option value="verified" {{ request('verified') === 'verified' ? 'selected' : '' }}>{{ __('users.verified') }}</option>
                            <option value="unverified" {{ request('verified') === 'unverified' ? 'selected' : '' }}>{{ __('users.unverified') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="modern-btn w-100">
                            <i class="fas fa-search"></i> {{ __('users.filter') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Grid -->
    <div class="row">
        @forelse($users as $user)
            <div class="col-lg-6 col-xl-4 mb-3">
                <div class="user-card">
                    <div class="d-flex align-items-start">
                        @php $userImg = $user->image_url ?? null; @endphp
                        @if($userImg)
                            <img src="{{ asset($userImg) }}" alt="{{ $user->name }}" class="user-avatar rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                        @else
                            <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 1.2rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="mb-1 font-weight-bold">{{ $user->name }}</h5>
                            <p class="text-muted small mb-2">{{ $user->email }}</p>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge badge-modern bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                    {{ $user->role === 'admin' ? __('users.admin') : __('users.employee') }}
                                </span>
                                <span class="badge badge-modern bg-{{ $user->is_verified ? 'success' : 'warning' }}">
                                    <i class="fas fa-{{ $user->is_verified ? 'check' : 'clock' }} me-1"></i>
                                    {{ $user->is_verified ? __('users.verified') : __('users.unverified') }}
                                </span>
                            </div>
                            <small class="text-muted d-block mb-3">
                                {{ __('users.created') }} {{ $user->created_at ? $user->created_at->diffForHumans() : __('users.na') }}
                            </small>
                            <div class="d-flex justify-content-start gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="action-btn border-info text-info" 
                                   title="{{ __('users.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="action-btn border-warning text-warning" 
                                   title="{{ __('users.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="action-btn border-{{ $user->is_verified ? 'secondary' : 'success' }} text-{{ $user->is_verified ? 'secondary' : 'success' }}" 
                                                title="{{ $user->is_verified ? __('users.unverify') : __('users.verify') }}">
                                            <i class="fas fa-{{ $user->is_verified ? 'times' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn border-danger text-danger" 
                                                title="{{ __('users.delete') }}" 
                                                onclick="return confirm('{{ __('users.confirm_delete') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="action-btn border-secondary text-secondary" 
                                          title="{{ __('users.cannot_modify_own_account') }}">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h4>{{ __('users.no_staff_found') }}</h4>
                    <p>{{ __('users.no_staff_match_filters') }}</p>
                    @if(request()->hasAny(['search', 'role', 'verified']))
                        <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-times"></i> {{ __('users.clear_filters') }}
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="modern-card">
            <div class="card-body text-center py-3">
                {{ $users->withQueryString()->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    @endif

    <!-- Summary -->
    <div class="text-center mt-3">
        <small class="text-muted">
            {{ __('users.showing') }} {{ $users->firstItem() ?? 0 }} {{ __('users.to') }} {{ $users->lastItem() ?? 0 }} {{ __('users.of') }} {{ $users->total() }} {{ __('users.staff') }}
        </small>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change with debounce
    const filterForm = document.getElementById('filterForm');
    const filterInputs = filterForm.querySelectorAll('select, input');
    
    filterInputs.forEach(input => {
        if (input.type === 'text') {
            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });
        } else {
            input.addEventListener('change', function() {
                filterForm.submit();
            });
        }
    });

    // Animate counter on stats cards
    const animateNumber = (element, target) => {
        const start = parseInt(element.textContent) || 0;
        const increment = (target - start) / 20;
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= target) || (increment < 0 && current <= target)) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 50);
    };

    document.querySelectorAll('.stat-value[data-counter]').forEach(el => {
        animateNumber(el, parseInt(el.getAttribute('data-counter')));
    });

    // Smooth hover effects for user cards
    const userCards = document.querySelectorAll('.user-card');
    userCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 3px 12px rgba(0, 0, 0, 0.06)';
        });
    });
});
</script>
@endpush
@endsection