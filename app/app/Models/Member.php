<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'fullname', 'email', 'phone', 'address',
        'username', 'password', 'points', 'content', 'avatar', 'is_active'
    ];

    protected $hidden = [
        'password',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}