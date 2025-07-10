<?php

namespace App\Notifications;

use App\Models\PendingChange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeApprovedNotification extends Notification
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
            ->subject('Your Change Request Has Been Approved')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Great news! Your change request has been approved.')
            ->line('**Model:** ' . $this->pendingChange->getModelNameAttribute())
            ->line('**Action:** ' . ucfirst($this->pendingChange->action))
            ->line('**Approved by:** ' . $this->pendingChange->reviewedBy->name)
            ->line('**Approved at:** ' . $this->pendingChange->reviewed_at->format('Y-m-d H:i:s'))
            ->when($this->pendingChange->review_notes, function ($mail) {
                return $mail->line('**Notes:** ' . $this->pendingChange->review_notes);
            })
            ->line('Your changes have been applied successfully.')
            ->salutation('Best regards, ' . config('app.name') . ' Team');
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'change_approved',
            'title' => 'Change Request Approved',
            'message' => 'Your change request for ' . $this->pendingChange->getModelNameAttribute() . ' has been approved.',
            'notes' => $this->pendingChange->review_notes,
            'pending_change_id' => $this->pendingChange->id,
            'approved_by' => $this->pendingChange->reviewedBy->name,
            'approved_at' => $this->pendingChange->reviewed_at->format('Y-m-d H:i:s'),
            'icon' => 'fas fa-check-circle',
            'color' => 'success',
            'url' => route('admin.pending-changes.history'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'change_approved',
            'title' => 'Change Request Approved',
            'message' => 'Your change request has been approved!',
            'data' => $this->toArray($notifiable),
        ];
    }
}
