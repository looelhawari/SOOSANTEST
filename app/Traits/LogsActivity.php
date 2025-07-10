<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Boot the trait
     */
    protected static function bootLogsActivity()
    {
        // Log when a model is created
        static::created(function (Model $model) {
            $model->logActivity('created');
        });

        // Log when a model is updated
        static::updated(function (Model $model) {
            // Only log if data actually changed
            if ($model->wasChanged() && !empty($model->getChanges())) {
                $model->logActivity('updated');
            }
        });

        // Log when a model is deleted
        static::deleted(function (Model $model) {
            $model->logActivity('deleted');
        });
    }

    /**
     * Log activity for the model
     */
    protected function logActivity(string $event)
    {
        // Skip logging if explicitly disabled
        if (property_exists($this, 'disableLogging') && $this->disableLogging) {
            return;
        }

        // Skip logging for certain events if configured
        if (property_exists($this, 'excludeEvents') && in_array($event, $this->excludeEvents)) {
            return;
        }

        $attributes = $this->getAuditableAttributes();
        
        // Prepare old and new values
        $oldValues = null;
        $newValues = null;

        switch ($event) {
            case 'created':
                $newValues = $attributes;
                break;
                
            case 'updated':
                $changes = $this->getChanges();
                $original = $this->getOriginal();
                $auditableFields = $this->getAuditableFields();
                
                // Filter out non-auditable fields from changes and original
                $newValues = array_intersect_key($changes, array_flip($auditableFields));
                
                // Only include original values for fields that actually changed and are auditable
                $oldValues = [];
                foreach ($newValues as $field => $newValue) {
                    if (array_key_exists($field, $original)) {
                        $oldValues[$field] = $original[$field];
                    }
                }
                break;
                
            case 'deleted':
                $oldValues = $attributes;
                break;
        }

        // Create the audit log entry
        AuditLog::create([
            'user_id' => $this->getCurrentUserId(),
            'event' => $event,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $this->getClientIpAddress(),
            'user_agent' => Request::header('User-Agent'),
            'url' => Request::fullUrl(),
            'method' => Request::method(),
        ]);
    }

    /**
     * Get the current user ID safely
     */
    protected function getCurrentUserId()
    {
        try {
            return Auth::check() ? Auth::id() : null;
        } catch (\Exception $e) {
            // Handle cases where auth is not available (e.g., in queue jobs, seeders)
            return null;
        }
    }

    /**
     * Get client IP address
     */
    protected function getClientIpAddress()
    {
        try {
            return Request::ip();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get attributes that should be audited
     */
    protected function getAuditableAttributes()
    {
        $attributes = $this->getAttributes();
        
        // Remove hidden fields (like passwords)
        $hidden = $this->getHidden();
        if (!empty($hidden)) {
            $attributes = array_diff_key($attributes, array_flip($hidden));
        }

        // Remove timestamps if not explicitly included
        if (!$this->shouldLogTimestamps()) {
            unset($attributes['created_at'], $attributes['updated_at']);
        }

        // Only include fields that are in the auditable fields list (if specified)
        $auditableFields = $this->getAuditableFields();
        if (!empty($auditableFields)) {
            $attributes = array_intersect_key($attributes, array_flip($auditableFields));
        }

        return $attributes;
    }

    /**
     * Get the list of fields that should be audited
     */
    protected function getAuditableFields()
    {
        // Start with all possible fields
        $fields = [];
        
        // If model has $auditableFields property, use it
        if (property_exists($this, 'auditableFields') && is_array($this->auditableFields)) {
            $fields = $this->auditableFields;
        } 
        // If model has $fillable, use it as a base
        elseif (!empty($this->getFillable())) {
            $fields = $this->getFillable();
        } 
        // Otherwise, audit all fields
        else {
            $fields = array_keys($this->getAttributes());
        }
        
        // Always exclude hidden fields
        $hidden = $this->getHidden();
        if (!empty($hidden)) {
            $fields = array_diff($fields, $hidden);
        }
        
        // Exclude timestamps if not explicitly included
        if (!$this->shouldLogTimestamps()) {
            $fields = array_diff($fields, ['created_at', 'updated_at']);
        }
        
        return $fields;
    }

    /**
     * Check if timestamps should be logged
     */
    protected function shouldLogTimestamps()
    {
        return property_exists($this, 'logTimestamps') ? $this->logTimestamps : false;
    }

    /**
     * Get audit logs for this model
     */
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    /**
     * Get the latest audit log for this model
     */
    public function latestAuditLog()
    {
        return $this->auditLogs()->latest()->first();
    }

    /**
     * Get audit logs for a specific event
     */
    public function auditLogsForEvent($event)
    {
        return $this->auditLogs()->where('event', $event);
    }

    /**
     * Temporarily disable logging for this model instance
     */
    public function disableLogging()
    {
        $this->disableLogging = true;
        return $this;
    }

    /**
     * Re-enable logging for this model instance
     */
    public function enableLogging()
    {
        $this->disableLogging = false;
        return $this;
    }

    /**
     * Execute a callback without logging
     */
    public function withoutLogging(callable $callback)
    {
        $this->disableLogging();
        $result = $callback($this);
        $this->enableLogging();
        return $result;
    }
}
