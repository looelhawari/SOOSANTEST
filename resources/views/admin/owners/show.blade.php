@extends('layouts.admin')

@section('title', __('owners.show.title'))

@section('content')
<style>
/* Reset and prevent inheritance from global styles */
.owners-show-container * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.owners-show-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem;
    color: #1f2937;
    line-height: 1.6;
}

/* Modern Header */
.owners-show-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin: -2rem -2rem 2rem -2rem;
    border-radius: 0 0 1.5rem 1.5rem;
    position: relative;
    overflow: hidden;
}

.owners-show-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.owners-show-header-content {
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

.owners-show-title-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.owners-show-title-section p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.owners-action-buttons {
    display: flex;
    gap: 1rem;
}

.owners-btn {
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

.owners-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    color: white;
    border-color: rgba(255, 255, 255, 0.5);
}

.owners-btn.primary {
    background: rgba(255, 255, 255, 0.9);
    color: #667eea;
    border-color: rgba(255, 255, 255, 0.9);
}

.owners-btn.primary:hover {
    background: white;
    color: #667eea;
    border-color: white;
}

/* Content Grid */
.owners-content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    margin-bottom: 2rem;
}

/* Main Info Card */
.owners-info-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.owners-info-header {
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.owners-info-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.owners-info-header i {
    color: #667eea;
    font-size: 1.25rem;
}

.owners-info-body {
    padding: 2rem;
}

.owners-detail-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.owners-detail-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.owners-detail-section h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.owners-detail-section i {
    color: #667eea;
}

.owners-detail-grid {
    display: grid;
    gap: 1rem;
}

.owners-detail-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.owners-detail-item i {
    color: #667eea;
    width: 20px;
    flex-shrink: 0;
}

.owners-detail-content {
    flex: 1;
}

.owners-detail-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.owners-detail-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    word-break: break-word;
}

.owners-detail-value a {
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.owners-detail-value a:hover {
    color: #4f46e5;
    text-decoration: underline;
}

/* Avatar Card */
.owners-avatar-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
    height: fit-content;
}

.owners-avatar-section {
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding: 3rem 2rem;
    text-align: center;
    color: white;
}

.owners-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    margin: 0 auto 1rem;
    backdrop-filter: blur(10px);
    border: 4px solid rgba(255, 255, 255, 0.3);
}

.owners-avatar-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.owners-avatar-company {
    font-size: 1rem;
    opacity: 0.8;
    margin: 0;
}

.owners-meta-info {
    padding: 2rem;
}

.owners-meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.owners-meta-item:last-child {
    border-bottom: none;
}

.owners-meta-item i {
    color: #667eea;
    width: 20px;
    flex-shrink: 0;
}

.owners-meta-content {
    flex: 1;
}

.owners-meta-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.owners-meta-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
}

/* No Data State */
.owners-no-data {
    color: #6b7280;
    font-style: italic;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.owners-no-data i {
    color: #9ca3af;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .owners-content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .owners-show-container {
        padding: 1rem;
    }
    
    .owners-show-header {
        margin: -1rem -1rem 2rem -1rem;
        padding: 2rem 0;
    }
    
    .owners-show-header-content {
        flex-direction: column;
        text-align: center;
        padding: 0 1rem;
    }
    
    .owners-show-title-section h1 {
        font-size: 2rem;
    }
    
    .owners-action-buttons {
        flex-direction: column;
        width: 100%;
    }
}
</style>

