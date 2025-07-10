<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use LogsActivity;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company',
        'phone',
        'subject',
        'message',
        'newsletter',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'newsletter' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Helper method to mark the message as read
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    // Helper method to get the full name
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
