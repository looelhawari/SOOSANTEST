<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SerialLookupController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicController::class, 'homepage'])->name('homepage');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::get('/privacy', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');
Route::get('/support', [PublicController::class, 'support'])->name('support');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category:id}', [ProductController::class, 'category'])->name('products.category');

// Serial lookup routes
Route::get('/serial-lookup', [SerialLookupController::class, 'index'])->name('serial-lookup.index');
Route::post('/serial-lookup', [SerialLookupController::class, 'lookup'])->name('serial-lookup.lookup');

// Language switching route
Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return redirect()->back();
})->name('lang.switch');

// Debug route
Route::get('/debug-admin', function () {
    $user = \App\Models\User::where('email', 'admin@example.com')->first();
    if ($user) {
        return response()->json([
            'user_exists' => true,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_admin' => $user->isAdmin(),
        ]);
    }
    return response()->json(['user_exists' => false]);
});

// Test route
Route::get('/test', function () {
    return 'Laravel is working!';
});

// Test notification routes (remove these in production)
Route::middleware('auth')->group(function () {
    Route::get('/test-notifications', function () {
        return view('test.notifications');
    })->name('test.notifications.index');
    
    Route::get('/test-notifications/contact', [App\Http\Controllers\TestNotificationController::class, 'testContactMessage'])->name('test.contact');
    Route::get('/test-notifications/pending', [App\Http\Controllers\TestNotificationController::class, 'testPendingChange'])->name('test.pending');
    Route::get('/test-notifications/rejection', [App\Http\Controllers\TestNotificationController::class, 'testRejection'])->name('test.rejection');
    Route::get('/test-notifications/approval', [App\Http\Controllers\TestNotificationController::class, 'testApproval'])->name('test.approval');
    Route::get('/test-notifications/audit', [App\Http\Controllers\TestNotificationController::class, 'testAuditLog'])->name('test.audit');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/image', [ProfileController::class, 'removeImage'])->name('profile.remove-image');
    Route::post('/profile/check-password', [App\Http\Controllers\ProfileController::class, 'checkPassword'])->name('profile.check-password');
    
    // Notification routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/fetch', [App\Http\Controllers\NotificationController::class, 'fetch'])->name('notifications.fetch');
    
    // API-style notification routes for AJAX calls
    Route::get('/api/notifications', [App\Http\Controllers\Api\NotificationApiController::class, 'index'])->name('api.notifications.index');
    Route::get('/api/notifications/check', [App\Http\Controllers\Api\NotificationApiController::class, 'check'])->name('api.notifications.check');
    Route::post('/api/notifications/{id}/mark-as-read', [App\Http\Controllers\Api\NotificationApiController::class, 'markAsRead'])->name('api.notifications.mark-as-read');
    Route::post('/api/notifications/mark-all-as-read', [App\Http\Controllers\Api\NotificationApiController::class, 'markAllAsRead'])->name('api.notifications.mark-all-as-read');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
