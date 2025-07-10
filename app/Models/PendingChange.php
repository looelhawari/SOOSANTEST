<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingChange extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'model_type',
        'model_id',
        'action',
        'original_data',
        'new_data',
        'requested_by',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
    ];

    protected $casts = [
        'original_data' => 'array',
        'new_data' => 'array',
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function model()
    {
        return $this->morphTo();
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function approve(User $admin, ?string $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_by' => $admin->id,
            'reviewed_at' => now(),
            'review_notes' => $notes,
        ]);

        // Apply the changes to the actual model
        if ($this->action === 'update') {
            $model = $this->model_type::find($this->model_id);
            if ($model) {
                $model->update($this->new_data);
            }
        } elseif ($this->action === 'delete') {
            $model = $this->model_type::find($this->model_id);
            if ($model) {
                $model->delete();
            }
        }

        // Send notification to the employee who requested the change
        if ($this->requestedBy) {
            $this->requestedBy->notify(new \App\Notifications\ChangeApprovedNotification($this));
        }
    }

    public function reject(User $admin, ?string $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_by' => $admin->id,
            'reviewed_at' => now(),
            'review_notes' => $notes,
        ]);

        // Send notification to the employee who requested the change
        if ($this->requestedBy) {
            $this->requestedBy->notify(new \App\Notifications\ChangeRejectedNotification($this));
        }
    }

    public function getModelNameAttribute()
    {
        return class_basename($this->model_type);
    }

    public function getChangedFieldsAttribute()
    {
        if ($this->action === 'delete') {
            return ['Action' => 'Delete Record'];
        }

        $changes = [];
        foreach ($this->new_data as $key => $newValue) {
            $originalValue = $this->original_data[$key] ?? null;
            if ($originalValue != $newValue) {
                $changes[$key] = [
                    'from' => $originalValue,
                    'to' => $newValue
                ];
            }
        }
        return $changes;
    }
}
