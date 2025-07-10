<?php

namespace App\Observers;

use App\Models\PendingChange;
use App\Services\NotificationService;

class PendingChangeObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the PendingChange "created" event.
     */
    public function created(PendingChange $pendingChange): void
    {
        // Notify admins of new pending change
        $this->notificationService->notifyNewPendingChange($pendingChange);
    }
}
