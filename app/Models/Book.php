<?php

// app/Models/Book.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'summary',
        'pages',
        'published_at',
        'cover',
        'category_id',
        'status',
    ];

    protected $dates = ['published_at'];

    protected $casts = [
    'published_at' => 'datetime',
];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function scopePopular($query)
    {
        return $query->withCount('reviews')->orderBy('reviews_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
