<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\ContactMessage;
use App\Models\SoldProduct;
use App\Models\Owner;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            
            if ($user->isAdmin()) {
                return $this->getAdminDashboard();
            } else {
                return $this->getEmployeeDashboard($user);
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }
    }

    private function getAdminDashboard()
    {
        // Main statistics
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'total_sold_products' => SoldProduct::count(),
            'total_owners' => Owner::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'pending_changes' => DB::table('pending_changes')->where('status', 'pending')->count(),
            'total_revenue' => SoldProduct::sum('purchase_price'),
            'avg_sale_price' => SoldProduct::avg('purchase_price'),
            'recent_users' => User::orderBy('created_at', 'desc')->limit(5)->get(),
            'recent_messages' => ContactMessage::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        // Time-based analytics
        $analytics = [
            'daily_sales' => $this->getDailySalesData(),
            'monthly_revenue' => $this->getMonthlyRevenueData(),
            'product_performance' => $this->getProductPerformanceData(),
            'user_activity' => $this->getUserActivityData(),
            'sales_by_region' => $this->getSalesByRegionData(),
            'product_categories' => $this->getProductCategoryData(),
            'recent_activity' => $this->getRecentActivityData(),
            'growth_metrics' => $this->getGrowthMetrics(),
            'top_performers' => $this->getTopPerformers(),
        ];

        // Real-time metrics
        $realtime = [
            'today_sales' => SoldProduct::whereDate('created_at', today())->count(),
            'today_revenue' => SoldProduct::whereDate('created_at', today())->sum('purchase_price'),
            'this_week_sales' => SoldProduct::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month_sales' => SoldProduct::where('created_at', '>=', now()->startOfMonth())->count(),
            'system_health' => $this->getSystemHealthData(),
        ];

        return view('admin.dashboard', compact('stats', 'analytics', 'realtime'));
    }

    private function getEmployeeDashboard($user)
    {
        // Employee-specific stats
        $stats = [
            'my_total_sales' => SoldProduct::where('user_id', $user->id)->count(),
            'my_today_sales' => SoldProduct::where('user_id', $user->id)->whereDate('created_at', today())->count(),
            'my_this_month_sales' => SoldProduct::where('user_id', $user->id)->whereMonth('created_at', now()->month)->count(),
            'my_total_revenue' => SoldProduct::where('user_id', $user->id)->sum('purchase_price'),
            'total_owners' => Owner::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'pending_changes' => DB::table('pending_changes')->where('status', 'pending')->count(),
        ];

        // Employee analytics
        $analytics = [
            'my_daily_sales' => $this->getEmployeeDailySales($user->id),
            'my_monthly_performance' => $this->getEmployeeMonthlyPerformance($user->id),
            'recent_activity' => $this->getEmployeeRecentActivity($user->id),
        ];

        return view('admin.dashboard', compact('stats', 'analytics', 'user'));
    }

    private function getDailySalesData()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $sales = SoldProduct::whereDate('created_at', $date)->count();
            $revenue = SoldProduct::whereDate('created_at', $date)->sum('purchase_price');
            
            $data[] = [
                'date' => $date->format('M d'),
                'sales' => $sales,
                'revenue' => $revenue
            ];
        }
        return $data;
    }

    private function getMonthlyRevenueData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = SoldProduct::whereYear('created_at', $date->year)
                                 ->whereMonth('created_at', $date->month)
                                 ->sum('purchase_price');
            
            $data[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ];
        }
        return $data;
    }

    private function getProductPerformanceData()
    {
        return Product::select('products.model_name', DB::raw('COUNT(sold_products.id) as sales_count'), DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->leftJoin('sold_products', 'products.id', '=', 'sold_products.product_id')
            ->groupBy('products.id', 'products.model_name')
            ->orderBy('sales_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getUserActivityData()
    {
        return User::select('users.name', DB::raw('COUNT(sold_products.id) as sales_count'), DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->leftJoin('sold_products', 'users.id', '=', 'sold_products.user_id')
            ->where('users.role', 'employee')
            ->groupBy('users.id', 'users.name')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();
    }

    private function getSalesByRegionData()
    {
        return Owner::select('country', DB::raw('COUNT(sold_products.id) as sales_count'), DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('sales_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getProductCategoryData()
    {
        return DB::table('product_categories')
            ->select('product_categories.name', DB::raw('COUNT(sold_products.id) as sales_count'))
            ->leftJoin('products', 'product_categories.id', '=', 'products.category_id')
            ->leftJoin('sold_products', 'products.id', '=', 'sold_products.product_id')
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderBy('sales_count', 'desc')
            ->get();
    }

    private function getRecentActivityData()
    {
        return AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();
    }

    private function getGrowthMetrics()
    {
        $currentMonth = now();
        $lastMonth = now()->subMonth();

        $currentSales = SoldProduct::whereYear('created_at', $currentMonth->year)
                                  ->whereMonth('created_at', $currentMonth->month)
                                  ->count();
        
        $lastMonthSales = SoldProduct::whereYear('created_at', $lastMonth->year)
                                    ->whereMonth('created_at', $lastMonth->month)
                                    ->count();

        $currentRevenue = SoldProduct::whereYear('created_at', $currentMonth->year)
                                    ->whereMonth('created_at', $currentMonth->month)
                                    ->sum('purchase_price');
        
        $lastMonthRevenue = SoldProduct::whereYear('created_at', $lastMonth->year)
                                      ->whereMonth('created_at', $lastMonth->month)
                                      ->sum('purchase_price');

        return [
            'sales_growth' => $lastMonthSales > 0 ? (($currentSales - $lastMonthSales) / $lastMonthSales) * 100 : 0,
            'revenue_growth' => $lastMonthRevenue > 0 ? (($currentRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0,
            'current_sales' => $currentSales,
            'last_month_sales' => $lastMonthSales,
            'current_revenue' => $currentRevenue,
            'last_month_revenue' => $lastMonthRevenue,
        ];
    }

    private function getTopPerformers()
    {
        return [
            'top_product' => Product::select('products.*', DB::raw('COUNT(sold_products.id) as sales_count'))
                ->leftJoin('sold_products', 'products.id', '=', 'sold_products.product_id')
                ->groupBy('products.id')
                ->orderBy('sales_count', 'desc')
                ->first(),
            
            'top_employee' => User::select('users.*', DB::raw('COUNT(sold_products.id) as sales_count'))
                ->leftJoin('sold_products', 'users.id', '=', 'sold_products.user_id')
                ->where('users.role', 'employee')
                ->groupBy('users.id')
                ->orderBy('sales_count', 'desc')
                ->first(),
            
            'top_region' => Owner::select('country', DB::raw('COUNT(sold_products.id) as sales_count'))
                ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
                ->whereNotNull('country')
                ->groupBy('country')
                ->orderBy('sales_count', 'desc')
                ->first(),
        ];
    }

    private function getSystemHealthData()
    {
        // Store app start time in cache if not already set
        if (!\Cache::has('app_start_time')) {
            \Cache::forever('app_start_time', now());
        }
        $start = \Cache::get('app_start_time');
        $uptime = $this->formatUptime($start);
        return [
            'database_size' => $this->getDatabaseSize(),
            'total_records' => User::count() + Product::count() + SoldProduct::count() + Owner::count(),
            'audit_logs_count' => AuditLog::count(),
            'last_backup' => 'N/A', // You can implement backup tracking
            'system_uptime' => $uptime,
        ];
    }

    // Helper to format uptime duration
    private function formatUptime($start)
    {
        $start = $start instanceof \Carbon\Carbon ? $start : \Carbon\Carbon::parse($start);
        $diff = $start->diff(now());
        $parts = [];
        if ($diff->y) $parts[] = $diff->y . 'y';
        if ($diff->m) $parts[] = $diff->m . 'mo';
        if ($diff->d) $parts[] = $diff->d . 'd';
        if ($diff->h) $parts[] = $diff->h . 'h';
        if ($diff->i) $parts[] = $diff->i . 'm';
        if ($diff->s && count($parts) < 1) $parts[] = $diff->s . 's';
        return count($parts) ? implode(' ', $parts) : '0m';
    }

    private function getDatabaseSize()
    {
        try {
            $size = DB::select("SELECT 
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'size_mb'
                FROM information_schema.tables 
                WHERE table_schema = ?", [config('database.connections.mysql.database')]);
            
            return $size[0]->size_mb ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getEmployeeDailySales($userId)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $sales = SoldProduct::where('user_id', $userId)->whereDate('created_at', $date)->count();
            
            $data[] = [
                'date' => $date->format('M d'),
                'sales' => $sales
            ];
        }
        return $data;
    }

    private function getEmployeeMonthlyPerformance($userId)
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $sales = SoldProduct::where('user_id', $userId)
                               ->whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count();
            
            $data[] = [
                'month' => $date->format('M Y'),
                'sales' => $sales
            ];
        }
        return $data;
    }

    private function getEmployeeRecentActivity($userId)
    {
        return AuditLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get dashboard data via AJAX for real-time updates
     */
    public function getRealTimeData(Request $request)
    {
        $type = $request->get('type', 'all');
        
        switch ($type) {
            case 'sales':
                return response()->json([
                    'today_sales' => SoldProduct::whereDate('created_at', today())->count(),
                    'today_revenue' => SoldProduct::whereDate('created_at', today())->sum('purchase_price'),
                ]);
                
            case 'activity':
                return response()->json([
                    'recent_activity' => $this->getRecentActivityData()
                ]);
                
            case 'system':
                return response()->json([
                    'system_health' => $this->getSystemHealthData()
                ]);
                
            default:
                return response()->json([
                    'stats' => [
                        'today_sales' => SoldProduct::whereDate('created_at', today())->count(),
                        'today_revenue' => SoldProduct::whereDate('created_at', today())->sum('purchase_price'),
                        'unread_messages' => ContactMessage::where('is_read', false)->count(),
                    ]
                ]);
        }
    }
}
