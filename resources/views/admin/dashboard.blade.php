@extends('layouts.admin')

@section('title', __('dashboard.title'))
@section('page-title', __('dashboard.dashboard'))

@push('styles')
<style>
    .dashboard-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    }
    
    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }
    
    .stats-card {
        position: relative;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        z-index: 1;
    }
    
    .stats-card > * {
        position: relative;
        z-index: 2;
    }
    
    .stats-card.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card.success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }
    
    .stats-card.warning {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    }
    
    .stats-card.danger {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    }
    
    .stats-card.info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    }
    
    .chart-container {
        position: relative;
        height: 250px;
        padding: 15px;
    }
    
    .chart-container.small {
        height: 180px;
    }
    
    .metric-card {
        background: white;
        border-radius: 8px;
        padding: 0.75rem;
        text-align: center;
        box-shadow: 0 1px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
    }
    
    .growth-indicator {
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .growth-indicator.positive {
        color: #48bb78;
    }
    
    .growth-indicator.negative {
        color: #f56565;
    }
    
    .activity-feed {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .activity-item {
        border-left: 3px solid #e2e8f0;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.25rem;
        background: white;
        border-radius: 0 6px 6px 0;
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        border-left-color: #667eea;
        background: #f7fafc;
    }
    
    .real-time-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #48bb78;
        border-radius: 50%;
        animation: pulse 2s infinite;
        margin-right: 4px;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(72, 187, 120, 0); }
        100% { box-shadow: 0 0 0 0 rgba(72, 187, 120, 0); }
    }
</style>
@endpush

@section('content')
<!-- Real-time Status Bar -->
<div class="alert alert-info border-0 rounded-3 mb-3" style="background: linear-gradient(90deg, #e3f2fd 0%, #f3e5f5 100%);">
    <div class="d-flex align-items-center">
        <span class="real-time-indicator"></span>
        <strong>{{ __('dashboard.live_dashboard') }}</strong>
        <span class="ms-2 text-muted">{{ __('dashboard.last_updated') }}: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span></span>
        <div class="ms-auto">
            <button class="btn btn-sm btn-outline-primary" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt me-1"></i> {{ __('dashboard.refresh') }}
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-3">
    @if(auth()->user()->isAdmin())
        <!-- Admin Stats -->
        <div class="col-lg-3 col-md-6">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['total_users'] }}">{{ number_format($stats['total_users']) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.total_staff') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
                @if(isset($analytics['growth_metrics']))
                <div class="growth-indicator {{ $analytics['growth_metrics']['sales_growth'] >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $analytics['growth_metrics']['sales_growth'] >= 0 ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                    {{ number_format(abs($analytics['growth_metrics']['sales_growth']), 1) }}% {{ __('dashboard.from_last_month') }}
                </div>
                @endif
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['total_products'] }}">{{ number_format($stats['total_products']) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.total_products') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-box fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-eye me-1"></i>
                    {{ number_format($stats['active_products']) }} {{ __('dashboard.active_products') }}
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['total_sold_products'] }}">{{ number_format($stats['total_sold_products']) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.total_sales') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-dollar-sign me-1"></i>
                    ${{ number_format($stats['total_revenue'] ?? 0, 2) }}
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['unread_messages'] }}">{{ number_format($stats['unread_messages']) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.unread_messages') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-clock me-1"></i>
                    {{ __('dashboard.needs_attention') }}
                </div>
            </div>
        </div>
    @else
        <!-- Employee Stats -->
        <div class="col-lg-3 col-md-6">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['my_today_sales'] ?? 0 }}">{{ number_format($stats['my_today_sales'] ?? 0) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.my_sales_today') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-calendar-day fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-user me-1"></i>
                    {{ __('dashboard.your_performance') }}
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['my_this_month_sales'] ?? 0 }}">{{ number_format($stats['my_this_month_sales'] ?? 0) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.monthly_sales') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-calendar me-1"></i>
                    {{ __('dashboard.this_month') }}
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['my_total_sales'] ?? 0 }}">{{ number_format($stats['my_total_sales'] ?? 0) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.total_sales') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-trophy fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-star me-1"></i>
                    {{ __('dashboard.career_total') }}
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <h4 class="mb-0" data-counter="{{ $stats['my_total_revenue'] ?? 0 }}">{{ number_format($stats['my_total_revenue'] ?? 0) }}</h4>
                        <p class="mb-0 opacity-75 small">{{ __('dashboard.my_revenue') }}</p>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-dollar-sign fa-lg"></i>
                    </div>
                </div>
                <div class="opacity-75 small">
                    <i class="fas fa-coins me-1"></i>
                    {{ __('dashboard.total_earned') }}
                </div>
            </div>
        </div>
    @endif
