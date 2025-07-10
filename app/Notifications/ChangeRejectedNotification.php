<?php

namespace App\Notifications;

use App\Models\PendingChange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeRejectedNotification extends Notification
{
    use Queueable;

    protected $pendingChange;

    public function __construct(PendingChange $pendingChange)
    {
        $this->pendingChange = $pendingChange;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Change Request Has Been Rejected')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your change request has been rejected by an administrator.')
            ->line('**Model:** ' . $this->pendingChange->getModelNameAttribute())
            ->line('**Action:** ' . ucfirst($this->pendingChange->action))
            ->line('**Reason for rejection:** ' . $this->pendingChange->review_notes)
            ->line('**Reviewed by:** ' . $this->pendingChange->reviewedBy->name)
            ->line('**Reviewed at:** ' . $this->pendingChange->reviewed_at->format('Y-m-d H:i:s'))
            ->line('If you have any questions about this decision, please contact your administrator.')
            ->salutation('Best regards, ' . config('app.name') . ' Team');
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'change_rejected',
            'title' => 'Change Request Rejected',
            'message' => 'Your change request for ' . $this->pendingChange->getModelNameAttribute() . ' has been rejected.',
            'reason' => $this->pendingChange->review_notes,
            'pending_change_id' => $this->pendingChange->id,
            'reviewed_by' => $this->pendingChange->reviewedBy->name,
            'reviewed_at' => $this->pendingChange->reviewed_at->format('Y-m-d H:i:s'),
            'icon' => 'fas fa-times-circle',
            'color' => 'danger',
            'url' => route('admin.pending-changes.history'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'change_rejected',
            'title' => 'Change Request Rejected',
            'message' => 'Your change request has been rejected.',
            'data' => $this->toArray($notifiable),
        ];
    }
}
