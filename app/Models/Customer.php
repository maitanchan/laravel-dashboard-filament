<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Đảm bảo tên bảng chính xác ở đây.

    protected $fillable = [
        'image', 'name', 'slug',  'date', 'phone', 'gender', 'social', 'email', 'rank', 'desc'
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}
