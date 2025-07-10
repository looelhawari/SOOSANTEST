<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        \App\Models\ContactMessage::observe(\App\Observers\ContactMessageObserver::class);
        \App\Models\PendingChange::observe(\App\Observers\PendingChangeObserver::class);
        \App\Models\AuditLog::observe(\App\Observers\AuditLogObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
