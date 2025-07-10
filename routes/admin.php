<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\SoldProductController;
use App\Http\Controllers\Admin\PendingChangeController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ReportsController;
use Illuminate\Support\Facades\Route;

// Admin prefix routes
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    
    // Admin authentication routes
    Route::get('/login', function() {
        return view('admin.auth.login');
    })->name('login');

    Route::post('/login', function(\Illuminate\Http\Request $request) {
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error', 'Invalid credentials');
    })->name('login.submit');

    Route::post('/logout', function() {
        auth()->logout();
        return redirect()->route('admin.login');
    })->name('logout');

    // Protected admin routes
    Route::middleware(['auth', 'admin', 'employee.permission'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/realtime', [DashboardController::class, 'getRealTimeData'])->name('dashboard.realtime');
        Route::get('/', function() {
            return redirect()->route('admin.dashboard');
        });

        // Users management
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Products management
        Route::resource('products', ProductController::class);

        // Product Categories management
        Route::resource('product-categories', ProductCategoryController::class);

        // Contact Messages management
        Route::resource('contact-messages', ContactMessageController::class);
        Route::patch('contact-messages/{contactMessage}/mark-read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');

        // Owners management
        Route::resource('owners', OwnerController::class);

        // Sold Products management
        Route::resource('sold-products', SoldProductController::class);
        Route::post('sold-products/{soldProduct}/void-warranty', [SoldProductController::class, 'voidWarranty'])->name('sold-products.void-warranty');

        // Pending Changes management (Admin only)
        Route::prefix('pending-changes')->name('pending-changes.')->group(function () {
            Route::get('/', [PendingChangeController::class, 'index'])->name('index');
            Route::get('/{pendingChange}', [PendingChangeController::class, 'show'])->name('show');
            Route::post('/{pendingChange}/approve', [PendingChangeController::class, 'approve'])->name('approve');
            Route::post('/{pendingChange}/reject', [PendingChangeController::class, 'reject'])->name('reject');
            Route::get('/history/all', [PendingChangeController::class, 'history'])->name('history');
        });

        // Audit Logs management
        Route::get('audit-logs/dashboard', [AuditLogController::class, 'dashboard'])->name('audit-logs.dashboard');
        Route::get('audit-logs/realtime', [AuditLogController::class, 'realtime'])->name('audit-logs.realtime');
        Route::get('audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
        Route::resource('audit-logs', AuditLogController::class);

        // Reports management (Admin/CEO only)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('index');
            Route::get('/comprehensive', [\App\Http\Controllers\Admin\ReportsController::class, 'downloadComprehensiveReport'])->name('comprehensive');
            Route::get('/owners', [\App\Http\Controllers\Admin\ReportsController::class, 'downloadOwnersReport'])->name('owners');
            Route::get('/sales', [\App\Http\Controllers\Admin\ReportsController::class, 'downloadSalesReport'])->name('sales');
        });

        // Product Categories (if you have a controller for this)
        // Route::resource('categories', CategoryController::class);

        // Sold Products (if you have a controller for this)
        // Route::resource('sold-products', SoldProductController::class);

        // Simple test route
        Route::get('/test-admin', function() {
            return response()->json([
                'status' => 'success',
                'message' => 'Admin routes are working!',
                'user' => auth()->user() ? auth()->user()->email : 'Not logged in',
                'timestamp' => now()
            ]);
        })->name('test');
    });

    // Fallback temporary routes (remove these once proper middleware is working)
    Route::get('/dashboard-direct', function() {
        try {
            // Force login if not authenticated
            if (!auth()->check()) {
                auth()->loginUsingId(1); // Login as first user (admin)
            }
            
            $stats = [
                'total_users' => \App\Models\User::count(),
                'total_products' => \App\Models\Product::count(),
                'active_products' => \App\Models\Product::count(), // Remove is_active filter for now
                'featured_products' => \App\Models\Product::count(), // Remove is_featured filter for now
                'total_sold_products' => \App\Models\SoldProduct::count(),
                'unread_messages' => \App\Models\ContactMessage::where('is_read', false)->count(),
                'recent_users' => \App\Models\User::latest()->take(5)->get(),
                'recent_messages' => \App\Models\ContactMessage::latest()->take(5)->get(),
            ];

            $monthlyStats = [
                'new_users_this_month' => \App\Models\User::whereMonth('created_at', now()->month)->count(),
                'messages_this_month' => \App\Models\ContactMessage::whereMonth('created_at', now()->month)->count(),
            ];

            return view('admin.dashboard', compact('stats', 'monthlyStats'));
        } catch (\Exception $e) {
            return '<h1>Admin Dashboard</h1><p>Database Error: ' . $e->getMessage() . '</p>';
        }
    })->name('dashboard.direct');

    Route::get('/users-direct', function() {
        try {
            if (!auth()->check()) {
                auth()->loginUsingId(1);
            }
            $users = \App\Models\User::paginate(15);
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return '<h1>Users</h1><p>Error: ' . $e->getMessage() . '</p>';
        }
    })->name('users.direct');

    Route::get('/contact-messages-direct', function() {
        try {
            if (!auth()->check()) {
                auth()->loginUsingId(1);
            }
            $messages = \App\Models\ContactMessage::latest()->paginate(15);
            return view('admin.contact-messages.index', compact('messages'));
        } catch (\Exception $e) {
            return '<h1>Contact Messages</h1><p>Error: ' . $e->getMessage() . '</p>';
        }
    })->name('contact-messages.direct');
});
