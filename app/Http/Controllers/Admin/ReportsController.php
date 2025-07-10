<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Product;
use App\Models\SoldProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsController extends Controller
{
    public function index()
    {
        // Check if user has permission to access reports
        $user = auth()->user();
        if (!$user || !$user->canAccessReports()) {
            abort(403, __('reports.access_denied'));
        }
        
        // Get real statistics for preview
        $stats = $this->getPreviewStats();
        
        return view('admin.reports.index', compact('stats'));
    }
    
    private function getPreviewStats()
    {
        // Last 30 days statistics
        $last30Days = Carbon::now()->subDays(30);
        
        return [
            'comprehensive' => [
                'revenue' => SoldProduct::where('sale_date', '>=', $last30Days)->sum('purchase_price'),
                'sales' => SoldProduct::where('sale_date', '>=', $last30Days)->count(),
            ],
            'owners' => [
                'total_owners' => Owner::count(),
                'countries' => Owner::whereNotNull('country')->distinct('country')->count(),
            ],
            'sales' => [
                'products_sold' => SoldProduct::where('sale_date', '>=', $last30Days)->count(),
                'avg_sale' => SoldProduct::where('sale_date', '>=', $last30Days)->avg('purchase_price') ?? 0,
            ],
        ];
    }

    public function downloadComprehensiveReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }
        
        // Force English locale for PDF reports
        app()->setLocale('en');
        
        $dateRange = $this->getDateRange($request);
        $data = $this->getComprehensiveData($dateRange);
        
        // Generate PDF using dompdf directly
        $html = view('admin.reports.comprehensive', compact('data', 'dateRange'))->render();
        
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'comprehensive-business-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';
        
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function downloadOwnersReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }
        
        // Force English locale for PDF reports
        app()->setLocale('en');
        
        $dateRange = $this->getDateRange($request);
        $data = $this->getOwnersData($dateRange);
        
        // Generate PDF using dompdf directly
        $html = view('admin.reports.owners', compact('data', 'dateRange'))->render();
        
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'customer-owners-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';
        
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function downloadSalesReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }
        
        // Force English locale for PDF reports
        app()->setLocale('en');
        
        $dateRange = $this->getDateRange($request);
        $data = $this->getSalesData($dateRange);
        
        // Generate PDF using dompdf directly
        $html = view('admin.reports.sales', compact('data', 'dateRange'))->render();
        
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'sales-performance-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';
        
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function getDateRange(Request $request)
    {
        $period = $request->get('period', 'last_30_days');
        
        switch ($period) {
            case 'last_7_days':
                return [
                    'start' => Carbon::now()->subDays(7),
                    'end' => Carbon::now(),
                    'label' => 'Last 7 Days'
                ];
            case 'last_30_days':
                return [
                    'start' => Carbon::now()->subDays(30),
                    'end' => Carbon::now(),
                    'label' => 'Last 30 Days'
                ];
            case 'last_90_days':
                return [
                    'start' => Carbon::now()->subDays(90),
                    'end' => Carbon::now(),
                    'label' => 'Last 90 Days'
                ];
            case 'this_year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now(),
                    'label' => 'This Year'
                ];
            case 'last_year':
                return [
                    'start' => Carbon::now()->subYear()->startOfYear(),
                    'end' => Carbon::now()->subYear()->endOfYear(),
                    'label' => 'Last Year'
                ];
            case 'custom':
                return [
                    'start' => Carbon::parse($request->get('start_date', Carbon::now()->subDays(30))),
                    'end' => Carbon::parse($request->get('end_date', Carbon::now())),
                    'label' => 'Custom Range'
                ];
            default:
                return [
                    'start' => Carbon::now()->subDays(30),
                    'end' => Carbon::now(),
                    'label' => 'Last 30 Days'
                ];
        }
    }

    private function getComprehensiveData($dateRange)
    {
        // Financial Overview - Based on your sold_products table
        $totalRevenue = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->sum('purchase_price'); // Using purchase_price as the main revenue metric
        
        $totalSales = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])->count();
        $averageSaleValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // Calculate profit margin (assuming 30% margin for display purposes)
        $profitMargin = 30; // This can be adjusted based on actual business logic

        // Top Performing Products - Updated for your product structure
        $topProducts = SoldProduct::select('products.model_name', 'products.line', 'products.type',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'),
                DB::raw('AVG(sold_products.purchase_price) as avg_price'))
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('products.id', 'products.model_name', 'products.line', 'products.type')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Monthly Trends - Updated for sale_date
        $monthlyTrends = SoldProduct::select(
                DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(purchase_price) as revenue'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Staff Performance - Updated for your user structure
        $staffPerformance = SoldProduct::select('users.name', 'users.role',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->join('users', 'sold_products.user_id', '=', 'users.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('users.id', 'users.name', 'users.role')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Product Categories Performance - Updated for your structure
        $categoryPerformance = SoldProduct::select('product_categories.name as category_name',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Regional Analysis - Updated for your owners structure
        $regionalData = Owner::select('city', 'country',
                DB::raw('COUNT(DISTINCT owners.id) as owner_count'),
                DB::raw('COUNT(sold_products.id) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereBetween('sold_products.sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('city', 'country')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Growth Metrics (comparing to previous period)
        $prevPeriodStart = $dateRange['start']->copy()->sub($dateRange['end']->diffInDays($dateRange['start']), 'days');
        $prevPeriodEnd = $dateRange['start']->copy()->subDay();

        $prevRevenue = SoldProduct::whereBetween('sale_date', [$prevPeriodStart, $prevPeriodEnd])->sum('purchase_price');
        $prevSales = SoldProduct::whereBetween('sale_date', [$prevPeriodStart, $prevPeriodEnd])->count();

        $revenueGrowth = $prevRevenue > 0 ? (($totalRevenue - $prevRevenue) / $prevRevenue) * 100 : 0;
        $salesGrowth = $prevSales > 0 ? (($totalSales - $prevSales) / $prevSales) * 100 : 0;

        // Additional metrics based on your actual data
        $totalProducts = Product::where('is_active', true)->count();
        $totalOwners = Owner::count();
        $activeStaff = User::where('role', 'employee')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Contact messages metrics
        $contactMessages = DB::table('contact_messages')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();

        // Warranty analysis
        $warrantyAnalysis = SoldProduct::select(
                DB::raw('COUNT(*) as total_sold'),
                DB::raw('COUNT(CASE WHEN warranty_end_date > NOW() THEN 1 END) as under_warranty'),
                DB::raw('COUNT(CASE WHEN warranty_end_date <= NOW() THEN 1 END) as warranty_expired'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        return [
            'financial_overview' => [
                'total_revenue' => $totalRevenue,
                'total_sales' => $totalSales,
                'average_sale_value' => $averageSaleValue,
                'revenue_growth' => $revenueGrowth,
                'sales_growth' => $salesGrowth,
                'profit_margin' => $totalRevenue > 0 ? (($totalRevenue * 0.3) / $totalRevenue) * 100 : 0, // Assuming 30% margin
            ],
            'top_products' => $topProducts,
            'monthly_trends' => $monthlyTrends,
            'staff_performance' => $staffPerformance,
            'category_performance' => $categoryPerformance,
            'regional_data' => $regionalData,
            'totals' => [
                'total_owners' => $totalOwners,
                'total_products' => $totalProducts,
                'active_staff' => $activeStaff,
                'total_admins' => $totalAdmins,
                'contact_messages' => $contactMessages,
            ],
            'warranty_analysis' => $warrantyAnalysis,
        ];
    }

    private function getOwnersData($dateRange)
    {
        // Owner Demographics - Updated for your structure
        $ownersByCountry = Owner::select('country', DB::raw('COUNT(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->get();

        $ownersByCity = Owner::select('city', 'country', DB::raw('COUNT(*) as count'))
            ->whereNotNull('city')
            ->groupBy('city', 'country')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();

        // Owner Purchase Behavior - Updated for your sold_products structure
        $topBuyers = Owner::select('owners.*',
                DB::raw('COUNT(sold_products.id) as total_purchases'),
                DB::raw('SUM(sold_products.purchase_price) as total_spent'),
                DB::raw('AVG(sold_products.purchase_price) as avg_purchase'),
                DB::raw('MAX(sold_products.sale_date) as last_purchase_date'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereBetween('sold_products.sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('owners.id')
            ->orderBy('total_spent', 'desc')
            ->limit(20)
            ->get();

        // Recent Registrations
        $recentOwners = Owner::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->orderBy('created_at', 'desc')
            ->get();

        // Owner Acquisition Trends
        $acquisitionTrends = Owner::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as new_owners'))
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Company analysis
        $companiesAnalysis = Owner::select('company', 
                DB::raw('COUNT(*) as owner_count'),
                DB::raw('COUNT(sold_products.id) as total_purchases'),
                DB::raw('SUM(sold_products.purchase_price) as total_spent'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereNotNull('company')
            ->groupBy('company')
            ->orderBy('total_spent', 'desc')
            ->limit(15)
            ->get();

        // Language preferences
        $languagePreferences = Owner::select('preferred_language', DB::raw('COUNT(*) as count'))
            ->groupBy('preferred_language')
            ->get();

        return [
            'owners_by_country' => $ownersByCountry,
            'owners_by_city' => $ownersByCity,
            'top_buyers' => $topBuyers,
            'recent_owners' => $recentOwners,
            'acquisition_trends' => $acquisitionTrends,
            'companies_analysis' => $companiesAnalysis,
            'language_preferences' => $languagePreferences,
            'totals' => [
                'total_owners' => Owner::count(),
                'new_owners_period' => $recentOwners->count(),
                'owners_with_companies' => Owner::whereNotNull('company')->count(),
            ],
        ];
    }

    private function getSalesData($dateRange)
    {
        // Sales Summary - Updated for your structure
        $totalSales = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])->count();
        $totalRevenue = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])->sum('purchase_price');

        // Sales by Product - Updated for your product structure
        $salesByProduct = SoldProduct::select('products.model_name', 'products.line', 'products.type',
                'product_categories.name as category_name',
                DB::raw('COUNT(*) as quantity_sold'),
                DB::raw('SUM(sold_products.purchase_price) as revenue'),
                DB::raw('AVG(sold_products.purchase_price) as avg_price'))
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('products.id', 'products.model_name', 'products.line', 'products.type', 'product_categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Sales by Period - Updated for sale_date
        $dailySales = SoldProduct::select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(purchase_price) as revenue'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Sales by Staff - Updated for your user structure
        $salesByStaff = SoldProduct::select('users.name', 'users.role',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as revenue'))
            ->join('users', 'sold_products.user_id', '=', 'users.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('users.id', 'users.name', 'users.role')
            ->orderBy('revenue', 'desc')
            ->get();

        // Recent Sales - Updated with proper relationships
        $recentSales = SoldProduct::with(['product', 'owner', 'user'])
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->join('owners', 'sold_products.owner_id', '=', 'owners.id')
            ->join('users', 'sold_products.user_id', '=', 'users.id')
            ->select('sold_products.*', 'products.model_name', 'owners.name as owner_name', 'users.name as user_name')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->orderBy('sale_date', 'desc')
            ->limit(50)
            ->get();

        // Warranty Analysis
        $warrantyAnalysis = SoldProduct::select(
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('COUNT(CASE WHEN warranty_end_date > NOW() THEN 1 END) as active_warranties'),
                DB::raw('COUNT(CASE WHEN warranty_end_date <= NOW() THEN 1 END) as expired_warranties'),
                DB::raw('AVG(DATEDIFF(warranty_end_date, warranty_start_date)) as avg_warranty_days'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        // Serial Number Analysis
        $serialAnalysis = SoldProduct::select(
                DB::raw('COUNT(DISTINCT serial_number) as unique_serials'),
                DB::raw('COUNT(*) as total_sales'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        return [
            'summary' => [
                'total_sales' => $totalSales,
                'total_revenue' => $totalRevenue,
                'average_sale' => $totalSales > 0 ? $totalRevenue / $totalSales : 0,
            ],
            'sales_by_product' => $salesByProduct,
            'daily_sales' => $dailySales,
            'sales_by_staff' => $salesByStaff,
            'recent_sales' => $recentSales,
            'warranty_analysis' => $warrantyAnalysis,
            'serial_analysis' => $serialAnalysis,
        ];
    }
}
