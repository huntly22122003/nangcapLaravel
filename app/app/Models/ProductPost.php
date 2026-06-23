<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'content',
        'posted_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}