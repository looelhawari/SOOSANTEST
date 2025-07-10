@extends('layouts.admin')

@section('title', __('reports.financial_reports'))

@push('styles')
<style>
    .report-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--report-color, #667eea) 0%, var(--report-color-secondary, #764ba2) 100%);
    }
    
    .report-card.comprehensive {
        --report-color: #667eea;
        --report-color-secondary: #764ba2;
    }
    
    .report-card.owners {
        --report-color: #48bb78;
        --report-color-secondary: #38a169;
    }
    
    .report-card.sales {
        --report-color: #ed8936;
        --report-color-secondary: #dd6b20;
    }
    
    .report-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--report-color) 0%, var(--report-color-secondary) 100%);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .date-filter-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 15px;
        border: 1px solid #e2e8f0;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .filter-option {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
        margin: 0.5rem 0;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .filter-option:hover {
        border-color: #667eea;
        background: #f7fafc;
    }
    
    .filter-option.active {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .download-btn {
        background: linear-gradient(135deg, var(--report-color) 0%, var(--report-color-secondary) 100%);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        justify-content: center;
    }
    
    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        color: white;
    }
    
    .custom-date-inputs {
        display: none;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .custom-date-inputs.active {
        display: block;
    }
    
    .stats-preview {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 1rem 0;
        border: 1px solid #e2e8f0;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--report-color);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0;
    }
    
    .feature-list li {
        padding: 0.5rem 0;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .feature-list li:before {
        content: '✓';
        color: var(--report-color);
        font-weight: bold;
        font-size: 1.1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">{{ __('reports.financial_reports') }}</h1>
                    <p class="text-muted">{{ __('reports.comprehensive_analytics_description') }}</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success fs-6">{{ __('reports.admin_only') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Filter Section -->
    <div class="date-filter-card">
        <h5 class="mb-3">{{ __('reports.select_time_period') }}</h5>
        <div class="row" id="dateFilterOptions">
            <div class="col-md-4">
                <div class="filter-option active" data-period="last_30_days">
                    <span>{{ __('reports.last_30_days') }}</span>
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="filter-option" data-period="last_90_days">
                    <span>{{ __('reports.last_90_days') }}</span>
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="filter-option" data-period="this_year">
                    <span>{{ __('reports.this_year') }}</span>
                    <i class="fas fa-calendar-year"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="filter-option" data-period="last_year">
                    <span>{{ __('reports.last_year') }}</span>
                    <i class="fas fa-history"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="filter-option" data-period="last_7_days">
                    <span>{{ __('reports.last_7_days') }}</span>
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="filter-option" data-period="custom">
                    <span>{{ __('reports.custom_range') }}</span>
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
        </div>
        
        <div class="custom-date-inputs" id="customDateInputs">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">{{ __('reports.start_date') }}</label>
                    <input type="date" class="form-control" id="startDate" value="{{ now()->subDays(30)->format('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('reports.end_date') }}</label>
                    <input type="date" class="form-control" id="endDate" value="{{ now()->format('Y-m-d') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Grid -->
    <div class="row g-4">
        <!-- Comprehensive Report -->
        <div class="col-lg-4">
            <div class="report-card comprehensive">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    
                    <h4 class="mb-3">{{ __('reports.comprehensive_report') }}</h4>
                    <p class="text-muted mb-3">{{ __('reports.comprehensive_description') }}</p>
                    
                    <ul class="feature-list">
                        <li>{{ __('reports.financial_overview') }}</li>
                        <li>{{ __('reports.sales_analytics') }}</li>
                        <li>{{ __('reports.staff_performance') }}</li>
                        <li>{{ __('reports.growth_metrics') }}</li>
                        <li>{{ __('reports.regional_analysis') }}</li>
                        <li>{{ __('reports.trend_forecasting') }}</li>
                    </ul>
                    
                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">${{ number_format($stats['comprehensive']['revenue'], 2) }}</div>
                                    <div class="stat-label">{{ __('reports.revenue_preview') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['comprehensive']['sales']) }}</div>
                                    <div class="stat-label">{{ __('reports.sales_preview') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="download-btn comprehensive-btn" onclick="downloadReport('comprehensive')">
                        <i class="fas fa-download"></i>
                        {{ __('reports.download_comprehensive') }}
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Owners Report -->
        <div class="col-lg-4">
            <div class="report-card owners">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    
                    <h4 class="mb-3">{{ __('reports.owners_report') }}</h4>
                    <p class="text-muted mb-3">{{ __('reports.owners_description') }}</p>
                    
                    <ul class="feature-list">
                        <li>{{ __('reports.customer_demographics') }}</li>
                        <li>{{ __('reports.geographic_distribution') }}</li>
                        <li>{{ __('reports.purchase_behavior') }}</li>
                        <li>{{ __('reports.customer_lifetime_value') }}</li>
                        <li>{{ __('reports.acquisition_trends') }}</li>
                        <li>{{ __('reports.top_customers') }}</li>
                    </ul>
                    
                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['owners']['total_owners']) }}</div>
                                    <div class="stat-label">{{ __('reports.total_owners') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['owners']['countries']) }}</div>
                                    <div class="stat-label">{{ __('reports.countries') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="download-btn owners-btn" onclick="downloadReport('owners')">
                        <i class="fas fa-download"></i>
                        {{ __('reports.download_owners') }}
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Sales Report -->
        <div class="col-lg-4">
            <div class="report-card sales">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    
                    <h4 class="mb-3">{{ __('reports.sales_report') }}</h4>
                    <p class="text-muted mb-3">{{ __('reports.sales_description') }}</p>
                    
                    <ul class="feature-list">
                        <li>{{ __('reports.product_performance') }}</li>
                        <li>{{ __('reports.sales_by_period') }}</li>
                        <li>{{ __('reports.staff_sales_metrics') }}</li>
                        <li>{{ __('reports.inventory_turnover') }}</li>
                        <li>{{ __('reports.profit_margins') }}</li>
                        <li>{{ __('reports.recent_transactions') }}</li>
                    </ul>
                    
                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['sales']['products_sold']) }}</div>
                                    <div class="stat-label">{{ __('reports.products_sold') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">${{ number_format($stats['sales']['avg_sale'], 2) }}</div>
                                    <div class="stat-label">{{ __('reports.avg_sale') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="download-btn sales-btn" onclick="downloadReport('sales')">
                        <i class="fas fa-download"></i>
                        {{ __('reports.download_sales') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="alert alert-info border-0 rounded-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle fa-2x me-3 text-primary"></i>
                    <div>
                        <h5 class="alert-heading">{{ __('reports.important_information') }}</h5>
                        <p class="mb-2">{{ __('reports.report_generation_info') }}</p>
                        <ul class="mb-0">
                            <li>{{ __('reports.pdf_format_info') }}</li>
                            <li>{{ __('reports.charts_included_info') }}</li>
                            <li>{{ __('reports.executive_summary_info') }}</li>
                            <li>{{ __('reports.confidential_data_info') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center py-5">
                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">{{ __('reports.generating') }}</span>
                </div>
                <h5>{{ __('reports.generating_report') }}</h5>
                <p class="text-muted mb-0">{{ __('reports.please_wait_message') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date filter functionality
    const filterOptions = document.querySelectorAll('.filter-option');
    const customDateInputs = document.getElementById('customDateInputs');
    let selectedPeriod = 'last_30_days';

    filterOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            filterOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Get selected period
            selectedPeriod = this.dataset.period;
            
            // Show/hide custom date inputs
            if (selectedPeriod === 'custom') {
                customDateInputs.classList.add('active');
            } else {
                customDateInputs.classList.remove('active');
            }
        });
    });
});

function downloadReport(reportType) {
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();
    
    // Get selected period
    const selectedPeriod = document.querySelector('.filter-option.active').dataset.period;
    
    // Build URL with parameters
    let url = `/admin/reports/${reportType}?period=${selectedPeriod}`;
    
    // Add custom dates if selected
    if (selectedPeriod === 'custom') {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        url += `&start_date=${startDate}&end_date=${endDate}`;
    }
    
    // Create a temporary link to trigger download
    const link = document.createElement('a');
    link.href = url;
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Hide loading modal after a delay
    setTimeout(() => {
        loadingModal.hide();
    }, 2000);
}

// Update preview stats based on period (optional enhancement)
function updatePreviewStats() {
    // This function could make an AJAX call to get real preview data
    // For now, it's using random numbers as shown in the template
}
</script>
@endpush
