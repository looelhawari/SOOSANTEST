<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'url',
        'method',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the user that performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auditable model
     */
    public function auditable()
    {
        return $this->morphTo();
    }

    /**
     * Get a human-readable description of the audit log
     */
    public function getDescriptionAttribute()
    {
        $modelName = class_basename($this->auditable_type);
        $userName = $this->user ? $this->user->name : 'System';
        
        switch ($this->event) {
            case 'created':
                return "{$userName} created a new {$modelName}";
            case 'updated':
                return "{$userName} updated {$modelName} #{$this->auditable_id}";
            case 'deleted':
                return "{$userName} deleted {$modelName} #{$this->auditable_id}";
            default:
                return "{$userName} performed {$this->event} on {$modelName} #{$this->auditable_id}";
        }
    }

    /**
     * Get the changed fields with their old and new values
     */
    public function getChangedFieldsAttribute()
    {
        if ($this->event !== 'updated' || !$this->old_values || !$this->new_values) {
            return [];
        }

        $changes = [];
        foreach ($this->new_values as $field => $newValue) {
            $oldValue = $this->old_values[$field] ?? null;
            if ($oldValue != $newValue) {
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }

        return $changes;
    }

    /**
     * Scope to filter by model type
     */
    public function scopeForModel($query, $modelType)
    {
        return $query->where('auditable_type', $modelType);
    }

    /**
     * Scope to filter by event type
     */
    public function scopeForEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope to filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
