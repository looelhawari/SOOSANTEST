<?php

namespace App\Notifications;

use App\Models\PendingChange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPendingChangeNotification extends Notification
{
    use Queueable;

    protected $pendingChange;

    public function __construct(PendingChange $pendingChange)
    {
        $this->pendingChange = $pendingChange;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'new_pending_change',
            'title' => 'New Change Request',
            'message' => 'New change request from ' . $this->pendingChange->requestedBy->name,
            'model_type' => $this->pendingChange->getModelNameAttribute(),
            'action' => ucfirst($this->pendingChange->action),
            'requested_by' => $this->pendingChange->requestedBy->name,
            'pending_change_id' => $this->pendingChange->id,
            'created_at' => $this->pendingChange->created_at->format('Y-m-d H:i:s'),
            'icon' => 'fas fa-clock',
            'color' => 'warning',
            'url' => route('admin.pending-changes.show', $this->pendingChange->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'new_pending_change',
            'title' => 'New Change Request',
            'message' => 'New change request from ' . $this->pendingChange->requestedBy->name,
            'data' => $this->toArray($notifiable),
        ];
    }
}
