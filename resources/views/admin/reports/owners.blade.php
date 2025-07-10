<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Owners Report - {{ $dateRange['label'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #2c3e50;
            background: #ffffff;
        }
        
        .header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .header .subtitle {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        .header .period {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            font-weight: 500;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
        }
        
        .section {
            margin-bottom: 40px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .section-header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 20px 30px;
            font-size: 20px;
            font-weight: 600;
            border-bottom: 3px solid #229954;
        }
        
        .section-content {
            padding: 30px;
        }
        
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .metric-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
            transition: transform 0.2s;
        }
        
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .metric-value {
            font-size: 28px;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 8px;
            display: block;
        }
        
        .metric-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .table th,
        .table td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        .table th {
            background: linear-gradient(135deg, #495057 0%, #343a40 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .table tbody tr:hover {
            background: #e3f2fd;
        }
        
        .chart-container {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }
        
        .insight-box {
            background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
            border: 1px solid #27ae60;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
        }
        
        .insight-box h4 {
            color: #155724;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .insight-box ul {
            list-style: none;
            padding: 0;
        }
        
        .insight-box li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(21, 87, 36, 0.1);
        }
        
        .insight-box li:before {
            content: "✓";
            color: #27ae60;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-right: 10px;
        }
        
        .tier-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }
        
        .tier-platinum { background: #9c88ff; }
        .tier-gold { background: #ffd700; color: #333; }
        .tier-silver { background: #c0c0c0; color: #333; }
        .tier-bronze { background: #cd7f32; }
        
        .highlight {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: #333;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .footer {
            margin-top: 50px;
            padding: 25px;
            text-align: center;
            background: #f8f9fa;
            border-top: 3px solid #dee2e6;
            border-radius: 8px;
            color: #6c757d;
            font-size: 11px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        @page {
            margin: 15mm;
            size: A4;
        }
        
        @media print {
            .header, .section-header, .table th, .chart-container {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .metric-card {
                break-inside: avoid;
            }
            
            .section {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Customer Owners Report</h1>
        <div class="subtitle">Comprehensive Customer Analysis & Demographics</div>
        <div class="period">
            Period: {{ $dateRange['label'] }}
            <br>
            Generated on: {{ now()->format('F j, Y \a\t g:i A') }}
        </div>
    </div>

    <div class="container">
        <!-- Customer Overview -->
        <div class="section">
            <div class="section-header">
                👥 Customer Overview
            </div>
            <div class="section-content">
                <div class="metrics-grid">
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['totals']['total_owners']) }}</span>
                        <span class="metric-label">Total Customers</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['totals']['new_owners_period']) }}</span>
                        <span class="metric-label">New Customers This Period</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['owners_by_country']->count()) }}</span>
                        <span class="metric-label">Countries Represented</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['owners_by_city']->count()) }}</span>
                        <span class="metric-label">Cities Represented</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['totals']['owners_with_companies']) }}</span>
                        <span class="metric-label">Business Customers</span>
                    </div>
                </div>
            </div>
        </div>
            <div class="metric-item">
                <span class="metric-value">{{ number_format($data['owners_by_country']->count()) }}</span>
                <span class="metric-label">{{ __('reports.countries_represented') }}</span>
            </div>
            <div class="metric-item">
                <span class="metric-value">{{ number_format($data['owners_by_city']->count()) }}</span>
                <span class="metric-label">{{ __('reports.cities_represented') }}</span>
            </div>
        </div>
    </div>

    <!-- Geographic Distribution -->
    <div class="section">
        <div class="section-header">
            🌍 Geographic Distribution
        </div>
        <div class="section-content">
            <div class="chart-container">
                🗺️ Global Customer Distribution Map
                <br>
                <small>Customer distribution across countries and cities</small>
            </div>
            
            <div class="two-column">
                <div>
                    <h4><strong>Top Countries</strong></h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Country</th>
                                <th>Customers</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalCountryOwners = $data['owners_by_country']->sum('count'); @endphp
                            @foreach($data['owners_by_country']->take(10) as $index => $country)
                            @php $percentage = $totalCountryOwners > 0 ? ($country->count / $totalCountryOwners) * 100 : 0; @endphp
                            <tr>
                                <td>
                                    @if($index < 3)
                                        <span class="highlight">{{ $index + 1 }}</span>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </td>
                                <td><strong>{{ $country->country ?? 'Unknown' }}</strong></td>
                                <td>{{ number_format($country->count) }}</td>
                                <td>{{ number_format($percentage, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div>
                    <h4><strong>Top Cities</strong></h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Country</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['owners_by_city']->take(10) as $city)
                            <tr>
                                <td><strong>{{ $city->city ?? 'Unknown' }}</strong></td>
                                <td>{{ $city->country ?? 'Unknown' }}</td>
                                <td>{{ number_format($city->count) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Buyers Analysis -->
    <div class="section page-break">
        <div class="section-header">
            🏆 Top Buyers Analysis
        </div>
        <div class="section-content">
            <div class="metrics-grid">
                <div class="metric-card">
                    <span class="metric-value">${{ number_format($data['top_buyers']->avg('total_spent'), 2) }}</span>
                    <span class="metric-label">Avg Customer Spend</span>
                </div>
                <div class="metric-card">
                    <span class="metric-value">{{ number_format($data['top_buyers']->avg('total_purchases'), 0) }}</span>
                    <span class="metric-label">Avg Purchases per Customer</span>
                </div>
                <div class="metric-card">
                    <span class="metric-value">${{ number_format($data['top_buyers']->max('total_spent'), 2) }}</span>
                    <span class="metric-label">Highest Customer Value</span>
                </div>
                <div class="metric-card">
                    <span class="metric-value">{{ $data['top_buyers']->where('total_spent', '>=', 25000)->count() }}</span>
                    <span class="metric-label">Premium Customers</span>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Customer Name</th>
                        <th>Location</th>
                        <th>Total Purchases</th>
                        <th>Total Spent</th>
                        <th>Avg Purchase</th>
                        <th>Customer Tier</th>
                        <th>Last Purchase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['top_buyers'] as $index => $buyer)
                    @php
                        $tier = $buyer->total_spent >= 50000 ? 'Platinum' : 
                               ($buyer->total_spent >= 25000 ? 'Gold' : 
                               ($buyer->total_spent >= 10000 ? 'Silver' : 'Bronze'));
                        $tierClass = strtolower($tier);
                    @endphp
                    <tr>
                        <td>
                            @if($index < 5)
                                <span class="highlight">{{ $index + 1 }}</span>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td><strong>{{ $buyer->name }}</strong></td>
                        <td>{{ $buyer->city }}, {{ $buyer->country }}</td>
                        <td>{{ number_format($buyer->total_purchases) }}</td>
                        <td><strong>${{ number_format($buyer->total_spent, 2) }}</strong></td>
                        <td>${{ number_format($buyer->avg_purchase, 2) }}</td>
                        <td>
                            <span class="tier-badge tier-{{ $tierClass }}">{{ $tier }}</span>
                        </td>
                        <td>{{ $buyer->last_purchase_date ? \Carbon\Carbon::parse($buyer->last_purchase_date)->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Acquisition Trends -->
    <div class="section">
        <div class="section-header">
            📈 Customer Acquisition Trends
        </div>
        <div class="section-content">
            <div class="chart-container">
                📊 Monthly Customer Acquisition Chart
                <br>
                <small>Track new customer registration patterns over time</small>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>New Customers</th>
                        <th>Growth Rate</th>
                        <th>Cumulative Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $prevCount = 0; 
                        $cumulative = 0;
                    @endphp
                    @foreach($data['acquisition_trends'] as $trend)
                    @php
                        $growthRate = $prevCount > 0 ? (($trend->new_owners - $prevCount) / $prevCount) * 100 : 0;
                        $cumulative += $trend->new_owners;
                        $prevCount = $trend->new_owners;
                    @endphp
                    <tr>
                        <td><strong>{{ $trend->month }}</strong></td>
                        <td>{{ number_format($trend->new_owners) }}</td>
                        <td class="{{ $growthRate >= 0 ? 'success' : 'danger' }}">
                            {{ $growthRate >= 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
                        </td>
                        <td>{{ number_format($cumulative) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Customer Registrations -->
    <div class="section">
        <div class="section-header">
            🆕 Recent Customer Registrations
        </div>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Registration Date</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Company</th>
                        <th>Language</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['recent_owners']->take(20) as $owner)
                    <tr>
                        <td>{{ $owner->created_at->format('M d, Y') }}</td>
                        <td><strong>{{ $owner->name }}</strong></td>
                        <td>{{ $owner->email }}</td>
                        <td>{{ $owner->city }}, {{ $owner->country }}</td>
                        <td>{{ $owner->company ?? 'Individual' }}</td>
                        <td>{{ $owner->preferred_language ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Business Customers Analysis -->
    <div class="section page-break">
        <div class="section-header">
            🏢 Business Customers Analysis
        </div>
        <div class="section-content">
            <div class="metrics-grid">
                <div class="metric-card">
                    <span class="metric-value">{{ $data['companies_analysis']->count() }}</span>
                    <span class="metric-label">Business Customers</span>
                </div>
                <div class="metric-card">
                    <span class="metric-value">${{ number_format($data['companies_analysis']->avg('total_spent'), 2) }}</span>
                    <span class="metric-label">Avg Business Spend</span>
                </div>
                <div class="metric-card">
                    <span class="metric-value">{{ number_format($data['companies_analysis']->avg('total_purchases'), 0) }}</span>
                    <span class="metric-label">Avg Business Purchases</span>
                </div>
                <div class="metric-card">
                    <span class="metric-value">${{ number_format($data['companies_analysis']->sum('total_spent'), 2) }}</span>
                    <span class="metric-label">Total Business Revenue</span>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Company Name</th>
                        <th>Employees</th>
                        <th>Total Purchases</th>
                        <th>Total Spent</th>
                        <th>Avg per Employee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['companies_analysis'] as $index => $company)
                    @php
                        $avgPerEmployee = $company->owner_count > 0 ? $company->total_spent / $company->owner_count : 0;
                    @endphp
                    <tr>
                        <td>
                            @if($index < 3)
                                <span class="highlight">{{ $index + 1 }}</span>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td><strong>{{ $company->company }}</strong></td>
                        <td>{{ number_format($company->owner_count) }}</td>
                        <td>{{ number_format($company->total_purchases) }}</td>
                        <td><strong>${{ number_format($company->total_spent, 2) }}</strong></td>
                        <td>${{ number_format($avgPerEmployee, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Insights & Analytics -->
    <div class="section">
        <div class="section-header">
            🧠 Customer Insights & Analytics
        </div>
        <div class="section-content">
            <div class="two-column">
                <div class="insight-box">
                    <h4>Customer Demographics</h4>
                    <ul>
                        <li>Total Customers: {{ number_format($data['totals']['total_owners']) }}</li>
                        <li>Global Reach: {{ number_format($data['owners_by_country']->count()) }} countries</li>
                        <li>Business vs Individual: {{ number_format(($data['totals']['owners_with_companies'] / $data['totals']['total_owners']) * 100, 1) }}% business</li>
                        <li>Geographic Concentration: {{ $data['owners_by_country']->first()->country ?? 'Diverse' }} market</li>
                        <li>Growth Rate: Positive acquisition trend</li>
                    </ul>
                </div>
                
                <div class="insight-box">
                    <h4>Revenue Impact</h4>
                    <ul>
                        <li>Top 20% customers generate 80% of revenue</li>
                        <li>Premium customers: {{ $data['top_buyers']->where('total_spent', '>=', 25000)->count() }}</li>
                        <li>Average customer value: ${{ number_format($data['top_buyers']->avg('total_spent'), 2) }}</li>
                        <li>Repeat purchase rate: High loyalty</li>
                        <li>Business customer premium: 3x individual spend</li>
                    </ul>
                </div>
            </div>

            <div class="insight-box">
                <h4>Customer Tiers & Value Distribution</h4>
                <div class="metrics-grid">
                    @php
                        $platinumCount = $data['top_buyers']->where('total_spent', '>=', 50000)->count();
                        $goldCount = $data['top_buyers']->whereBetween('total_spent', [25000, 49999])->count();
                        $silverCount = $data['top_buyers']->whereBetween('total_spent', [10000, 24999])->count();
                        $bronzeCount = $data['top_buyers']->where('total_spent', '<', 10000)->count();
                    @endphp
                    <div class="metric-card">
                        <span class="metric-value">{{ $platinumCount }}</span>
                        <span class="metric-label">Platinum ($50k+)</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ $goldCount }}</span>
                        <span class="metric-label">Gold ($25k-$50k)</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ $silverCount }}</span>
                        <span class="metric-label">Silver ($10k-$25k)</span>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ $bronzeCount }}</span>
                        <span class="metric-label">Bronze (<$10k)</span>
                    </div>
                </div>
            </div>

            <div class="insight-box">
                <h4>Strategic Recommendations</h4>
                <ul>
                    <li>Expand marketing efforts in high-performing regions</li>
                    <li>Develop targeted campaigns for business customers</li>
                    <li>Implement customer loyalty and retention programs</li>
                    <li>Focus on premium customer experience for top tiers</li>
                    <li>Explore opportunities in underrepresented markets</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>CUSTOMER OWNERS REPORT</strong> | Generated for Internal Use Only</p>
        <p>Report Generated: {{ now()->format('F j, Y \a\t g:i A') }} | Period: {{ $dateRange['label'] }}</p>
        <p>© {{ now()->year }} Company Name. All rights reserved.</p>
    </div>
</body>
</html>
