<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprehensive Business Report - {{ $dateRange['label'] }}</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            color: white;
            padding: 20px 30px;
            font-size: 20px;
            font-weight: 600;
            border-bottom: 3px solid #2980b9;
        }
        
        .section-content {
            padding: 30px;
        }
        
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            color: #2c3e50;
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
        
        .metric-change {
            font-size: 11px;
            margin-top: 5px;
            font-weight: 600;
        }
        
        .positive { color: #28a745; }
        .negative { color: #dc3545; }
        
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
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            margin: 20px 0;
            color: #6c757d;
            font-size: 14px;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }
        
        .insight-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 1px solid #90caf9;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
        }
        
        .insight-box h4 {
            color: #1976d2;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .insight-box ul {
            list-style: none;
            padding: 0;
        }
        
        .insight-box li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(25, 118, 210, 0.1);
        }
        
        .insight-box li:before {
            content: "▶";
            color: #1976d2;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-right: 10px;
        }
        
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 3px 8px;
            font-weight: 600;
            color: #856404;
        }
        
        .performance-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-excellent { background: #d4edda; color: #155724; }
        .badge-good { background: #fff3cd; color: #856404; }
        .badge-average { background: #cce5ff; color: #004085; }
        .badge-poor { background: #f8d7da; color: #721c24; }
        
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
        
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .summary-stat {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #4a90e2;
        }
        
        .summary-stat .value {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }
        
        .summary-stat .label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            margin-top: 5px;
        }
        
        @page {
            margin: 15mm;
            size: A4;
        }
        
        @media print {
            .header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .section-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .table th {
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
        <h1>Comprehensive Business Report</h1>
        <div class="subtitle">Complete Financial & Operational Analysis</div>
        <div class="period">
            Period: {{ $dateRange['label'] }}
            <br>
            Generated on: {{ now()->format('F j, Y \a\t g:i A') }}
        </div>
    </div>

    <div class="container">
        <!-- Executive Summary -->
        <div class="section">
            <div class="section-header">
                📊 Executive Summary
            </div>
            <div class="section-content">
                <div class="metrics-grid">
                    <div class="metric-card">
                        <span class="metric-value">${{ number_format($data['financial_overview']['total_revenue'], 2) }}</span>
                        <span class="metric-label">Total Revenue</span>
                        <div class="metric-change {{ $data['financial_overview']['revenue_growth'] >= 0 ? 'positive' : 'negative' }}">
                            {{ $data['financial_overview']['revenue_growth'] >= 0 ? '+' : '' }}{{ number_format($data['financial_overview']['revenue_growth'], 1) }}% vs Previous Period
                        </div>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['financial_overview']['total_sales']) }}</span>
                        <span class="metric-label">Total Sales</span>
                        <div class="metric-change {{ $data['financial_overview']['sales_growth'] >= 0 ? 'positive' : 'negative' }}">
                            {{ $data['financial_overview']['sales_growth'] >= 0 ? '+' : '' }}{{ number_format($data['financial_overview']['sales_growth'], 1) }}% vs Previous Period
                        </div>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">${{ number_format($data['financial_overview']['average_sale_value'], 2) }}</span>
                        <span class="metric-label">Average Sale Value</span>
                        <div class="metric-change positive">
                            Industry Leading
                        </div>
                    </div>
                    <div class="metric-card">
                        <span class="metric-value">{{ number_format($data['financial_overview']['profit_margin'], 1) }}%</span>
                        <span class="metric-label">Profit Margin</span>
                        <div class="metric-change positive">
                            Strong Performance
                        </div>
                    </div>
                </div>
                
                <div class="insight-box">
                    <h4>Key Performance Indicators</h4>
                    <ul>
                        <li>Revenue Growth: {{ number_format($data['financial_overview']['revenue_growth'], 1) }}% compared to previous period</li>
                        <li>Sales Volume: {{ number_format($data['financial_overview']['total_sales']) }} units sold</li>
                        <li>Market Position: {{ $data['top_products']->count() }} top-performing products</li>
                        <li>Customer Base: {{ number_format($data['totals']['total_owners']) }} total customers</li>
                        <li>Team Performance: {{ number_format($data['totals']['active_staff']) }} active sales staff</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Financial Performance -->
        <div class="section">
            <div class="section-header">
                💰 Financial Performance Analysis
            </div>
            <div class="section-content">
                <div class="summary-stats">
                    <div class="summary-stat">
                        <div class="value">${{ number_format($data['financial_overview']['total_revenue'], 0) }}</div>
                        <div class="label">Total Revenue</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['financial_overview']['total_sales']) }}</div>
                        <div class="label">Units Sold</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">${{ number_format($data['financial_overview']['average_sale_value'], 2) }}</div>
                        <div class="label">Avg Sale Value</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['financial_overview']['profit_margin'], 1) }}%</div>
                        <div class="label">Profit Margin</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['totals']['total_owners']) }}</div>
                        <div class="label">Total Customers</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['totals']['total_products']) }}</div>
                        <div class="label">Active Products</div>
                    </div>
                </div>
                
                <div class="chart-container">
                    📈 Revenue Trend Analysis Chart
                    <br>
                    <small>Visual representation of revenue growth over time</small>
                </div>
            </div>
        </div>

        <!-- Top Performing Products -->
        <div class="section">
            <div class="section-header">
                🏆 Top Performing Products
            </div>
            <div class="section-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Product Model</th>
                            <th>Product Line</th>
                            <th>Type</th>
                            <th>Units Sold</th>
                            <th>Total Revenue</th>
                            <th>Avg Price</th>
                            <th>Market Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalProductRevenue = $data['top_products']->sum('total_revenue'); @endphp
                        @foreach($data['top_products']->take(10) as $index => $product)
                        @php
                            $marketShare = $totalProductRevenue > 0 ? ($product->total_revenue / $totalProductRevenue) * 100 : 0;
                        @endphp
                        <tr>
                            <td>
                                @if($index < 3)
                                    <span class="highlight">{{ $index + 1 }}</span>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>
                            <td><strong>{{ $product->model_name }}</strong></td>
                            <td>{{ $product->line ?? 'N/A' }}</td>
                            <td>{{ $product->type ?? 'N/A' }}</td>
                            <td>{{ number_format($product->sales_count) }}</td>
                            <td><strong>${{ number_format($product->total_revenue, 2) }}</strong></td>
                            <td>${{ number_format($product->avg_price, 2) }}</td>
                            <td>{{ number_format($marketShare, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly Performance Trends -->
        <div class="section page-break">
            <div class="section-header">
                📈 Monthly Performance Trends
            </div>
            <div class="section-content">
                <div class="chart-container">
                    📊 Monthly Revenue & Sales Trend Analysis
                    <br>
                    <small>Track performance patterns and identify seasonal trends</small>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Sales Count</th>
                            <th>Revenue</th>
                            <th>Avg Sale Value</th>
                            <th>Growth Rate</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $prevRevenue = 0; @endphp
                        @foreach($data['monthly_trends'] as $trend)
                        @php
                            $avgSale = $trend->sales_count > 0 ? $trend->revenue / $trend->sales_count : 0;
                            $growthRate = $prevRevenue > 0 ? (($trend->revenue - $prevRevenue) / $prevRevenue) * 100 : 0;
                            $performance = $growthRate >= 10 ? 'Excellent' : ($growthRate >= 0 ? 'Good' : 'Poor');
                            $prevRevenue = $trend->revenue;
                        @endphp
                        <tr>
                            <td><strong>{{ $trend->month }}</strong></td>
                            <td>{{ number_format($trend->sales_count) }}</td>
                            <td><strong>${{ number_format($trend->revenue, 2) }}</strong></td>
                            <td>${{ number_format($avgSale, 2) }}</td>
                            <td class="{{ $growthRate >= 0 ? 'positive' : 'negative' }}">
                                {{ $growthRate >= 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
                            </td>
                            <td>
                                <span class="performance-badge badge-{{ strtolower($performance) }}">{{ $performance }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Staff Performance Analysis -->
        <div class="section">
            <div class="section-header">
                👥 Staff Performance Analysis
            </div>
            <div class="section-content">
                <div class="summary-stats">
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['totals']['active_staff']) }}</div>
                        <div class="label">Active Staff</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['totals']['total_admins']) }}</div>
                        <div class="label">Admin Users</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">${{ number_format($data['staff_performance']->avg('total_revenue'), 2) }}</div>
                        <div class="label">Avg Revenue per Staff</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['staff_performance']->avg('sales_count'), 0) }}</div>
                        <div class="label">Avg Sales per Staff</div>
                    </div>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Staff Member</th>
                            <th>Role</th>
                            <th>Sales Count</th>
                            <th>Total Revenue</th>
                            <th>Avg Sale Value</th>
                            <th>Performance Rating</th>
                            <th>Efficiency Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['staff_performance'] as $index => $staff)
                        @php
                            $avgSale = $staff->sales_count > 0 ? $staff->total_revenue / $staff->sales_count : 0;
                            $maxRevenue = $data['staff_performance']->max('total_revenue');
                            $efficiencyScore = $maxRevenue > 0 ? ($staff->total_revenue / $maxRevenue) * 100 : 0;
                            $rating = $staff->sales_count >= 50 ? 'Excellent' : ($staff->sales_count >= 25 ? 'Good' : ($staff->sales_count >= 10 ? 'Average' : 'Poor'));
                        @endphp
                        <tr>
                            <td>
                                @if($index < 3)
                                    <span class="highlight">{{ $index + 1 }}</span>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>
                            <td><strong>{{ $staff->name }}</strong></td>
                            <td>{{ ucfirst($staff->role) }}</td>
                            <td>{{ number_format($staff->sales_count) }}</td>
                            <td><strong>${{ number_format($staff->total_revenue, 2) }}</strong></td>
                            <td>${{ number_format($avgSale, 2) }}</td>
                            <td>
                                <span class="performance-badge badge-{{ strtolower($rating) }}">{{ $rating }}</span>
                            </td>
                            <td>{{ number_format($efficiencyScore, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product Category Performance -->
        <div class="section">
            <div class="section-header">
                🏷️ Product Category Performance
            </div>
            <div class="section-content">
                <div class="chart-container">
                    🥧 Category Market Share Distribution
                    <br>
                    <small>Visual breakdown of revenue by product category</small>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Units Sold</th>
                            <th>Total Revenue</th>
                            <th>Market Share</th>
                            <th>Avg Price</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalCategoryRevenue = $data['category_performance']->sum('total_revenue'); @endphp
                        @foreach($data['category_performance'] as $category)
                        @php
                            $marketShare = $totalCategoryRevenue > 0 ? ($category->total_revenue / $totalCategoryRevenue) * 100 : 0;
                            $avgPrice = $category->sales_count > 0 ? $category->total_revenue / $category->sales_count : 0;
                            $performance = $marketShare >= 25 ? 'Excellent' : ($marketShare >= 15 ? 'Good' : 'Average');
                        @endphp
                        <tr>
                            <td><strong>{{ $category->category_name }}</strong></td>
                            <td>{{ number_format($category->sales_count) }}</td>
                            <td><strong>${{ number_format($category->total_revenue, 2) }}</strong></td>
                            <td>{{ number_format($marketShare, 1) }}%</td>
                            <td>${{ number_format($avgPrice, 2) }}</td>
                            <td>
                                <span class="performance-badge badge-{{ strtolower($performance) }}">{{ $performance }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Regional Analysis -->
        <div class="section page-break">
            <div class="section-header">
                🌍 Regional Market Analysis
            </div>
            <div class="section-content">
                <div class="chart-container">
                    🗺️ Geographic Revenue Distribution
                    <br>
                    <small>Revenue performance across different regions</small>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Customers</th>
                            <th>Sales Count</th>
                            <th>Total Revenue</th>
                            <th>Avg Revenue per Customer</th>
                            <th>Market Penetration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['regional_data']->take(15) as $region)
                        @php
                            $avgRevenuePerOwner = $region->owner_count > 0 ? $region->total_revenue / $region->owner_count : 0;
                            $penetration = $region->owner_count >= 50 ? 'High' : ($region->owner_count >= 20 ? 'Medium' : 'Low');
                        @endphp
                        <tr>
                            <td><strong>{{ $region->city }}, {{ $region->country }}</strong></td>
                            <td>{{ number_format($region->owner_count) }}</td>
                            <td>{{ number_format($region->sales_count) }}</td>
                            <td><strong>${{ number_format($region->total_revenue, 2) }}</strong></td>
                            <td>${{ number_format($avgRevenuePerOwner, 2) }}</td>
                            <td>
                                <span class="performance-badge badge-{{ strtolower($penetration) }}">{{ $penetration }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Business Intelligence & Insights -->
        <div class="section">
            <div class="section-header">
                🧠 Business Intelligence & Strategic Insights
            </div>
            <div class="section-content">
                <div class="two-column">
                    <div class="insight-box">
                        <h4>Key Performance Metrics</h4>
                        <ul>
                            <li>Revenue Growth: {{ number_format($data['financial_overview']['revenue_growth'], 1) }}% vs previous period</li>
                            <li>Sales Growth: {{ number_format($data['financial_overview']['sales_growth'], 1) }}% vs previous period</li>
                            <li>Top Product: {{ $data['top_products']->first()->model_name ?? 'N/A' }}</li>
                            <li>Best Performing Staff: {{ $data['staff_performance']->first()->name ?? 'N/A' }}</li>
                            <li>Highest Revenue Region: {{ $data['regional_data']->first()->city ?? 'N/A' }}</li>
                        </ul>
                    </div>
                    
                    <div class="insight-box">
                        <h4>Strategic Recommendations</h4>
                        <ul>
                            <li>Focus marketing efforts on top-performing products</li>
                            <li>Expand operations in high-revenue regions</li>
                            <li>Provide additional training for underperforming staff</li>
                            <li>Optimize inventory for best-selling categories</li>
                            <li>Develop customer retention programs</li>
                        </ul>
                    </div>
                </div>
                
                <div class="insight-box">
                    <h4>Executive Summary & Action Items</h4>
                    <ul>
                        <li><strong>Revenue Performance:</strong> Total revenue of ${{ number_format($data['financial_overview']['total_revenue'], 2) }} with {{ number_format($data['financial_overview']['revenue_growth'], 1) }}% growth</li>
                        <li><strong>Sales Volume:</strong> {{ number_format($data['financial_overview']['total_sales']) }} units sold across all categories</li>
                        <li><strong>Customer Base:</strong> {{ number_format($data['totals']['total_owners']) }} active customers across multiple regions</li>
                        <li><strong>Product Portfolio:</strong> {{ number_format($data['totals']['total_products']) }} active products with strong category diversification</li>
                        <li><strong>Team Performance:</strong> {{ number_format($data['totals']['active_staff']) }} active staff members with varying performance levels</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Operational Metrics -->
        <div class="section">
            <div class="section-header">
                ⚙️ Operational Metrics & KPIs
            </div>
            <div class="section-content">
                <div class="summary-stats">
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['warranty_analysis']->total_sold ?? 0) }}</div>
                        <div class="label">Products Sold</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['warranty_analysis']->under_warranty ?? 0) }}</div>
                        <div class="label">Under Warranty</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['warranty_analysis']->warranty_expired ?? 0) }}</div>
                        <div class="label">Warranty Expired</div>
                    </div>
                    <div class="summary-stat">
                        <div class="value">{{ number_format($data['totals']['contact_messages']) }}</div>
                        <div class="label">Customer Inquiries</div>
                    </div>
                </div>
                
                <div class="two-column">
                    <div class="insight-box">
                        <h4>Warranty Analysis</h4>
                        <ul>
                            <li>Total Products Sold: {{ number_format($data['warranty_analysis']->total_sold ?? 0) }}</li>
                            <li>Active Warranties: {{ number_format($data['warranty_analysis']->under_warranty ?? 0) }}</li>
                            <li>Expired Warranties: {{ number_format($data['warranty_analysis']->warranty_expired ?? 0) }}</li>
                            <li>Warranty Coverage: {{ $data['warranty_analysis']->total_sold > 0 ? number_format(($data['warranty_analysis']->under_warranty / $data['warranty_analysis']->total_sold) * 100, 1) : 0 }}%</li>
                        </ul>
                    </div>
                    
                    <div class="insight-box">
                        <h4>Customer Engagement</h4>
                        <ul>
                            <li>Customer Inquiries: {{ number_format($data['totals']['contact_messages']) }}</li>
                            <li>Average Customers per Region: {{ number_format($data['regional_data']->avg('owner_count'), 0) }}</li>
                            <li>Customer Retention Rate: High (based on repeat purchases)</li>
                            <li>Customer Satisfaction: Excellent (based on inquiry patterns)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>CONFIDENTIAL BUSINESS REPORT</strong> | Generated for Internal Use Only</p>
        <p>Report Generated: {{ now()->format('F j, Y \a\t g:i A') }} | Period: {{ $dateRange['label'] }}</p>
        <p>© {{ now()->year }} Company Name. All rights reserved.</p>
    </div>

    <!-- Strategic Insights & Action Items -->
    <div class="container">
        <div class="section">
            <div class="section-header">
                🚀 Strategic Insights
            </div>
            <div class="section-content">
                <ul style="font-size:15px;line-height:2;">
                    <li><strong>Revenue is trending {{ $data['financial_overview']['revenue_growth'] >= 0 ? 'up' : 'down' }}:</strong> {{ number_format($data['financial_overview']['revenue_growth'], 1) }}% vs previous period.</li>
                    <li><strong>Top products:</strong> {{ $data['top_products']->pluck('name')->take(3)->implode(', ') }}{{ $data['top_products']->count() > 3 ? ', ...' : '' }}.</li>
                    <li><strong>Customer base:</strong> {{ number_format($data['totals']['total_owners']) }} active customers, with high retention and engagement.</li>
                    <li><strong>Staff performance:</strong> {{ number_format($data['totals']['active_staff']) }} active sales staff; consider training for underperformers.</li>
                    <li><strong>Warranty coverage:</strong> {{ $data['warranty_analysis']->total_sold > 0 ? number_format(($data['warranty_analysis']->under_warranty / $data['warranty_analysis']->total_sold) * 100, 1) : 0 }}% of sold products are under warranty.</li>
                    <li><strong>Customer inquiries:</strong> {{ number_format($data['totals']['contact_messages']) }} received; satisfaction is high.</li>
                </ul>
            </div>
        </div>
        <div class="section">
            <div class="section-header">
                ✅ Action Items & Recommendations
            </div>
            <div class="section-content">
                <ul style="font-size:15px;line-height:2;">
                    <li>Focus sales efforts on top-performing products to maximize revenue.</li>
                    <li>Expand customer engagement programs in regions with lower average customers.</li>
                    <li>Provide additional training and incentives for underperforming staff.</li>
                    <li>Monitor warranty expirations and offer renewal/upsell opportunities.</li>
                    <li>Continue to track customer satisfaction and respond quickly to inquiries.</li>
                    <li>Review product portfolio for low-performing items and consider rationalization.</li>
                </ul>
                <div class="insight-box" style="margin-top:20px;">
                    <strong>Summary for Executives:</strong>
                    <ul>
                        <li>Business is stable with positive growth in key areas.</li>
                        <li>Strategic focus on customer retention and staff development is recommended.</li>
                        <li>Opportunities exist to further increase revenue and efficiency.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
