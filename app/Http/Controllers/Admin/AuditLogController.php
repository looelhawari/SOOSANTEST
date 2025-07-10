<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs with advanced filtering
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by event type
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('auditable_type', $request->model_type);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search in changes
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('old_values', 'like', "%{$search}%")
                  ->orWhere('new_values', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        $auditLogs = $query->paginate(50)->appends($request->all());

        // Get filter options
        $events = AuditLog::distinct()->pluck('event')->sort();
        $modelTypes = AuditLog::distinct()->pluck('auditable_type')->sort();
        $users = DB::table('users')->select('id', 'name')->get();

        // Get statistics
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
            'this_week_logs' => AuditLog::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month_logs' => AuditLog::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('admin.audit-logs.index', compact(
            'auditLogs', 
            'events', 
            'modelTypes', 
            'users', 
            'stats'
        ));
    }

    /**
     * Display the specified audit log
     */
    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');
        
        // Get related audit logs for the same record
        $relatedLogs = AuditLog::where('auditable_type', $auditLog->auditable_type)
            ->where('auditable_id', $auditLog->auditable_id)
            ->where('id', '!=', $auditLog->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.audit-logs.show', compact('auditLog', 'relatedLogs'));
    }

    /**
     * Get real-time audit logs via AJAX
     */
    public function realtime(Request $request)
    {
        $lastId = $request->get('last_id', 0);
        
        $newLogs = AuditLog::with('user')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'logs' => $newLogs,
            'last_id' => $newLogs->first()?->id ?? $lastId
        ]);
    }

    /**
     * Dashboard stats for audit logs
     */
    public function dashboard()
    {
        // Recent activity
        $recentLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Activity by event type (last 30 days)
        $eventStats = AuditLog::where('created_at', '>=', now()->subDays(30))
            ->select('event', DB::raw('count(*) as count'))
            ->groupBy('event')
            ->orderBy('count', 'desc')
            ->get();

        // Activity by model type (last 30 days)
        $modelStats = AuditLog::where('created_at', '>=', now()->subDays(30))
            ->select('auditable_type', DB::raw('count(*) as count'))
            ->groupBy('auditable_type')
            ->orderBy('count', 'desc')
            ->get();

        // Daily activity for the last 7 days
        $dailyActivity = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = AuditLog::whereDate('created_at', $date)->count();
            $dailyActivity->push([
                'date' => $date->format('M d'),
                'count' => $count
            ]);
        }

        // Most active users (last 30 days)
        $activeUsers = AuditLog::where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->with('user')
            ->get();

        // Monthly activity for the last 12 months
        $monthlyActivity = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = AuditLog::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $monthlyActivity->push([
                'month' => $month->format('M Y'),
                'count' => $count
            ]);
        }

        // Total logs
        $totalLogs = AuditLog::count();
        // Unique users
        $uniqueUsers = AuditLog::whereNotNull('user_id')->distinct('user_id')->count('user_id');
        // Most active day (last 30 days)
        $mostActiveDayObj = AuditLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderByDesc('count')
            ->first();
        $mostActiveDay = $mostActiveDayObj
            ? ['date' => $mostActiveDayObj->date, 'count' => $mostActiveDayObj->count]
            : ['date' => '-', 'count' => 0];

        return view('admin.audit-logs.dashboard', compact(
            'recentLogs',
            'eventStats',
            'modelStats',
            'dailyActivity',
            'activeUsers',
            'monthlyActivity',
            'totalLogs',
            'uniqueUsers',
            'mostActiveDay'
        ));
    }

    /**
     * Export audit logs to CSV (user-friendly for non-technical users)
     */
    public function export(Request $request)
    {
        $query = AuditLog::with('user');

        // Apply same filters as index
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }
        if ($request->filled('model_type')) {
            $query->where('auditable_type', $request->model_type);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->get();
        $filename = 'audit_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        $locale = app()->getLocale();
        $trans = function($key, $default = null) use ($locale) {
            $t = __($key, [], $locale);
            return $t === $key ? ($default ?? $key) : $t;
        };
        $callback = function() use ($auditLogs, $trans) {
            $file = fopen('php://output', 'w');
            // User-friendly CSV headers (translated)
            fputcsv($file, [
                $trans('audit-logs.table.columns.time', 'Date/Time'),
                $trans('audit-logs.table.columns.user', 'User'),
                $trans('audit-logs.table.columns.event', 'Event'),
                $trans('audit-logs.table.columns.model', 'Model'),
                $trans('audit-logs.table.columns.details', 'Details'),
                $trans('audit-logs.table.columns.ip_address', 'IP Address'),
                $trans('audit-logs.table.columns.actions', 'Action'),
                $trans('audit-logs.modal.old_values', 'Old Values'),
                $trans('audit-logs.modal.new_values', 'New Values'),
            ]);
            foreach ($auditLogs as $log) {
                // User-friendly event
                $event = $trans('audit-logs.table.events.' . $log->event, ucfirst($log->event));
                // User-friendly model
                $model = class_basename($log->auditable_type);
                // User-friendly details
                $details = $log->url ? $log->url : $trans('audit-logs.table.na', 'N/A');
                // User-friendly user
                $user = $log->user ? $log->user->name : $trans('audit-logs.table.system', 'System');
                // Pretty-print old/new values (one per line for Excel)
                $prettyOld = self::prettyArray($log->old_values, $trans, true);
                $prettyNew = self::prettyArray($log->new_values, $trans, true);
                // Format time as readable (and not as Excel ######)
                $time = $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : $trans('audit-logs.table.na', 'N/A');
                fputcsv($file, [
                    $time,
                    $user,
                    $event,
                    $model,
                    $details,
                    $log->ip_address ?: $trans('audit-logs.table.na', 'N/A'),
                    $log->method ?: $trans('audit-logs.table.na', 'N/A'),
                    $prettyOld,
                    $prettyNew,
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Convert array or JSON to a pretty, readable string for CSV export (line breaks for Excel)
     */
    private static function prettyArray($value, $trans, $useLineBreaks = false)
    {
        if (empty($value)) return $trans('audit-logs.table.na', 'N/A');
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            } else {
                return $value;
            }
        }
        if (is_array($value)) {
            $lines = [];
            foreach ($value as $k => $v) {
                $lines[] = $k . ': ' . (is_scalar($v) ? $v : json_encode($v, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
            }
            $sep = $useLineBreaks ? "\n" : "; ";
            return implode($sep, $lines);
        }
        return (string)$value;
    }
}