<div class="owners-show-container">
    <!-- Page Header -->
    <div class="owners-show-header">
        <div class="owners-show-header-content">
            <div class="owners-show-title-section">
                <h1><i class="fas fa-user-circle"></i> {{ __('owners.show.header.title') }}</h1>
                <p>{{ __('owners.show.header.description') }}</p>
            </div>
            <div class="owners-action-buttons">
                <a href="{{ route('admin.owners.edit', $owner) }}" class="owners-btn primary">
                    <i class="fas fa-edit"></i>
                    {{ __('owners.show.header.edit_btn') }}
                </a>
                <a href="{{ route('admin.owners.index') }}" class="owners-btn">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('owners.show.header.back_btn') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="owners-content-grid">
        <!-- Main Info Card -->
        <div class="owners-info-card">
            <div class="owners-info-header">
                <h2><i class="fas fa-info-circle"></i> {{ __('owners.show.sections.owner_info') }}</h2>
            </div>
            
            <div class="owners-info-body">
                <!-- Basic Information Section -->
                <div class="owners-detail-section">
                    <h3><i class="fas fa-user"></i> {{ __('owners.show.sections.basic_info') }}</h3>
                    <div class="owners-detail-grid">
                        <div class="owners-detail-item">
                            <i class="fas fa-user"></i>
                            <div class="owners-detail-content">
                                <div class="owners-detail-label">{{ __('owners.show.labels.full_name') }}</div>
                                <div class="owners-detail-value">{{ $owner->name }}</div>
                            </div>
                        </div>
                        
                        @if($owner->email)
                            <div class="owners-detail-item">
                                <i class="fas fa-envelope"></i>
                                <div class="owners-detail-content">
                                    <div class="owners-detail-label">{{ __('owners.show.labels.email_address') }}</div>
                                    <div class="owners-detail-value">
                                        <a href="mailto:{{ $owner->email }}">{{ $owner->email }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information Section -->
                @if($owner->phone_number || $owner->company)
                    <div class="owners-detail-section">
                        <h3><i class="fas fa-address-book"></i> {{ __('owners.show.sections.contact_info') }}</h3>
                        <div class="owners-detail-grid">
                            @if($owner->phone_number)
                                <div class="owners-detail-item">
                                    <i class="fas fa-phone"></i>
                                    <div class="owners-detail-content">
                                        <div class="owners-detail-label">{{ __('owners.show.labels.phone_number') }}</div>
                                        <div class="owners-detail-value">
                                            <a href="tel:{{ $owner->phone_number }}">{{ $owner->phone_number }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($owner->company)
                                <div class="owners-detail-item">
                                    <i class="fas fa-building"></i>
                                    <div class="owners-detail-content">
                                        <div class="owners-detail-label">{{ __('owners.show.labels.company') }}</div>
                                        <div class="owners-detail-value">{{ $owner->company }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Location Information Section -->
                @if($owner->address || $owner->city || $owner->country)
                    <div class="owners-detail-section">
                        <h3><i class="fas fa-map-marker-alt"></i> {{ __('owners.show.sections.location_info') }}</h3>
                        <div class="owners-detail-grid">
                            @if($owner->address)
                                <div class="owners-detail-item">
                                    <i class="fas fa-map"></i>
                                    <div class="owners-detail-content">
                                        <div class="owners-detail-label">{{ __('owners.show.labels.address') }}</div>
                                        <div class="owners-detail-value">{{ $owner->address }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($owner->city)
                                <div class="owners-detail-item">
                                    <i class="fas fa-city"></i>
                                    <div class="owners-detail-content">
                                        <div class="owners-detail-label">{{ __('owners.show.labels.city') }}</div>
                                        <div class="owners-detail-value">{{ $owner->city }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($owner->country)
                                <div class="owners-detail-item">
                                    <i class="fas fa-flag"></i>
                                    <div class="owners-detail-content">
                                        <div class="owners-detail-label">{{ __('owners.show.labels.country') }}</div>
                                        <div class="owners-detail-value">{{ $owner->country }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Preferences Section -->
                @if($owner->preferred_language)
                    <div class="owners-detail-section">
                        <h3><i class="fas fa-cog"></i> {{ __('owners.show.sections.preferences') }}</h3>
                        <div class="owners-detail-grid">
                            <div class="owners-detail-item">
                                <i class="fas fa-language"></i>
                                <div class="owners-detail-content">
                                    <div class="owners-detail-label">{{ __('owners.show.labels.preferred_language') }}</div>
                                    <div class="owners-detail-value">{{ strtoupper($owner->preferred_language) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Sold Products Section -->
                @if($owner->soldProducts && $owner->soldProducts->count())
                    <div class="owners-detail-section">
                        <h3><i class="fas fa-box"></i> {{ __('owners.show.sections.sold_products') }}</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('owners.show.labels.product') }}</th>
                                        <th>{{ __('owners.show.labels.serial_number') }}</th>
                                        <th>{{ __('owners.show.labels.sale_date') }}</th>
                                        <th>{{ __('owners.show.labels.warranty_status') }}</th>
                                        <th>{{ __('owners.show.labels.warranty_end') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($owner->soldProducts as $soldProduct)
                                        <tr>
                                            <td>{{ $soldProduct->product->model_name ?? '-' }}</td>
                                            <td>{{ $soldProduct->serial_number }}</td>
                                            <td>{{ $soldProduct->sale_date ? $soldProduct->sale_date->format('M d, Y') : '-' }}</td>
                                            <td>
                                                @if($soldProduct->warranty_voided)
                                                    <span class="badge bg-danger">{{ __('owners.show.labels.warranty_voided') }}</span>
                                                @elseif($soldProduct->warranty_end_date && now()->gt($soldProduct->warranty_end_date))
                                                    <span class="badge bg-secondary">{{ __('owners.show.labels.warranty_expired') }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ __('owners.show.labels.warranty_active') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('M d, Y') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Avatar Card -->
        <div class="owners-avatar-card">
            <div class="owners-avatar-section">
                <div class="owners-avatar">
                    {{ strtoupper(substr($owner->name, 0, 1)) }}
                </div>
                <div class="owners-avatar-name">{{ $owner->name }}</div>
                <div class="owners-avatar-company">{{ $owner->company ?? __('owners.show.fallbacks.individual_owner') }}</div>
            </div>
            
            <div class="owners-meta-info">
                <div class="owners-meta-item">
                    <i class="fas fa-calendar-plus"></i>
                    <div class="owners-meta-content">
                        <div class="owners-meta-label">{{ __('owners.show.labels.created_at') }}</div>
                        <div class="owners-meta-value">
                            {{ $owner->created_at ? $owner->created_at->format('M d, Y \a\t g:i A') : __('owners.show.fallbacks.na') }}
                        </div>
                    </div>
                </div>
                
                <div class="owners-meta-item">
                    <i class="fas fa-calendar-check"></i>
                    <div class="owners-meta-content">
                        <div class="owners-meta-label">{{ __('owners.show.labels.last_updated') }}</div>
                        <div class="owners-meta-value">
                            {{ $owner->updated_at ? $owner->updated_at->format('M d, Y \a\t g:i A') : __('owners.show.fallbacks.na') }}
                        </div>
                    </div>
                </div>
                
                <div class="owners-meta-item">
                    <i class="fas fa-clock"></i>
                    <div class="owners-meta-content">
                        <div class="owners-meta-label">{{ __('owners.show.labels.time_since_created') }}</div>
                        <div class="owners-meta-value">
                            {{ $owner->created_at ? $owner->created_at->diffForHumans() : __('owners.show.fallbacks.na') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to detail items
    const detailItems = document.querySelectorAll('.owners-detail-item');
    detailItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 4px 15px rgba(102, 126, 234, 0.15)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>
@endsection
