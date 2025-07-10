@extends('layouts.admin')

@section('title', __('users.view_user'))
@section('page-title', __('users.view_user'))

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
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: #F0F0F0;
        margin-bottom: 0.5rem;
    }
    .modern-page-header p {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        color: #F0F0F0;
        opacity: 0.9;
        margin-bottom: 0;
    }
    .dark-mode .modern-page-header {
        background: #005B99;
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

    /* Buttons */
    .modern-btn {
        background: #0077C8;
        border: none;
        color: #F0F0F0;
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .modern-btn:hover {
        background: #C1D82F;
        color: #333333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(193, 216, 47, 0.3);
    }
    .modern-btn-secondary {
        background: #6C757D;
        color: #F0F0F0;
        border: 1px solid #E9ECEF;
    }
    .modern-btn-secondary:hover {
        background: #C1D82F;
        color: #333333;
        box-shadow: 0 4px 12px rgba(193, 216, 47, 0.3);
    }
    .modern-btn-warning {
        background: #C1D82F;
        color: #333333;
        border: none;
    }
    .modern-btn-warning:hover {
        background: #A3BFFA;
        color: #333333;
        box-shadow: 0 4px 12px rgba(163, 191, 250, 0.3);
    }
    .dark-mode .modern-btn-secondary {
        background: #4A4A4A;
        border-color: #4A4A4A;
    }

    /* User Avatar */
    .user-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #0077C8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F0F0F0;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 6px 16px rgba(0, 119, 200, 0.3);
    }
    .dark-mode .user-avatar-large {
        background: #005B99;
    }

    /* Info Section */
    .info-section {
        padding: 1.5rem;
        background: #F9F9F9;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    .dark-mode .info-section {
        background: #2D2D2D;
        border: 1px solid #4A4A4A;
    }
    .info-section h4 {
        font-family: 'Poppins', sans-serif;
        color: #0077C8;
        margin-bottom: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .dark-mode .info-section h4 {
        color: #F0F0F0;
    }

    /* Info Table */
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table tr {
        border-bottom: 1px solid #E9ECEF;
    }
    .info-table tr:last-child {
        border-bottom: none;
    }
    .info-table td {
        padding: 0.75rem 0;
        vertical-align: top;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    .info-table td:first-child {
        font-weight: 600;
        color: #333333;
        width: 35%;
    }
    .info-table td:last-child {
        color: #333333;
    }
    .dark-mode .info-table td:first-child,
    .dark-mode .info-table td:last-child {
        color: #F0F0F0;
    }
    .dark-mode .info-table tr {
        border-bottom: 1px solid #4A4A4A;
    }

    /* Badges */
    .modern-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 25px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .modern-badge.success {
        background: #2F855A;
        color: #F0F0F0;
    }
    .modern-badge.warning {
        background: #C1D82F;
        color: #333333;
    }
    .modern-badge.danger {
        background: #E53935;
        color: #F0F0F0;
    }
    .modern-badge.primary {
        background: #0077C8;
        color: #F0F0F0;
    }
    .modern-badge.secondary {
        background: #6C757D;
        color: #F0F0F0;
    }
    .dark-mode .modern-badge {
        opacity: 0.9;
    }

    /* Status Card */
    .status-card {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #E9ECEF;
    }
    .dark-mode .status-card {
        background: #2D2D2D;
        border-color: #4A4A4A;
        color: #F0F0F0;
    }
    .status-card h5 {
        font-family: 'Poppins', sans-serif;
        color: #333333;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .dark-mode .status-card h5 {
        color: #F0F0F0;
    }
    .status-card .status-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.25rem;
        color: #F0F0F0;
    }
    .status-active .status-icon {
        background: #2F855A;
    }
    .status-inactive .status-icon {
        background: #6C757D;
    }
    .status-admin .status-icon {
        background: #E53935;
    }
    .status-employee .status-icon {
        background: #0077C8;
    }
    .dark-mode .status-active .status-icon {
        background: #276749;
    }
    .dark-mode .status-inactive .status-icon {
        background: #4A4A4A;
    }
    .dark-mode .status-admin .status-icon {
        background: #B91C1C;
    }
    .dark-mode .status-employee .status-icon {
        background: #005B99;
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
        .user-avatar-large {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }
        .info-section {
            padding: 1rem;
        }
        .info-table td {
            font-size: 0.85rem;
        }
        .status-card {
            padding: 1rem;
        }
        .status-card .status-icon {
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
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>{{ __('users.view_user') }}</h1>
                <p>{{ __('users.view_user_description') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.users.edit', $user) }}" class="modern-btn modern-btn-warning me-2">
                    <i class="fas fa-edit"></i>
                    {{ __('users.edit') }}
                </a>
                <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('users.back_to_users') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- User Profile Card -->
    <div class="col-lg-4">
        <div class="modern-card">
            <div class="card-body text-center p-4">
                @php $userImg = $user->image_url ?? null; @endphp
                @if($userImg)
                    <img src="{{ asset($userImg) }}" alt="{{ $user->name }}" class="user-avatar-large rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="user-avatar-large bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                <div class="row g-3">
                    <div class="col-6">
                        <div class="status-card status-{{ $user->is_verified ? 'active' : 'inactive' }}">
                            <div class="status-icon">
                                <i class="fas fa-{{ $user->is_verified ? 'check-circle' : 'times-circle' }}"></i>
                            </div>
                            <h5>{{ __('users.status') }}</h5>
                            <span class="modern-badge {{ $user->is_verified ? 'success' : 'secondary' }}">
                                {{ $user->is_verified ? __('users.active') : __('users.inactive') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="status-card status-{{ $user->role }}">
                            <div class="status-icon">
                                <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : 'user' }}"></i>
                            </div>
                            <h5>{{ __('users.role') }}</h5>
                            <span class="modern-badge {{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                {{ __('users.' . $user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details -->
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="card-body p-0">
                <!-- Account Information -->
                <div class="info-section">
                    <h4>
                        <i class="fas fa-user-circle text-primary"></i>
                        {{ __('users.account_information') }}
                    </h4>
                    <table class="info-table">
                        <tr>
                            <td>{{ __('users.name') }}:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('users.email') }}:</td>
                            <td>
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="modern-badge success ms-2">
                                        <i class="fas fa-check"></i> {{ __('users.verified') }}
                                    </span>
                                @else
                                    <span class="modern-badge warning ms-2">
                                        <i class="fas fa-exclamation-triangle"></i> {{ __('users.unverified') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('users.role') }}:</td>
                            <td>
                                <span class="modern-badge {{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                    <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : 'user' }}"></i>
                                    {{ __('users.' . $user->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('users.account_status') }}:</td>
                            <td>
                                @if($user->is_verified)
                                    <span class="modern-badge success">
                                        <i class="fas fa-check-circle"></i> {{ __('users.active') }}
                                    </span>
                                @else
                                    <span class="modern-badge secondary">
                                        <i class="fas fa-times-circle"></i> {{ __('users.inactive') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Account Timeline -->
                <div class="info-section">
                    <h4>
                        <i class="fas fa-clock text-info"></i>
                        {{ __('users.account_timeline') }}
                    </h4>
                    <table class="info-table">
                        <tr>
                            <td>{{ __('users.created_at') }}:</td>
                            <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('users.updated_at') }}:</td>
                            <td>{{ $user->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        @if($user->email_verified_at)
                        <tr>
                            <td>{{ __('users.email_verified_at') }}:</td>
                            <td>{{ $user->email_verified_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        @endif
                        @if($user->created_by)
                        <tr>
                            <td>{{ __('users.created_by') }}:</td>
                            <td>{{ $user->createdBy->name ?? __('users.system') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Activity Summary -->
                <div class="info-section">
                    <h4>
                        <i class="fas fa-chart-line text-success"></i>
                        {{ __('users.activity_summary') }}
                    </h4>
                    <table class="info-table">
                        <tr>
                            <td>{{ __('users.last_login') }}:</td>
                            <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : __('users.never') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('users.login_count') }}:</td>
                            <td>{{ $user->login_count ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('users.last_ip') }}:</td>
                            <td>{{ $user->last_ip ?? __('users.na') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('users.registration_date') }}:</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection