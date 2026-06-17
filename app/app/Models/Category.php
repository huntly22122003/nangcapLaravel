<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'sort_order', 'is_home', 'is_active'
    ];

    // Quan hệ cha-con (self)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Quan hệ với Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Quan hệ với Post
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // Quan hệ với Member (nếu có category cho member)
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}