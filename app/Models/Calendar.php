<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'desc', 'slug', 'time', 'customer_id', 'status'
    ];

    public  function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
