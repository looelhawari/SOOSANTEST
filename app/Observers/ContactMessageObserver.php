<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Services\NotificationService;

class ContactMessageObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the ContactMessage "created" event.
     */
    public function created(ContactMessage $contactMessage): void
    {
        // Notify admins of new contact message
        $this->notificationService->notifyNewContactMessage($contactMessage);
    }
}
