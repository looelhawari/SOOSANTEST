<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'company',
        'address',
        'city',
        'country',
        'preferred_language',
    ];

    // Relationships
    public function soldProducts()
    {
        return $this->hasMany(SoldProduct::class);
    }
}
