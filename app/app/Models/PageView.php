<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 'page', 'last_visit'
    ];

    protected $casts = [
        'last_visit' => 'datetime',
    ];
}