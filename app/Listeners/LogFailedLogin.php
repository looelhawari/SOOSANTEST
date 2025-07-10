<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;

class LogFailedLogin
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Failed $event)
    {
        try {
            AuditLog::create([
                'user_id' => null,
                'event' => 'login_failed',
                'auditable_type' => 'Authentication',
                'auditable_id' => 0,
                'old_values' => null,
                'new_values' => [
                    'event' => 'login_failed',
                    'attempted_email' => $event->credentials['email'] ?? 'unknown',
                    'timestamp' => now(),
                    'user_agent' => $this->request->header('User-Agent'),
                    'ip_address' => $this->request->ip(),
                ],
                'ip_address' => $this->request->ip(),
                'user_agent' => $this->request->header('User-Agent'),
                'url' => $this->request->fullUrl(),
                'method' => $this->request->method(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log failed login attempt: ' . $e->getMessage());
        }
    }
}
