<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_url',
        'scheduled_time',
        'status',
    ];
    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'post_platforms')
            ->withPivot('platform_status', 'platform_response')
            ->using(PostPlatform::class);
    }
}