</div>

@if(auth()->user()->isAdmin())
    <!-- Advanced Analytics Charts -->
    <div class="row g-3 mb-3">
        <!-- Sales Overview Chart -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            {{ __('dashboard.sales_revenue_overview') }}
                        </h5>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="salesPeriod" id="daily" checked>
                            <label class="btn btn-outline-primary btn-sm" for="daily">{{ __('dashboard.daily') }}</label>
                            
                            <input type="radio" class="btn-check" name="salesPeriod" id="weekly">
                            <label class="btn btn-outline-primary btn-sm" for="weekly">{{ __('dashboard.weekly') }}</label>
                            
                            <input type="radio" class="btn-check" name="salesPeriod" id="monthly">
                            <label class="btn btn-outline-primary btn-sm" for="monthly">{{ __('dashboard.monthly') }}</label>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="salesOverviewChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Revenue Metrics -->
        <div class="col-lg-4">
            <div class="dashboard-card h-100">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-dollar-sign me-2 text-success"></i>
                        {{ __('dashboard.revenue_metrics') }}
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="metric-card mb-2">
                        <h4 class="text-success mb-1" data-counter="{{ $realtime['today_revenue'] ?? 0 }}">
                            ${{ number_format($realtime['today_revenue'] ?? 0, 2) }}
                        </h4>
                        <p class="text-muted mb-0 small">{{ __('dashboard.todays_revenue') }}</p>
                    </div>
                    
                    <div class="metric-card mb-2">
                        <h4 class="text-primary mb-1">
                            ${{ number_format($stats['avg_sale_price'] ?? 0, 2) }}
                        </h4>
                        <p class="text-muted mb-0 small">{{ __('dashboard.average_sale_price') }}</p>
                    </div>
                    
                    @if(isset($analytics['growth_metrics']))
                    <div class="metric-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 {{ $analytics['growth_metrics']['revenue_growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($analytics['growth_metrics']['revenue_growth'], 1) }}%
                                </h4>
                                <p class="text-muted mb-0 small">{{ __('dashboard.revenue_growth') }}</p>
                            </div>
                            <div class="text-{{ $analytics['growth_metrics']['revenue_growth'] >= 0 ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $analytics['growth_metrics']['revenue_growth'] >= 0 ? 'arrow-up' : 'arrow-down' }} fa-lg"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Performance Analytics -->
    <div class="row g-3 mb-3">
        <!-- Product Performance -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy me-2 text-warning"></i>
                        {{ __('dashboard.top_performing_products') }}
                    </h5>
                </div>
                <div class="chart-container small">
                    <canvas id="productPerformanceChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Team Performance -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2 text-info"></i>
                        {{ __('dashboard.team_performance') }}
                    </h5>
                </div>
                <div class="chart-container small">
                    <canvas id="teamPerformanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Geographic & Category Analytics -->
    <div class="row g-3 mb-3">
        <!-- Sales by Region -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-globe me-2 text-primary"></i>
                        {{ __('dashboard.sales_by_region') }}
                    </h5>
                </div>
                <div class="chart-container small">
                    <canvas id="regionChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Product Categories -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-tags me-2 text-success"></i>
                        {{ __('dashboard.product_categories') }}
                    </h5>
                </div>
                <div class="chart-container small">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Monitoring -->
    <div class="row g-3 mb-3">
        <!-- Recent Activity Feed -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-stream me-2 text-primary"></i>
                            {{ __('dashboard.real_time_activity_feed') }}
                        </h5>
                        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>
                            {{ __('dashboard.view_all_logs') }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="activity-feed" id="activityFeed">
                        @if(isset($analytics['recent_activity']) && $analytics['recent_activity']->count() > 0)
                            @foreach($analytics['recent_activity'] as $activity)
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2 small">{{ $activity->user->name ?? __('dashboard.system') }}</strong>
                                                <span class="badge bg-{{ $activity->event === 'created' ? 'success' : ($activity->event === 'updated' ? 'warning' : 'danger') }} me-2 small">
                                                    {{ ucfirst($activity->event) }}
                                                </span>
                                                <span class="text-muted small">{{ class_basename($activity->auditable_type) }}</span>
                                            </div>
                                            <p class="mb-1 text-muted small">{{ $activity->description ?? $activity->event . ' ' . class_basename($activity->auditable_type) }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $activity->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-{{ $activity->event === 'created' ? 'plus' : ($activity->event === 'updated' ? 'edit' : 'trash') }}"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-stream fa-2x mb-2 opacity-25"></i>
                                <p class="small">{{ __('dashboard.no_recent_activity') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- System Health & Quick Stats -->
        <div class="col-lg-4">
            <div class="dashboard-card h-100">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat me-2 text-danger"></i>
                        {{ __('dashboard.system_health') }}
                    </h5>
                </div>
                <div class="card-body p-3">
                    @if(isset($realtime['system_health']))
                    <div class="metric-card mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="text-primary mb-0">{{ $realtime['system_health']['database_size'] }} MB</h4>
                                <p class="text-muted mb-0 small">{{ __('dashboard.database_size') }}</p>
                            </div>
                            <i class="fas fa-database text-primary fa-lg"></i>
                        </div>
                    </div>
                    
                    <div class="metric-card mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="text-success mb-0">{{ number_format($realtime['system_health']['total_records']) }}</h4>
                                <p class="text-muted mb-0 small">{{ __('dashboard.total_records') }}</p>
                            </div>
                            <i class="fas fa-table text-success fa-lg"></i>
                        </div>
                    </div>
                    
                    <div class="metric-card mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="text-warning mb-0">{{ number_format($realtime['system_health']['audit_logs_count']) }}</h4>
                                <p class="text-muted mb-0 small">{{ __('dashboard.audit_logs') }}</p>
                            </div>
                            <i class="fas fa-file-alt text-warning fa-lg"></i>
                        </div>
                    </div>
                    
                    <div class="metric-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="text-info mb-0">{{ $realtime['system_health']['system_uptime'] }}</h4>
                                <p class="text-muted mb-0 small">{{ __('dashboard.system_uptime') }}</p>
                            </div>
                            <i class="fas fa-server text-info fa-lg"></i>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
@else
    <!-- Employee Dashboard -->
    <div class="row g-3 mb-3">
        <!-- My Performance Chart -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area me-2 text-primary"></i>
                        {{ __('dashboard.my_sales_performance') }}
                    </h5>
                </div>
                <div class="chart-container">
                    <canvas id="myPerformanceChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="dashboard-card h-100">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        {{ __('dashboard.quick_actions') }}
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.sold-products.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>{{ __('dashboard.create_new_sale') }}
                        </a>
                        <a href="{{ route('admin.owners.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-user-plus me-2"></i>{{ __('dashboard.add_new_owner') }}
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-box me-2"></i>{{ __('dashboard.view_products') }}
                        </a>
                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-envelope me-2"></i>{{ __('dashboard.view_messages') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- My Recent Activity -->
    <div class="row g-3">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        {{ __('dashboard.my_recent_activity') }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-feed">
                        @if(isset($analytics['recent_activity']) && $analytics['recent_activity']->count() > 0)
                            @foreach($analytics['recent_activity'] as $activity)
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge bg-{{ $activity->event === 'created' ? 'success' : ($activity->event === 'updated' ? 'warning' : 'danger') }} me-2 small">
                                                    {{ ucfirst($activity->event) }}
                                                </span>
                                                <span class="text-muted small">{{ class_basename($activity->auditable_type) }}</span>
                                            </div>
                                            <p class="mb-1 text-muted small">{{ $activity->description ?? $activity->event . ' ' . class_basename($activity->auditable_type) }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $activity->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-history fa-2x mb-2 opacity-25"></i>
                                <p class="small">{{ __('dashboard.no_recent_activity') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
// Translation variables
const dashboardTranslations = {
    salesCount: @json(__('dashboard.sales_count')),
    revenueAmount: @json(__('dashboard.revenue_amount')),
    salesCountAxis: @json(__('dashboard.sales_count_axis')),
    revenueAxis: @json(__('dashboard.revenue_axis'))
};

// Global Chart.js configuration
Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
Chart.defaults.color = '#64748b';
Chart.defaults.borderColor = '#e2e8f0';
Chart.defaults.backgroundColor = 'rgba(255, 255, 255, 0.8)';

// Color schemes
const colors = {
    primary: '#667eea',
    success: '#48bb78',
    warning: '#ed8936',
    danger: '#f56565',
    info: '#4299e1',
    gradients: {
        primary: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        success: 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)',
        warning: 'linear-gradient(135deg, #ed8936 0%, #dd6b20 100%)',
        danger: 'linear-gradient(135deg, #f56565 0%, #e53e3e 100%)',
        info: 'linear-gradient(135deg, #4299e1 0%, #3182ce 100%)'
    }
};

// Utility function to create gradient
function createGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

@if(auth()->user()->isAdmin())
// Admin Dashboard Charts
document.addEventListener('DOMContentLoaded', function() {
    // Sales Overview Chart
    const salesCtx = document.getElementById('salesOverviewChart');
    if (salesCtx) {
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json(collect($analytics['daily_sales'] ?? [])->pluck('date')),
                datasets: [{
                    label: dashboardTranslations.salesCount,
                    data: @json(collect($analytics['daily_sales'] ?? [])->pluck('sales')),
                    borderColor: colors.primary,
                    backgroundColor: createGradient(salesCtx.getContext('2d'), 'rgba(102, 126, 234, 0.2)', 'rgba(102, 126, 234, 0.02)'),
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }, {
                    label: dashboardTranslations.revenueAmount,
                    data: @json(collect($analytics['daily_sales'] ?? [])->pluck('revenue')),
                    borderColor: colors.success,
                    backgroundColor: createGradient(salesCtx.getContext('2d'), 'rgba(72, 187, 120, 0.2)', 'rgba(72, 187, 120, 0.02)'),
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: colors.success,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: colors.primary,
                        borderWidth: 1,
                        cornerRadius: 6,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 1) {
                                    return 'Revenue: $' + context.parsed.y.toLocaleString();
                                }
                                return 'Sales: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 8,
                            font: { size: 11 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        title: {
                            display: true,
                            text: 'Sales Count',
                            font: { size: 12 }
                        },
                        ticks: { font: { size: 11 } }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        },
                        title: {
                            display: true,
                            text: 'Revenue ($)',
                            font: { size: 12 }
                        },
                        ticks: {
                            font: { size: 11 },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                },
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Product Performance Chart
    const productCtx = document.getElementById('productPerformanceChart');
    if (productCtx) {
        const productChart = new Chart(productCtx, {
            type: 'doughnut',
            data: {
                labels: @json(collect($analytics['product_performance'] ?? [])->pluck('model_name')),
                datasets: [{
                    data: @json(collect($analytics['product_performance'] ?? [])->pluck('sales_count')),
                    backgroundColor: [
                        colors.primary,
                        colors.success,
                        colors.warning,
                        colors.danger,
                        colors.info,
                        '#9f7aea',
                        '#38b2ac',
                        '#ed64a6',
                        '#4fd1c7',
                        '#fc8181'
                    ],
                    borderWidth: 0,
                    hoverBorderWidth: 2,
                    hoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 11 },
                            usePointStyle: true,
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        return {
                                            text: `${label}: ${value}`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} sales (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 800
                }
            }
        });
    }

    // Team Performance Chart
    const teamCtx = document.getElementById('teamPerformanceChart');
    if (teamCtx) {
        const teamChart = new Chart(teamCtx, {
            type: 'bar',
            data: {
                labels: @json(collect($analytics['user_activity'] ?? [])->pluck('name')),
                datasets: [{
                    label: 'Sales Count',
                    data: @json(collect($analytics['user_activity'] ?? [])->pluck('sales_count')),
                    backgroundColor: colors.primary,
                    borderColor: colors.primary,
                    borderWidth: 0,
                    borderRadius: 6,
                    borderSkipped: false,
                }, {
                    label: 'Revenue ($)',
                    data: @json(collect($analytics['user_activity'] ?? [])->pluck('total_revenue')),
                    backgroundColor: colors.success,
                    borderColor: colors.success,
                    borderWidth: 0,
                    borderRadius: 6,
                    borderSkipped: false,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 1) {
                                    return 'Revenue: $' + context.parsed.y.toLocaleString();
                                }
                                return 'Sales: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: { font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        title: {
                            display: true,
                            text: 'Sales Count',
                            font: { size: 12 }
                        },
                        ticks: { font: { size: 11 } }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        },
                        title: {
                            display: true,
                            text: 'Revenue ($)',
                            font: { size: 12 }
                        },
                        ticks: {
                            font: { size: 11 },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                },
                animation: {
                    duration: 800
                }
            }
        });
    }

    // Region Chart
    const regionCtx = document.getElementById('regionChart');
    if (regionCtx) {
        const regionChart = new Chart(regionCtx, {
            type: 'polarArea',
            data: {
                labels: @json(collect($analytics['sales_by_region'] ?? [])->pluck('country')),
                datasets: [{
                    data: @json(collect($analytics['sales_by_region'] ?? [])->pluck('sales_count')),
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.7)',
                        'rgba(72, 187, 120, 0.7)',
                        'rgba(237, 137, 54, 0.7)',
                        'rgba(245, 101, 101, 0.7)',
                        'rgba(66, 153, 225, 0.7)',
                        'rgba(159, 122, 234, 0.7)',
                        'rgba(56, 178, 172, 0.7)',
                        'rgba(237, 100, 166, 0.7)'
                    ],
                    borderColor: [
                        colors.primary,
                        colors.success,
                        colors.warning,
                        colors.danger,
                        colors.info,
                        '#9f7aea',
                        '#38b2ac',
                        '#ed64a6'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 11 }
                        }
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const categoryChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: @json(collect($analytics['product_categories'] ?? [])->pluck('name')),
                datasets: [{
                    label: 'Sales Count',
                    data: @json(collect($analytics['product_categories'] ?? [])->pluck('sales_count')),
                    backgroundColor: createGradient(categoryCtx.getContext('2d'), colors.success, 'rgba(72, 187, 120, 0.3)'),
                    borderColor: colors.success,
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: { font: { size: 11 } }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }
});

@else
// Employee Dashboard Charts
document.addEventListener('DOMContentLoaded', function() {
    // My Performance Chart
    const myPerformanceCtx = document.getElementById('myPerformanceChart');
    if (myPerformanceCtx) {
        const myPerformanceChart = new Chart(myPerformanceCtx, {
            type: 'line',
            data: {
                labels: @json(collect($analytics['my_daily_sales'] ?? [])->pluck('date')),
                datasets: [{
                    label: 'My Daily Sales',
                    data: @json(collect($analytics['my_daily_sales'] ?? [])->pluck('sales')),
                    borderColor: colors.primary,
                    backgroundColor: createGradient(myPerformanceCtx.getContext('2d'), 'rgba(102, 126, 234, 0.2)', 'rgba(102, 126, 234, 0.02)'),
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: colors.primary,
                        borderWidth: 1,
                        cornerRadius: 6
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: { font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        title: {
                            display: true,
                            text: 'Sales Count',
                            font: { size: 12 }
                        },
                        ticks: { font: { size: 11 } }
                    }
                },
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }
});
@endif

// Real-time data updates
function refreshDashboard() {
    const lastUpdateEl = document.getElementById('lastUpdate');
    
    fetch('{{ route("admin.dashboard.realtime") }}')
        .then(response => response.json())
        .then(data => {
            // Update stats with animation
            document.querySelectorAll('[data-counter]').forEach(el => {
                const target = parseInt(el.getAttribute('data-counter'));
                animateNumber(el, target);
            });
            
            // Update timestamp
            if (lastUpdateEl) {
                lastUpdateEl.textContent = new Date().toLocaleTimeString();
            }
            
            // Show success notification
            showNotification('Dashboard updated successfully', 'success');
        })
        .catch(error => {
            console.error('Error updating dashboard:', error);
            showNotification('Failed to update dashboard', 'danger');
        });
}

// Number animation
function animateNumber(element, target) {
    const start = parseInt(element.textContent.replace(/,/g, '')) || 0;
    const increment = (target - start) / 20;
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= target) || (increment < 0 && current <= target)) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current).toLocaleString();
    }, 50);
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 15px; right: 15px; z-index: 9999; min-width: 250px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 4000);
}

// Auto-refresh every 5 minutes
setInterval(refreshDashboard, 300000);

// Refresh activity feed
function refreshActivityFeed() {
    fetch('{{ route("admin.dashboard.realtime") }}?type=activity')
        .then(response => response.json())
        .then(data => {
            // Update activity feed if needed
            console.log('Activity updated:', data);
        })
        .catch(error => console.error('Error updating activity:', error));
}

// Auto-refresh activity every 30 seconds
setInterval(refreshActivityFeed, 30000);
</script>
@endpush