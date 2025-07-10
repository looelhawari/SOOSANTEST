<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Services\NotificationService;

class AuditLogObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the AuditLog "created" event.
     */
    public function created(AuditLog $auditLog): void
    {
        // Notify admins of important audit logs
        $this->notificationService->notifyImportantAuditLog($auditLog);
    }
}
