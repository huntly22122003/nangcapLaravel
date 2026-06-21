<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'extraname', 'slug', 'code', 'price',
        'brand', 'origin', 'model_no', 'summary', 'description',
        'technic_info', 'thumbnail', 'is_new', 'is_featured',
        'has_gallery', 'sort_order', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}