<?php

namespace App\Notifications;

use App\Models\AuditLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantAuditLogNotification extends Notification
{
    use Queueable;

    protected $auditLog;

    public function __construct(AuditLog $auditLog)
    {
        $this->auditLog = $auditLog;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'important_audit_log',
            'title' => 'Important System Activity',
            'message' => 'Important system activity detected',
            'event' => $this->auditLog->event,
            'model_type' => $this->auditLog->auditable_type ? class_basename($this->auditLog->auditable_type) : 'System',
            'user_name' => $this->auditLog->user ? $this->auditLog->user->name : 'System',
            'audit_log_id' => $this->auditLog->id,
            'created_at' => $this->auditLog->created_at->format('Y-m-d H:i:s'),
            'icon' => 'fas fa-exclamation-triangle',
            'color' => 'danger',
            'url' => route('admin.audit-logs.show', $this->auditLog->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'important_audit_log',
            'title' => 'Important System Activity',
            'message' => 'Important system activity detected',
            'data' => $this->toArray($notifiable),
        ];
    }
}
