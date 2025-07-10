<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification
{
    use Queueable;

    protected $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'new_contact_message',
            'title' => 'New Contact Message',
            'message' => 'New message from ' . $this->contactMessage->full_name,
            'subject' => $this->contactMessage->subject,
            'sender_name' => $this->contactMessage->full_name,
            'sender_email' => $this->contactMessage->email,
            'contact_message_id' => $this->contactMessage->id,
            'created_at' => $this->contactMessage->created_at->format('Y-m-d H:i:s'),
            'icon' => 'fas fa-envelope',
            'color' => 'info',
            'url' => route('admin.contact-messages.show', $this->contactMessage->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'new_contact_message',
            'title' => 'New Contact Message',
            'message' => 'New message from ' . $this->contactMessage->full_name,
            'data' => $this->toArray($notifiable),
        ];
    }
}
