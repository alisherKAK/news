<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'news_id', 'content'
    ];

    function user() {
        return $this->belongsTo(User::class);
    }

    function news() {
        return $this->belongsTo(News::class);
    }
}
