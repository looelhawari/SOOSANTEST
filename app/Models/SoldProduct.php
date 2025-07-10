<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id',
        'owner_id',
        'user_id',
        'serial_number',
        'sale_date',
        'warranty_start_date',
        'warranty_end_date',
        'purchase_price',
        'notes',
        'warranty_voided',
        'warranty_void_reason',
        'warranty_voided_by',
        'warranty_voided_at',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
        'purchase_price' => 'decimal:2',
        'warranty_voided_at' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function warrantyVoidedBy()
    {
        return $this->belongsTo(User::class, 'warranty_voided_by');
    }

    // Helper methods
    public function isUnderWarranty()
    {
        // If the warranty is voided, it's not under warranty regardless of dates
        if ($this->warranty_voided ?? false) {
            return false;
        }
        return now()->between($this->warranty_start_date, $this->warranty_end_date);
    }

    /**
     * Void the warranty for this sold product.
     *
     * @param string $reason
     * @param \App\Models\User $user
     * @return bool
     */
    public function voidWarranty($reason, $user)
    {
        if ($this->warranty_voided) {
            return false;
        }
        $this->update([
            'warranty_voided' => true,
            'warranty_void_reason' => $reason,
            'warranty_voided_by' => $user->id,
            'warranty_voided_at' => now(),
        ]);
        return true;
    }
}
