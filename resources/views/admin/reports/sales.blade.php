<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Performance Report - {{ $dateRange['label'] }}</title>
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
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
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
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 20px 30px;
            font-size: 20px;
            font-weight: 600;
            border-bottom: 3px solid #a93226;
        }

        .section-content {
            padding: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 8px;
        }

        .stat-label {
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

        .price {
            font-weight: 600;
            color: #27ae60;
        }

        .chart-container {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
        }

        .highlight {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: #333;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
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

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
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

        @page {
            margin: 15mm;
            size: A4;
        }

        @media print {
            .header, .section-header, .table th, .chart-container {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .stat-card {
                break-inside: avoid;
            }
            
            .section {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sales Performance Report</h1>
        <div class="subtitle">Comprehensive Sales Analysis & Metrics</div>
        <div class="period">
            Period: {{ $dateRange['label'] }}
            <br>
            {{ $dateRange['start']->format('M d, Y') }} - {{ $dateRange['end']->format('M d, Y') }}
        </div>
    </div>

    <div class="container">
        <!-- Sales Summary -->
        <div class="section">
            <div class="section-header">
                🎯 Sales Performance Summary
            </div>
            <div class="section-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['summary']['total_sales']) }}</div>
                        <div class="stat-label">Total Sales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value price">${{ number_format($data['summary']['total_revenue'], 2) }}</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value price">${{ number_format($data['summary']['average_sale'], 2) }}</div>
                        <div class="stat-label">Average Sale Value</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['warranty_analysis']->total_sales ?? 0) }}</div>
                        <div class="stat-label">Active Warranties</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['serial_analysis']->unique_serials ?? 0) }}</div>
                        <div class="stat-label">Unique Products</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sales by Product -->
        <div class="section">
            <div class="section-header">
                📦 Product Sales Performance
            </div>
            <div class="section-content">
                @if($data['sales_by_product']->count() > 0)
                    <div class="chart-container">
                        📊 Product Performance Distribution
                        <br>
                        <small>Revenue breakdown by product model and category</small>
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Product Model</th>
                                <th>Product Line</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Revenue</th>
                                <th>Avg Price</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['sales_by_product'] as $index => $product)
                            @php
                                $performance = $product->quantity_sold >= 50 ? 'Excellent' : ($product->quantity_sold >= 25 ? 'Good' : 'Average');
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
                                    <td>{{ $product->category_name }}</td>
                                    <td>{{ number_format($product->quantity_sold) }}</td>
                                    <td class="price"><strong>${{ number_format($product->revenue, 2) }}</strong></td>
                                    <td class="price">${{ number_format($product->avg_price, 2) }}</td>
                                    <td>
                                        <span class="performance-badge badge-{{ strtolower($performance) }}">{{ $performance }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-data">No sales data available for this period</div>
                @endif
            </div>
        </div>

        <!-- Daily Sales Trends -->
        <div class="section">
            <div class="section-header">
                📅 Daily Sales Trends
            </div>
            <div class="section-content">
                <div class="chart-container">
                    📈 Daily Sales Performance Chart
                    <br>
                    <small>Track daily sales patterns and identify peak performance days</small>
                </div>
                
                @if($data['daily_sales']->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Sales Count</th>
                                <th>Revenue</th>
                                <th>Avg Sale Value</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['daily_sales'] as $day)
                            @php
                                $avgDaily = $day->sales_count > 0 ? $day->revenue / $day->sales_count : 0;
                                $performance = $day->sales_count >= 10 ? 'Excellent' : ($day->sales_count >= 5 ? 'Good' : 'Average');
                            @endphp
                                <tr>
                                    <td><strong>{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</strong></td>
                                    <td>{{ number_format($day->sales_count) }}</td>
                                    <td class="price"><strong>${{ number_format($day->revenue, 2) }}</strong></td>
                                    <td class="price">${{ number_format($avgDaily, 2) }}</td>
                                    <td>
                                        <span class="performance-badge badge-{{ strtolower($performance) }}">{{ $performance }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-data">No daily sales data available for this period</div>
                @endif
            </div>
        </div>

        <!-- Sales Team Performance -->
        <div class="section">
            <div class="section-header">
                👥 Sales Team Performance
            </div>
            <div class="section-content">
                @if($data['sales_by_staff']->count() > 0)
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value">{{ $data['sales_by_staff']->count() }}</div>
                            <div class="stat-label">Active Sales Staff</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value price">${{ number_format($data['sales_by_staff']->avg('revenue'), 2) }}</div>
                            <div class="stat-label">Avg Revenue per Staff</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">{{ number_format($data['sales_by_staff']->avg('sales_count'), 0) }}</div>
                            <div class="stat-label">Avg Sales per Staff</div>
                        </div>
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Staff Name</th>
                                <th>Role</th>
                                <th>Sales Count</th>
                                <th>Total Revenue</th>
                                <th>Avg Sale Value</th>
                                <th>Performance</th>
                                <th>Efficiency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['sales_by_staff'] as $index => $staff)
                            @php
                                $avgSale = $staff->sales_count > 0 ? $staff->revenue / $staff->sales_count : 0;
                                $maxRevenue = $data['sales_by_staff']->max('revenue');
                                $efficiency = $maxRevenue > 0 ? ($staff->revenue / $maxRevenue) * 100 : 0;
                                $performance = $staff->sales_count >= 25 ? 'Excellent' : ($staff->sales_count >= 15 ? 'Good' : 'Average');
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
                                    <td class="price"><strong>${{ number_format($staff->revenue, 2) }}</strong></td>
                                    <td class="price">${{ number_format($avgSale, 2) }}</td>
                                    <td>
                                        <span class="performance-badge badge-{{ strtolower($performance) }}">{{ $performance }}</span>
                                    </td>
                                    <td>{{ number_format($efficiency, 1) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-data">No staff sales data available for this period</div>
                @endif
            </div>
        </div>

        <!-- Recent Sales Transactions -->
        <div class="section">
            <div class="section-header">
                🕐 Recent Sales Transactions
            </div>
            <div class="section-content">
                @if($data['recent_sales']->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Sales Rep</th>
                                <th>Sale Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_sales']->take(25) as $sale)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}</td>
                                    <td><strong>{{ $sale->model_name ?? 'N/A' }}</strong></td>
                                    <td>{{ $sale->owner_name ?? 'N/A' }}</td>
                                    <td>{{ $sale->user_name ?? 'N/A' }}</td>
                                    <td class="price"><strong>${{ number_format($sale->purchase_price, 2) }}</strong></td>
                                    <td>
                                        <span class="performance-badge badge-excellent">Completed</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-data">No recent sales data available</div>
                @endif
            </div>
        </div>

        <!-- Warranty & Product Analysis -->
        <div class="section">
            <div class="section-header">
                🛡️ Warranty & Product Analysis
            </div>
            <div class="section-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['warranty_analysis']->total_sales ?? 0) }}</div>
                        <div class="stat-label">Total Products Sold</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['warranty_analysis']->active_warranties ?? 0) }}</div>
                        <div class="stat-label">Active Warranties</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['warranty_analysis']->expired_warranties ?? 0) }}</div>
                        <div class="stat-label">Expired Warranties</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($data['warranty_analysis']->avg_warranty_days ?? 0) }}</div>
                        <div class="stat-label">Avg Warranty Days</div>
                    </div>
                </div>
                
                <div class="chart-container">
                    🔧 Warranty Coverage Analysis
                    <br>
                    <small>Breakdown of warranty status across all sold products</small>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>SALES PERFORMANCE REPORT</strong> | Generated for Internal Use Only</p>
        <p>Report Generated: {{ \Carbon\Carbon::now()->format('F j, Y \a\t g:i A') }} | Period: {{ $dateRange['label'] }}</p>
        <p>© {{ now()->year }} Company Name. All rights reserved.</p>
    </div>
</body>
</html>
